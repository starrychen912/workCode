<?php

namespace app\api\controller;

use app\common\controller\FinderApi;
use think\Db;
use think\Exception;

use Shopify\Utils;
use Shopify\Context;
use Shopify\Auth\OAuth;
use Shopify\Auth\Session;
use Shopify\Clients\Rest;
use Shopify\Auth\FileSessionStorage;
use app\admin\model\product\Product;
use Ramsey\Uuid\Guid\Fields;
use think\Log;

use function GuzzleHttp\json_decode;
use function PHPSTORM_META\type;

/**
 * 插件产品接口
 */
class Productimport extends FinderApi
{
    // protected $noNeedLogin = ['*'];
    protected $noNeedRight = ['*'];
    
    private $oauthSessionId = 'ddinfotech_oauth_session';
    private $apiKey="3c6bac23c028babb12de1ca007c0f742";
    private $apiSecretKey="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";
    private $scopes="write_orders,read_orders,read_customers,write_products,read_products,read_product_listings";
    private $hostName="120.24.234.102";


    public function _initialize()
    {
       session_start();
       Context::initialize($this->apiKey,$this->apiSecretKey,$this->scopes,$this->hostName,new FileSessionStorage());
    }


    
    
    /**
     * 产品导入到shopify
     * @ApiMethod (POST)
     * @ApiParams (name="product_ids", type="integer", required=true, description="产品id")
     * @ApiParams (name="finder_user_id", type="integer", required=true, description="用户id")
     *
     */
    public function importToSohpify()
    {
        
        $product_id = $this->request->post('product_ids','');
        $finder_user_id = $this->request->post('finder_user_id','');
        if(empty($finder_user_id)||empty($product_id)){
          $this->error(__('Invalid parameters'));
        }

        $shopify_shop = Db::name('shop')->where(['finder_user_id'=>$finder_user_id,'type'=>'shopify'])->find();
        if(!$shopify_shop){
          $this->error(__('Undefind shopify shop'));
        }
        
        $where = [];
        if(!empty($product_id)){
          $where = [
                      'id'=>['in',$product_id],
                      'finder_user_id'=>$finder_user_id
                    ];
        }
        
        $product_list = Db::name('product_import')->where($where)->select();
        // var_dump($product_list);die;
        if(!$product_list){
          $this->error(__('Invalid parameters').'1');
        }

        $shop_name = Db::name('finder_user')->where(['id'=>$finder_user_id])->value('shop');

        foreach($product_list as $product){
            // $data = $product_list;
            $images = Db::name('product_import_images')->where(['import_id'=>$product['id']])->select();
            // $data['images'] = $images;
            $field = 'option1,option2,option3,cost,market_price as price,compare_at_price,sku,barcode,weight,weight_unit,inventory_quantity,image_id as img_id';
            $variants = Db::name('product_import_variants')->where(['import_id'=>$product['id']])->field($field)->select();
            // $data['variants'] = $variants;
            // var_dump($variants);var_dump($images);die;
            // var_dump($variants);die;
            $wait_data = [];
            $productObj=[
                'product'=> [
                  // 'id'=> $product['id'],
                  'title'=> $product['title'],
                  'body_html'=> $product['description'],
                  'vendor'=> $shop_name,
                  'product_type'=> $product['product_type'],
                  // 'created_at'=> $product['create_time'],
                  // 'handle'=> $product['handle'],
                  // 'updated_at'=> $product['update_time'],
                  // 'published_at'=> $product['create_time'],
                  // 'template_suffix'=> null,
                  // 'status'=> 'active',
                  // 'published_scope'=> 'web',
                  // 'tags'=> "Barnes & Noble, Big Air, John's Fav",
                  // 'admin_graphql_api_id'=> 'gid=>//shopify/Product/1071559582'
                    
                ]
            ];

                
                
            // }else{
              $productObj['product']['variants']=$variants;
              // foreach($variants as $k => $variant){
              //   $variants[$k]['country_code_of_origin'] = $product['nameengsp'];
              //   $variants[$k]['harmonized_system_code'] = $product['HScode'];
              // }
              
              $session = Context::$SESSION_STORAGE->loadSession($shop_name);
              $client = new Rest($session->getShop(), $session->getAccessToken());
              $response = $client->post('products',$productObj);
              $res=json_decode($response->getBody());
              // var_dump($res);die;
              if(!empty($res->errors))$this->error(__('Import fail'),$res->errors);

              //获取location
              $session = Context::$SESSION_STORAGE->loadSession($shop_name);
              $client = new Rest($session->getShop(), $session->getAccessToken());
              $response = $client->get(
                "locations"
              );
              $res_location=json_decode($response->getBody());
              $location_id = 0;
              foreach($res_location->locations as $k => $lo){
                if($lo->name != 'Oberlo'){
                  $location_id = $lo->id;
                }
              }

              if($location_id != 0){
                foreach($res->product->variants as $k => $var){

                  Db::name('product_import_variants')->where(['import_id'=>$product['id']])->update(['shopify_variant_id'=>$var->id]);

                // if(count($variants)==1){
                  $nameengsp = Db::name('country')->where(['id'=>$product['country_id']])->value('nameengsp');
                  $session = Context::$SESSION_STORAGE->loadSession($shop_name);
                  $client = new Rest($session->getShop(), $session->getAccessToken());
                  $response_res_items = $client->put("inventory_items/".$var->inventory_item_id,
                  [
                    "inventory_item" => [
                      "id" => $var->inventory_item_id,
                      "country_code_of_origin" => $nameengsp=='' ? null : $nameengsp,
                      "harmonized_system_code" => $product['HScode']=='' ? null : $product['HScode'],
                      "tracked" => "true"
                    ]
                  ]);
                  // var_dump($response_res_items);die;
                  $res_items=json_decode($response_res_items->getBody());
                  if(!empty($res_items->errors))$this->error(__('Import fail'),$res_items->errors);

                  $session = Context::$SESSION_STORAGE->loadSession($shop_name);
                  $client = new Rest($session->getShop(), $session->getAccessToken());
                  $response_res_inventory = $client->post("inventory_levels/set",
                  [
                    "location_id" => $location_id,
                    "inventory_item_id" => $var->inventory_item_id,
                    "available" => $variants[$k]['inventory_quantity']
                  ]);
                  $res_inventory=json_decode($response_res_inventory->getBody());
                  if(!empty($res_inventory->errors))$this->error(__('Import fail'.$location_id),$res_inventory->errors);
                }
              }

              if(count($variants)>1){
                foreach($images as $k => $img){
                    foreach($variants as $k => $variant){
                      if($variant['img_id'] == $img['id']){
                        $wait_data[] = [
                          'type'=>2,
                          'shop_name'=>$shop_name,
                          'sku'=>$variant['sku'],
                          'product_id'=>$res->product->id,
                          'variant_id'=>$res->product->variants[$k]->id,
                          'src'=>'https://interface.ddtechinfo.com/'.$img['src']
                          ];
                          unset($images['$k']);
                      }
                  }
                }
              }
                

                if(!empty($images)){
                  foreach($images as $k => $img){
                    $wait_data[] = [
                      'shop_name'=>$shop_name,
                      'product_id'=>$res->product->id,
                      'src'=>'https://interface.ddtechinfo.com/'.$img['src']
                      ];
                   }
                }
            // }

            
            
            

            
            // var_dump($img_ids);
            
            // var_dump($wait_data);die;

            //使用redis
            $redis = new \Redis;
            $redis->connect('127.0.0.1',6379);
            foreach($wait_data as $v){
              $redis->lPush('wait_import_images',json_encode($v));
            }

            //更新列表状态
            Db::name('product')->where(['id'=>$product['product_id']])->setinc('imports');
            Db::name('product_import')->where(['id'=>$product['id']])->update(['is_inport'=>1,'shopify_product_id'=>$res->product->id]);
        }
        

        $this->success(__('successful'));
    }



    /**
     * 产品列表
     * @ApiMethod (POST)
     * @ApiParams (name="product_id", type="integer", required=false, description="产品id")
     * @ApiParams (name="finder_user_id", type="integer", required=true, description="用户id")
     * @ApiParams (name="shop_id", type="string", required=false, description="店铺id")
     * @ApiParams (name="keyword", type="string", required=false, description="搜索词")
     * @ApiParams (name="page_num", type="integer", required=false, description="第几页")
     * @ApiParams (name="per_page_num", type="integer", required=false, description="每页数量")
     */
    public function produtList()
    {
        $product_id = $this->request->post('product_id','');
        $finder_user_id = $this->request->post('finder_user_id','');
        $shop_id = $this->request->post('shop_id','');
        $keyword = $this->request->post('keyword','');
        $page_num = $this->request->post('page_num',1);
        $per_page_num = $this->request->post('per_page_num',10);
        if(empty($finder_user_id)){
          $this->error(__('Invalid parameters'));
        }
        $where = [];
        if(!empty($product_id)){
          $where['id'] = $product_id;
        }
        if(!empty($shop_id)){
          $where['shop_id'] = $shop_id;
        }
        if(empty($shop_id) && empty($product_id)){
          $where['is_open'] = 1;
        }
        if(!empty($keyword)){
          $where['title'] = ['like', "%$keyword%"];
        }
        
        $data = [];
        $product_list = \app\admin\model\product\Product::where($where)->order('id desc')->paginate($per_page_num,false,['page'=>$page_num]);
        // var_dump($where);die;
        // $data = $product_list;
        $data = [
          'total'     => $product_list->total(),         // 总记录数
          'cur'       => $product_list->currentPage(),   // 当前页码
          'size'      => $product_list->listRows(),      // 每页记录数
          'data'      => $product_list->items()          // 分页数据
        ];
        foreach($product_list as $k=>$v){
            $images = \app\admin\model\product\Images::where(['product_id'=>$v->id])->select();
            if($images){
              foreach($images as $i => $img){
                $str="/^http(s?):\/\/(?:[A-za-z0-9-]+\.)+[A-za-z]{2,4}(?:[\/\?#][\/=\?%\-&~`@[\]\':+!\.#\w]*)?$/";
                if (!preg_match($str,$images[$i]['src'])){
                  $images[$i]['src'] = 'https://interface.ddtechinfo.com/'.$images[$i]['src'];
                }
              }
            }
            // $this->success(__('successful'), $images);
            $data['data'][$k]['images'] = $images;
            $data['data'][$k]['options'] = [];
            $options = Db::name('product_options')->where(['product_id'=>$v->id])->select();
            if($options){
              $data['data'][$k]['options'] = $options;
            }
            $variants = \app\admin\model\product\Variants::where(['product_id'=>$v->id])->select();
            $data['data'][$k]['variants'] = $variants;

            $is_import = Db::name('product_import')->where(['product_id'=>$v->id,'finder_user_id'=>$finder_user_id])->find();
            $is_inport = Db::name('product_import')->where(['product_id'=>$v->id,'finder_user_id'=>$finder_user_id,'is_inport'=>1])->find();
            $data['data'][$k]['is_import'] = $is_import ? 1 : 0;
            $data['data'][$k]['is_inport'] = $is_inport ? 1 : 0;
        }

        $this->success(__('successful'), $data);
    }


    /**
     * 添加导入列表
     * @ApiMethod (POST)
     * @ApiParams (name="product_id", type="integer", required=true, description="产品id")
     * @ApiParams (name="finder_user_id", type="integer", required=true, description="用户id")
     */
    public function addToImportList()
    {
      $product_id = $this->request->post('product_id');
      $finder_user_id = $this->request->post('finder_user_id','');
      $product = Db::name('product')->where(['id'=>$product_id])->find();
      if(!$product || !$finder_user_id){
        $this->error(__('Invalid parameters'));
      }
      $shop_id = Db::name('shop')->where(['type'=>'shopify','finder_user_id'=>$finder_user_id])->value('id');
      if(!$shop_id>0){
        $this->error(__('Undefind Shop'));
      }
      // $product = collection($product)->toArray();
      // var_dump($product);die;
      Db::startTrans();
      try {
        $create_data = [
          'product_id'  =>  $product_id,
          'finder_user_id'  =>  $finder_user_id,
          'description'  =>  $product['description'],
          'status'  =>  $product['status'],
          'body_html'  =>  $product['body_html'],
          'handle'  =>  $product['handle'],
          'product_type'  =>  $product['product_type'],
          'title'  =>  $product['title'],
          'supplier_id'  =>  $product['supplier_id'],
          'category_id'  =>  $product['category_id'],
          'brand_id'  =>  $product['brand_id'],
          'product_data'  =>  $product['product_data'],
          'out_link'  =>  $product['out_link'],
          'shop_id'  =>  $shop_id,
          'country_id'  =>  $product['country_id'],
          'HScode'  =>  $product['HScode'],
          'create_time'  =>  time(),
        ];
        $import_id = Db::name('product_import')->insertGetId($create_data);
        $variants = Db::name('product_variants')->where(['product_id'=>$product_id])->select();
        if($import_id>0 && $variants){
          foreach($variants as $k => $var){
            $variants_data = [
              'import_id'  =>  $import_id,
              'sku'  =>  $var['sku'],
              'weight'  =>  $var['weight'],
              'weight_unit'  =>  $var['weight_unit'],
              'barcode'  =>  $var['barcode'],
              'compare_at_price'  =>  $var['compare_at_price'],
              'image_id'  =>  $var['image_id'],
              'cost'  =>  $var['cost'],
              'shipping'  =>  $var['shipping'],
              'market_price'  =>  $var['market_price'],
              'form'  =>  $var['form'],
              'bullet_point1'  =>  $var['bullet_point1'],
              'bullet_point2'  =>  $var['bullet_point2'],
              'bullet_point3'  =>  $var['bullet_point3'],
              'bullet_point4'  =>  $var['bullet_point4'],
              'bullet_point5'  =>  $var['bullet_point5'],
              'length'  =>  $var['length'],
              'width'  =>  $var['width'],
              'height'  =>  $var['height'],
              'option1'  =>  $var['option1'],
              'option2'  =>  $var['option2'],
              'option3'  =>  $var['option3'],
              'inventory_quantity' => $var['inventory_quantity'],
              'create_time'  =>  time(),
            ];
            $res_var = Db::name('product_import_variants')->insert($variants_data);
            if(!$res_var){
              Db::rollback();
              $this->error(__('Import is fail'));
            }
          }
        }

        $options = Db::name('product_options')->where(['product_id'=>$product_id])->select();
        if($import_id>0 && $options){
          foreach($options as $k => $op){
            $op_data = [
              'import_id'  =>  $import_id,
              'name'  =>  $op['name'],
              'values'  =>  $op['values'],
              'position'  =>  $op['position'],
              'create_time'  =>  time(),
            ];
            $res_img = Db::name('product_import_options')->insert($op_data);
            if(!$res_img){
              Db::rollback();
              $this->error(__('Import is fail'));
            }
          }
        }

        $images = Db::name('product_images')->where(['product_id'=>$product_id])->select();
        if($import_id>0 && $images){
          foreach($images as $k => $img){
            $images_data = [
              'import_id'  =>  $import_id,
              'src'  =>  $img['src'],
              'width'  =>  $img['width'],
              'height'  =>  $img['height'],
              'position'  =>  $img['position'],
              'variant_ids'  =>  $img['variant_ids'],
              'create_time'  =>  time(),
            ];
            $res_img = Db::name('product_import_images')->insert($images_data);
            if(!$res_img){
              Db::rollback();
              $this->error(__('Import is fail'));
            }
          }
        }
        Db::commit();
      } catch (Exception $e) {
        Db::rollback();
        $this->error($e->getMessage());
    }

      $this->success(__('Import is successful'));
    }


    /**
     * 获取导入列表
     * @ApiMethod (POST)
     * @ApiParams (name="finder_user_id", type="integer", required=true, description="用户id")
     * @ApiParams (name="page_num", type="integer", required=false, description="第几页")
     * @ApiParams (name="per_page_num", type="integer", required=false, description="每页数量")
     *
     */
    public function getImportList()
    {
      $finder_user_id = $this->request->post('finder_user_id');
      $page_num = $this->request->post('page_num',1);
      $per_page_num = $this->request->post('per_page_num',10);

      if(empty($finder_user_id)){
        $this->error(__('Invalid parameters'));
      }
      $product_list = \app\admin\model\product\Product_import::where(['finder_user_id'=>$finder_user_id,'is_inport'=>0])->order('id desc')->paginate($per_page_num,false,['page'=>$page_num]);
      $data = [];
      // $data = $product_list;
      $data = [
        'total'     => $product_list->total(),         // 总记录数
        'cur'       => $product_list->currentPage(),   // 当前页码
        'size'      => $product_list->listRows(),      // 每页记录数
        'data'      => $product_list->items()          // 分页数据
      ];
      // var_dump($data['total']);die;
        foreach($product_list as $k=>$v){
            $images = Db::name('product_import_images')->where(['import_id'=>$v['id']])->select();
            if($images){
              foreach($images as $i => $img){
                $str="/^http(s?):\/\/(?:[A-za-z0-9-]+\.)+[A-za-z]{2,4}(?:[\/\?#][\/=\?%\-&~`@[\]\':+!\.#\w]*)?$/";
                if (!preg_match($str,$images[$i]['src'])){
                  $images[$i]['src'] = 'https://interface.ddtechinfo.com/'.$images[$i]['src'];
                }
              }
            }
            $data['data'][$k]['images'] = $images;
            $data['data'][$k]['options'] = [];
            $options = Db::name('product_import_options')->where(['import_id'=>$v['id']])->select();
            if($options){
              $data['data'][$k]['options'] = $options;
            }
            $variants = Db::name('product_import_variants')->where(['import_id'=>$v['id']])->select();
            $data['data'][$k]['variants'] = $variants;

            $is_inport = Db::name('product_import')->where(['id'=>$v['id'],'is_inport'=>1])->find();
            $data['data'][$k]['is_inport'] = $is_inport ? 1 : 0;
        }

        $this->success(__('successful'), $data);
    }


    function tocurl($url, $header, $content){
      $ch = curl_init();
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
      curl_setopt($ch, CURLOPT_URL, $url);
      curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
      curl_setopt($ch, CURLOPT_POST, true);
      curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($content));
      $response = curl_exec($ch);
      if($error=curl_error($ch)){
          die($error);
      }
      curl_close($ch);
      return $response;
    }

    /**
     * 删除导入列表
     * @ApiMethod (POST)
     * @ApiParams (name="import_ids", type="string", required=true, description="导入产品id,多个以逗号隔开")
     * @ApiParams (name="finder_user_id", type="integer", required=true, description="用户id")
     */
    public function deleteImportList()
    {
      $import_ids = $this->request->post('import_ids');
      $finder_user_id = $this->request->post('finder_user_id','');
      if(!empty($import_ids) && !empty($finder_user_id)){
        Db::startTrans();
        try {
            $res = Db::name('product_import')->where('id in ('.$import_ids.') and finder_user_id = '.$finder_user_id)->delete();
            $res_img = Db::name('product_import_images')->where('import_id in ('.$import_ids.')')->delete();
            $res_var = Db::name('product_import_variants')->where('import_id in ('.$import_ids.')')->delete();
            // if(!$res || !$res_img || !$res_var){
            //   Db::rollback();
            //   $this->error(__('delete fail'));
            // }
            

            Db::commit();
          } catch (Exception $e) {
            Db::rollback();
            $this->error($e->getMessage());
        }
        
      }
      $this->success(__('successful'));
    }


    /**
     * 修改导入列表
     * @ApiMethod (POST)
     * @ApiParams (name="import_id", type="integer", required=true, description="导入产品id")
     * @ApiParams (name="finder_user_id", type="integer", required=true, description="用户id")
     * @ApiParams (name="sku", type="string", required=false, description="sku")
     * @ApiParams (name="bullet_point5", type="string", required=false, description="介绍")
     * @ApiParams (name="market_price", type="string", required=false, description="市场价")
     * @ApiParams (name="compare_at_price", type="string", required=false, description="原价")
     * @ApiParams (name="description", type="string", required=false, description="描述")
     */
    public function updateImportList()
    {
      $import_id = $this->request->post('import_id');
      $finder_user_id = $this->request->post('finder_user_id','');
      $sku = $this->request->post('sku','');
      $bullet_point5 = $this->request->post('bullet_point5','');
      $market_price = $this->request->post('market_price','');
      $compare_at_price = $this->request->post('compare_at_price','');
      $description = $this->request->post('description','',null);
      // $description = isset($_REQUEST['description']) ? $_REQUEST['description'] : '';
      if(empty($import_id) || empty($finder_user_id)){
        $this->error(__('Invalid parameters'));
      }
      $product_data = [];
      $variant_data = [];
      if(!empty($description)){
        $product_data['description'] = $description;
      }
      if(!empty($sku)){
        $variant_data['sku'] = $sku;
      }
      if(!empty($bullet_point5)){
        $variant_data['bullet_point5'] = $bullet_point5;
      }
      if(!empty($market_price)){
        $variant_data['market_price'] = $market_price;
      }
      if(!empty($compare_at_price)){
        $variant_data['compare_at_price'] = $compare_at_price;
      }
      // var_dump($description);
        Db::startTrans();
        try {
            if(!empty($product_data)){
              $res = Db::name('product_import')->where('id = '.$import_id.' and finder_user_id = '.$finder_user_id)->update($product_data);
              if(!$res){
                Db::rollback();
                $this->error(__('update fail'));
              }
            }
            if(!empty($variant_data)){
              $res_var = Db::name('product_import_variants')->where('import_id = '.$import_id)->update($variant_data);
              if(!$res_var){
                Db::rollback();
                $this->error(__('update fail'));
              }
            }
          
            Db::commit();
          } catch (Exception $e) {
            Db::rollback();
            $this->error($e->getMessage());
        }
        
      
      $this->success(__('successful'));
    }

    /**
     * 改变选中图片状态
     * @ApiMethod (POST)
     * @ApiParams (name="image_id", type="string", required=true, description="图片id")
     * @ApiParams (name="status", type="string", required=true, description="状态")
     */
    public function updateImageStatus()
    {
      $image_id = $this->request->post('image_id');
      $status = $this->request->post('status');
      if(!empty($image_id)){
            $res_img = Db::name('product_import_images')->where('id = '.$image_id)->update(['is_choice'=>$status]);
            if(!$res_img){
              $this->error(__('update fail'));
            }
        
      }
      $this->success(__('successful'));
    }

    /**
     * 改变选中属性状态
     * @ApiMethod (POST)
     * @ApiParams (name="variant_id", type="string", required=true, description="属性id")
     * @ApiParams (name="status", type="string", required=true, description="状态")
     */
    public function updateVariantStatus()
    {
      $variant_id = $this->request->post('variant_id');
      $status = $this->request->post('status');
      if(!empty($variant_id)){
            $res_img = Db::name('product_import_variants')->where('id = '.$variant_id)->update(['is_choice'=>$status]);
            if(!$res_img){
              $this->error(__('update fail'));
            }
        
      }
      $this->success(__('successful'));
    }


    /**
     * 已导入产品列表
     * @ApiMethod (POST)
     * @ApiParams (name="product_id", type="integer", required=false, description="产品id")
     * @ApiParams (name="finder_user_id", type="integer", required=true, description="用户id")
     * @ApiParams (name="shop_id", type="string", required=false, description="店铺id")
     * @ApiParams (name="keyword", type="string", required=false, description="搜索词")
     * @ApiParams (name="page_num", type="integer", required=false, description="第几页")
     * @ApiParams (name="per_page_num", type="integer", required=false, description="每页数量")
     */
    public function shopifyProdutList()
    {
      $product_id = $this->request->post('product_id','');
      $finder_user_id = $this->request->post('finder_user_id');
      $shop_id = $this->request->post('shop_id',0);
      $keyword = $this->request->post('keyword','');
      $page_num = $this->request->post('page_num',1);
      $per_page_num = $this->request->post('per_page_num',10);
      if(empty($finder_user_id)){
        $this->error(__('Invalid parameters'));
      }

      // $shop_id = Db::name()->where(['type'=>$shop_type,'finder_user_id'=>$finder_user_id])->value('id');
      // if(!$shop_id>0){
      //   $this->error(__('undefind shop'));
      // }
      $where = [];
      if(!empty($product_id)){
        $where['id'] = $product_id;
      }
      $where['finder_user_id'] = $finder_user_id;
      $where['is_inport'] = 1;
      if(!empty($shop_id)){
        $where['shop_id'] = $shop_id;
      }
      if(!empty($keyword)){
        $where['title'] = ['like',"%$keyword%"];
      }

      $product_ids = Db::name('product_import')->where($where)->column('id');
      $ids = implode(',', $product_ids);
      $data = [];
      
      if(empty($ids)){
        $this->success(__('successful'), $data);
      }
        // $product_list = Db::name('product_import')->where('id in ('.$ids.')')->order('id desc')->select();
        $product_list = \app\admin\model\product\Product_import::where('id in ('.$ids.')')->order('id desc')->paginate($per_page_num,false,['page'=>$page_num]);
        // var_dump($product_list);die;
        // $data = $product_list;
        $data = [
          'total'     => $product_list->total(),         // 总记录数
          'cur'       => $product_list->currentPage(),   // 当前页码
          'size'      => $product_list->listRows(),      // 每页记录数
          'data'      => $product_list->items()          // 分页数据
        ];
        foreach($product_list as $k=>$v){
            $images = Db::name('product_import_images')->where(['import_id'=>$v['id']])->select();
            if($images){
              foreach($images as $i => $img){
                $str="/^http(s?):\/\/(?:[A-za-z0-9-]+\.)+[A-za-z]{2,4}(?:[\/\?#][\/=\?%\-&~`@[\]\':+!\.#\w]*)?$/";
                if (!preg_match($str,$images[$i]['src'])){
                    $images[$i]['src'] = 'https://interface.ddtechinfo.com/'.$images[$i]['src'];
                  }
                }
            }
            $data['data'][$k]['images'] = $images;
            $data['data'][$k]['options'] = [];
            $options = Db::name('product_import_options')->where(['import_id'=>$v['id']])->select();
            if($options){
              $data['data'][$k]['options'] = $options;
            }
            $variants = Db::name('product_import_variants')->where(['import_id'=>$v['id']])->select();
            $data['data'][$k]['variants'] = $variants;
        }

        $this->success(__('successful'), $data);
    }


    /**
     * 获取所属店铺列表
     * @ApiMethod (POST)
     * @ApiParams (name="finder_user_id", type="integer", required=true, description="用户id")
     */
    public function getShopList()
    {
      $finder_user_id = $this->request->post('finder_user_id');
      if(empty($finder_user_id)){
        $this->error(__('Invalid parameters'));
      }
      $shop_list = Db::name('shop')->where(['finder_user_id'=>$finder_user_id])->field('id,name,address1,myshopify_domain,type')->select();
      if($shop_list){
        $this->success(__('successful'), $shop_list);
      }
      $this->error(__('undefind shop'));
    }


    /**
     * 获取所属店铺详情
     * @ApiMethod (POST)
     * @ApiParams (name="shop_id", type="string", required=true, description="店铺id")
     * @ApiParams (name="finder_user_id", type="integer", required=true, description="用户id")
     */
    public function getShopInfo()
    {
      $finder_user_id = $this->request->post('finder_user_id');
      $shop_id = $this->request->post('shop_id');
      if(empty($finder_user_id) || empty($shop_id)){
        $this->error(__('Invalid parameters'));
      }
      $shop_list = Db::name('shop')->where(['finder_user_id'=>$finder_user_id,'id'=>$shop_id])->field('id,name,address1,myshopify_domain,type')->find();
      if($shop_list){
        $this->success(__('successful'), $shop_list);
      }
      $this->error(__('undefind shop'));
    }

    /**
     * 删除店铺
     * @ApiMethod (POST)
     * @ApiParams (name="shop_id", type="integer", required=true, description="店铺id")
     */
    public function deleteShop()
    {
      $shop_id = $this->request->post('shop_id');
      if(empty($shop_id)){
        $this->error(__('Invalid parameters'));
      }
      $shop_list = Db::name('shop')->where(['id'=>$shop_id])->delete();
      if($shop_list){
        $this->success(__('successful'));
      }
      $this->error(__('undefind shop'));
    }

    /**
     * 修改店铺
     * @ApiMethod (POST)
     * @ApiParams (name="shop_id", type="integer", required=true, description="店铺id")
     * @ApiParams (name="name", type="string", required=false, description="店铺名")
     * @ApiParams (name="type", type="string", required=true, description="店铺类型，shopify,amazon")
     * @ApiParams (name="address1", type="string", required=false, description="店铺地址")
     * @ApiParams (name="myshopify_domain", type="string", required=false, description="店铺域名")
     * @ApiParams (name="apiKey", type="string", required=false, description="店铺apiKey")
     * @ApiParams (name="apiSecretKey", type="string", required=false, description="店铺apiSecretKey")
     */
    public function updateShop()
    {
      $shop_id = $this->request->post('shop_id');
      $name = $this->request->post('name');
      $type = $this->request->post('type');
      $address1 = $this->request->post('address1');
      $myshopify_domain = $this->request->post('myshopify_domain');
      $apiKey = $this->request->post('apiKey');
      $apiSecretKey = $this->request->post('apiSecretKey');
      if(empty($shop_id)){
        $this->error(__('Invalid parameters'));
      }
      $data = [];
      if(!empty($name)){
        $data['name'] = $name;
      }
      if(!empty($type)){
        $data['type'] = $type;
      }
      if(!empty($address1)){
        $data['address1'] = $address1;
      }
      if(!empty($myshopify_domain)){
        $data['myshopify_domain'] = $myshopify_domain;
      }
      if(!empty($apiKey)){
        $data['apiKey'] = $apiKey;
      }
      if(!empty($apiSecretKey)){
        $data['apiSecretKey'] = $apiSecretKey;
      }
      if(!empty($data)){
        $res = Db::name('shop')->where(['id'=>$shop_id])->update($data);
      
        if($res)$this->success(__('successful'));

        $this->error(__('update false'));
      }
      $this->error(__('undefind shop'));
    }


    /**
     * 添加店铺
     * @ApiMethod (POST)
     * @ApiParams (name="finder_user_id", type="integer", required=true, description="用户id")
     * @ApiParams (name="name", type="string", required=true, description="店铺名")
     * @ApiParams (name="type", type="string", required=true, description="店铺类型，shopify,amazon")
     * @ApiParams (name="address1", type="string", required=false, description="店铺地址")
     * @ApiParams (name="myshopify_domain", type="string", required=false, description="店铺域名")
     * @ApiParams (name="apiKey", type="string", required=false, description="店铺apiKey")
     * @ApiParams (name="apiSecretKey", type="string", required=false, description="店铺apiSecretKey")
     */
    public function addShop()
    {
      $finder_user_id = $this->request->post('finder_user_id');
      $name = $this->request->post('name');
      $type = $this->request->post('type');
      $address1 = $this->request->post('address1');
      $myshopify_domain = $this->request->post('myshopify_domain');
      $apiKey = $this->request->post('apiKey');
      $apiSecretKey = $this->request->post('apiSecretKey');
      if(empty($name)){
        $this->error(__('Invalid parameters'));
      }
      $data = [];
      if(!empty($finder_user_id)){
        $data['finder_user_id'] = $finder_user_id;
      }
      if(!empty($name)){
        $data['name'] = $name;
      }
      if(!empty($type)){
        $data['type'] = $type;
      }
      if(!empty($address1)){
        $data['address1'] = $address1;
      }
      if(!empty($myshopify_domain)){
        $data['myshopify_domain'] = $myshopify_domain;
      }
      if(!empty($apiKey)){
        $data['apiKey'] = $apiKey;
      }
      if(!empty($apiSecretKey)){
        $data['apiSecretKey'] = $apiSecretKey;
      }
      if(!empty($data)){
        $res = Db::name('shop')->insert($data);
      
        if($res)$this->success(__('successful'));

        $this->error(__('add false'));
      }
      $this->error(__('undefind shop'));
    }


    /**
     * 新增商品
     * @ApiMethod (POST)
     * @ApiParams (name="finder_user_id", type="integer", required=true, description="用户id")
     * @ApiParams (name="shop_id", type="integer", required=true, description="店铺id")
     * @ApiParams (name="title", type="string", required=true, description="标题")
     * @ApiParams (name="description", type="string", required=false, description="产品介绍")
     * @ApiParams (name="out_link", type="string", required=false, description="外链")
     * @ApiParams (name="sku", type="string", required=false, description="sku")
     * @ApiParams (name="cost", type="integer", required=true, description="成本价")
     * @ApiParams (name="compare_at_price", type="integer", required=true, description="原价")
     * @ApiParams (name="market_price", type="integer", required=true, description="市场价")
     * @ApiParams (name="shipping", type="integer", required=false, description="运费价")
     * @ApiParams (name="barcode", type="string", required=false, description="条码")
     * @ApiParams (name="quantity", type="integer", required=false, description="数量")
     * @ApiParams (name="options", type="string", required=false, description="选项")
     * @ApiParams (name="variants", type="string", required=false, description="变体")
     * @ApiParams (name="image_urls", type="string", required=false, description="图片地址，多个以,隔开")
     * @ApiParams (name="product_status", type="integer", required=false, description="状态:0=active销售中,1=archived已下架,2=draft未上架	")
     * @ApiParams (name="tag_ids", type="string", required=false, description="标签ids，多个以,隔开")
     * @ApiParams (name="category_id", type="integer", required=false, description="分类id")
     * @ApiParams (name="product_type", type="string", required=false, description="产品类型")
     * @ApiParams (name="weight", type="integer", required=false, description="重量")
     * @ApiParams (name="weight_unit", type="string", required=false, description="重量单位")
     * @ApiParams (name="height", type="string", required=false, description="高cm")
     * @ApiParams (name="width", type="string", required=false, description="宽cm")
     * @ApiParams (name="length", type="string", required=false, description="长cm")
     * @ApiParams (name="inventory_policy", type="integer", required=false, description="缺货下单:0=deny不能,1=continue能")
     * @ApiParams (name="country_id", type="integer", required=false, description="国家id")
     * @ApiParams (name="supplier_id", type="integer", required=false, description="供应商id")
     * @ApiParams (name="HScode", type="string", required=false, description="海关代码")
     */
    public function addProduct()
    {
      $post_data = $this->request->instance()->post(false);
      $finder_user_id = $post_data['finder_user_id'];
      $shop_id = isset($post_data['shop_id']) ? $post_data['shop_id'] : '';
      $title = $post_data['title'];
      $description = isset($post_data['description']) ? $post_data['description'] : '';
      $out_link = isset($post_data['out_link']) ? $post_data['out_link'] : '';
      $sku = isset($post_data['sku']) ? $post_data['sku'] : '';
      $cost = $post_data['cost'];
      $compare_at_price = $post_data['compare_at_price'];
      $market_price = $post_data['market_price'];
      $shipping = isset($post_data['shipping']) ? $post_data['shipping'] : '';
      $barcode = isset($post_data['barcode']) ? $post_data['barcode'] : '';
      $quantity = isset($post_data['quantity']) ? $post_data['quantity'] : '';
      $options = $post_data['options'];
      $variants = $post_data['variants'];
      $image_urls = $post_data['image_urls'];
      $product_status = isset($post_data['product_status']) ? $post_data['product_status'] : 2;
      $tag_ids = isset($post_data['tag_ids']) ? $post_data['tag_ids'] : '';
      $category_id = isset($post_data['category_id']) ? $post_data['category_id'] : 0;
      $product_type = isset($post_data['product_type']) ? $post_data['product_type'] : '';
      $weight = isset($post_data['weight']) ? $post_data['weight'] : 0;
      $weight_unit = isset($post_data['weight_unit']) ? $post_data['weight_unit'] : '';
      $inventory_policy = isset($post_data['inventory_policy']) ? $post_data['inventory_policy'] : 0;
      $height = isset($post_data['height']) ? $post_data['height'] : 0;
      $width = isset($post_data['width']) ? $post_data['width'] : 0;
      $length = isset($post_data['length']) ? $post_data['length'] : 0;
      $country_id = isset($post_data['country_id']) ? $post_data['country_id'] : 0;
      $supplier_id = isset($post_data['supplier_id']) ? $post_data['supplier_id'] : 0;
      $HScode = isset($post_data['HScode']) ? $post_data['HScode'] : '';
      
      if(empty($title)||empty($cost)||empty($compare_at_price)||empty($market_price)){
        $this->error(__('Invalid parameters'));
      }

      // $shop_type = Db::name('shop')->where(['id'=>$shop_id])->value('type');
      // if($shop_type!=='self'){
      //   $shop_id = Db::name('shop')->where(['type'=>'self','finder_user_id'=>$finder_user_id])->value('id');
      //   if(!$shop_id>0){
      //     $this->error(__('Undefind Shop'));
      //   }
      // }

      $shop_type = Db::name('shop')->where(['id'=>$shop_id])->value('type');
        if($shop_type=='self'){
          $product_query = Db::name('product');
          $variant_query = Db::name('product_variants');
          $image_query = Db::name('product_images');
          $option_query = Db::name('product_options');
          $prdid = 'product_id';
        }else{
          $product_query = Db::name('product_import');
          $variant_query = Db::name('product_import_variants');
          $image_query = Db::name('product_import_images');
          $option_query = Db::name('product_import_options');
          $prdid = 'import_id';
        }
      
      Db::startTrans();
      try{
        $data = [
          'title'  =>  $title,
          'description'  =>  $description,
          'out_link'  =>  $out_link,
          'finder_user_id'  =>  $finder_user_id,
          'shop_id'  =>  $shop_id,
          // 'is_open'  =>  1,
          'status'  =>  $product_status,
          'tag_ids'  =>  $tag_ids,
          'product_type'  =>  $product_type,
          'category_id'  =>  $category_id,
          'supplier_id'  =>  $supplier_id,
          'country_id'  =>  $country_id,
          'HScode'  =>  $HScode,
        ];

        $product_id = $product_query->insertGetId($data);
        if(!$product_id){
          Db::rollback();
          $this->error(__('add fail'));
        }
        $options = json_decode(stripslashes($options),1);
        $variants = json_decode(stripslashes($variants),1);
        if(empty($options) && empty($variants)){
          $var_data = [
            $prdid  =>  $product_id,
            'barcode'  =>  $barcode,
            'sku'  =>  $sku,
            'cost'  =>  $cost,
            'compare_at_price'  =>  $compare_at_price,
            'market_price'  =>  $market_price,
            'shipping'  =>  $shipping,
            'inventory_quantity'  =>  $quantity,
            'weight'  =>  $weight,
            'weight_unit'  =>  $weight_unit,
            'inventory_policy'  =>  $inventory_policy,
            'height'  =>  $height,
            'width'  =>  $width,
            'length'  =>  $length,
            'create_time'  =>  time()
          ];
          $variant_id = $variant_query->insertGetId($var_data);
          if(!$variant_id){
            Db::rollback();
            $this->error(__('add variant fail'));
          }
          $log_data = [
            'in_quantity'  =>  $quantity,
            'stock'  =>  $quantity,
            'product_variant_id'  =>  $variant_id,
            'memo'  =>  '新增商品入库',
            'shop_id'  =>  $shop_id,
            'create_time'  =>  time()
          ];
          $log_res = Db::name('inventory_log')->insert($log_data);
          if(!$log_res){
            Db::rollback();
            $this->error(__('add inventory_log fail'));
          }
        }else{
          
          foreach($options as $k => $option){
            $var_data = [
              $prdid  =>  $product_id,
              'name'  =>  $option['name'],
              'values'  =>  implode(',',$option['values']),
              'position'  =>  $k+1,
              'create_time'  =>  time()
            ];
            $option_id = $option_query->insertGetId($var_data);
            if(!$option_id){
              Db::rollback();
              $this->error(__('add option fail'));
            }
          }
          
          foreach($variants as $variant){
            // $option_value = explode('/',$variant['options']);
            $option1 = isset($variant['options'][0]) ? $variant['options'][0] : '';
            $option2 = isset($variant['options'][1]) ? $variant['options'][1] : '';
            $option3 = isset($variant['options'][2]) ? $variant['options'][2] : '';
            $var_data = [
              $prdid  =>  $product_id,
              'barcode'  =>  $variant['barcode']!=''? $variant['barcode'] : $barcode,
              'sku'  =>  $variant['sku']!=''? $variant['sku'] : $sku,
              'cost'  =>  $cost,
              'compare_at_price'  =>  $compare_at_price,
              'market_price'  =>  $variant['market_price']!=0 ? $variant['market_price'] : $market_price,
              'shipping'  =>  $shipping,
              'inventory_quantity'  =>  $variant['inventory_quantity']!=0 ? $variant['inventory_quantity'] : $quantity,
              'image_id'  =>  $variant['image_id'],
              'option1'  =>  $option1,
              'option2'  =>  $option2,
              'option3'  =>  $option3,
              'weight'  =>  $weight,
              'weight_unit'  =>  $weight_unit,
              'inventory_policy'  =>  $inventory_policy,
              'height'  =>  $height,
              'width'  =>  $width,
              'length'  =>  $length,
              'create_time'  =>  time()
            ];
            $variant_id = $variant_query->insertGetId($var_data);
            if(!$variant_id){
              Db::rollback();
              $this->error(__('add variant fail'));
            }
            $log_data = [
              'in_quantity'  =>  $variant['inventory_quantity']!=0 ? $variant['inventory_quantity'] : $quantity,
              'stock'  =>  $variant['inventory_quantity']!=0 ? $variant['inventory_quantity'] : $quantity,
              'product_variant_id'  =>  $variant_id,
              'memo'  =>  '新增商品入库',
              'shop_id'  =>  $shop_id,
              'create_time'  =>  time()
            ];
            $log_res = Db::name('inventory_log')->insert($log_data);
            if(!$log_res){
              Db::rollback();
              $this->error(__('add inventory_log fail'));
            }
          }
        }
  
        

        if(!empty($image_urls)){
          $img_arr = explode(',',$image_urls);
          foreach($img_arr as $img){
            $img_data = [
              $prdid  =>  $product_id,
              // 'variant_id'  =>  $variant_id,
              'src'  =>  $img,
              'create_time'  =>  time()
            ];
            $res = $image_query->insert($img_data);
            if(!$res){
              Db::rollback();
              $this->error(__('add images fail'));
            }
          }
          
        }
        Db::commit();
        if($shop_type=='shopify'){
          $result = importProductToSohpify($product_id,$finder_user_id);
          if($result!='ok'){
            $this->error(__('import fail plaese try again'),$result);
          }
        }
        $this->success(__('successful'));
      }catch (Exception $e) {
        Db::rollback();
        $this->error($e->getMessage());
      }
      
    }


    /**
     * 修改商品
     * @ApiMethod (POST)
     * @ApiParams (name="finder_user_id", type="integer", required=true, description="用户id")
     * @ApiParams (name="shop_id", type="integer", required=true, description="店铺id")
     * @ApiParams (name="title", type="string", required=false, description="标题")
     * @ApiParams (name="description", type="string", required=false, description="产品介绍")
     * @ApiParams (name="out_link", type="string", required=false, description="外链")
     * @ApiParams (name="sku", type="string", required=false, description="sku")
     * @ApiParams (name="cost", type="integer", required=true, description="成本价")
     * @ApiParams (name="compare_at_price", type="integer", required=true, description="原价")
     * @ApiParams (name="market_price", type="integer", required=true, description="市场价")
     * @ApiParams (name="shipping", type="integer", required=false, description="运费价")
     * @ApiParams (name="barcode", type="string", required=false, description="条码")
     * @ApiParams (name="quantity", type="integer", required=false, description="数量")
     * @ApiParams (name="options", type="string", required=false, description="选项")
     * @ApiParams (name="variants", type="string", required=false, description="变体")
     * @ApiParams (name="image_urls", type="string", required=false, description="图片地址，多个以,隔开")
     * @ApiParams (name="product_status", type="integer", required=false, description="状态:0=active销售中,1=archived已下架,2=draft未上架	")
     * @ApiParams (name="tag_ids", type="string", required=false, description="标签ids，多个以,隔开")
     * @ApiParams (name="category_id", type="integer", required=false, description="分类id")
     * @ApiParams (name="product_type", type="string", required=false, description="产品类型")
     * @ApiParams (name="weight", type="integer", required=false, description="重量")
     * @ApiParams (name="weight_unit", type="string", required=false, description="重量单位")
     * @ApiParams (name="height", type="string", required=false, description="高cm")
     * @ApiParams (name="width", type="string", required=false, description="宽cm")
     * @ApiParams (name="length", type="string", required=false, description="长cm")
     * @ApiParams (name="inventory_policy", type="integer", required=false, description="缺货下单:0=deny不能,1=continue能")
     * @ApiParams (name="delete_image_ids", type="string", required=false, description="需删除图片id，多个以,隔开")
     * @ApiParams (name="country_id", type="integer", required=false, description="国家id")
     * @ApiParams (name="supplier_id", type="integer", required=false, description="供应商id")
     * @ApiParams (name="HScode", type="string", required=false, description="海关代码")
     */
    public function updateProduct()
    {

      $post_data = $this->request->instance()->post(false);
      $finder_user_id = $post_data['finder_user_id'];
      $product_id = $post_data['product_id'];
      $shop_id = isset($post_data['shop_id']) ? $post_data['shop_id'] : '';
      $title = $post_data['title'];
      $description = isset($post_data['description']) ? $post_data['description'] : '';
      $out_link = isset($post_data['out_link']) ? $post_data['out_link'] : '';
      $sku = isset($post_data['sku']) ? $post_data['sku'] : '';
      $cost = $post_data['cost'];
      $compare_at_price = $post_data['compare_at_price'];
      $market_price = $post_data['market_price'];
      $shipping = isset($post_data['shipping']) ? $post_data['shipping'] : '';
      $barcode = isset($post_data['barcode']) ? $post_data['barcode'] : '';
      $quantity = isset($post_data['quantity']) ? $post_data['quantity'] : '';
      $options = $post_data['options'];
      $variants = $post_data['variants'];
      $image_urls = $post_data['image_urls'];
      $product_status = isset($post_data['product_status']) ? $post_data['product_status'] : 2;
      $tag_ids = isset($post_data['tag_ids']) ? $post_data['tag_ids'] : '';
      $category_id = isset($post_data['category_id']) ? $post_data['category_id'] : 0;
      $product_type = isset($post_data['product_type']) ? $post_data['product_type'] : '';
      $weight = isset($post_data['weight']) ? $post_data['weight'] : 0;
      $weight_unit = isset($post_data['weight_unit']) ? $post_data['weight_unit'] : '';
      $inventory_policy = isset($post_data['inventory_policy']) ? $post_data['inventory_policy'] : 0;
      $height = isset($post_data['high']) ? $post_data['high'] : 0;
      $width = isset($post_data['wide']) ? $post_data['wide'] : 0;
      $length = isset($post_data['Length']) ? $post_data['Length'] : 0;
      $image_ids = isset($post_data['delete_image_ids']) ? $post_data['delete_image_ids'] : '';
      $country_id = isset($post_data['country_id']) ? $post_data['country_id'] : 0;
      $supplier_id = isset($post_data['supplier_id']) ? $post_data['supplier_id'] : 0;
      $HScode = isset($post_data['HScode']) ? $post_data['HScode'] : '';
      
      if(empty($cost)||empty($compare_at_price)||empty($market_price)){
        $this->error(__('Invalid parameters'));
      }
      // var_dump($market_price);die;
      Db::startTrans();
      try{

        $shop_type = Db::name('shop')->where(['id'=>$shop_id])->value('type');
        if($shop_type=='self'){
          $product_query = Db::name('product');
          $variant_query = Db::name('product_variants');
          $image_query = Db::name('product_images');
          $option_query = Db::name('product_options');
          $prdid = 'product_id';
        }else{
          $product_query = Db::name('product_import');
          $variant_query = Db::name('product_import_variants');
          $image_query = Db::name('product_import_images');
          $option_query = Db::name('product_import_options');
          $prdid = 'import_id';
        }
        
        $data = [
          'finder_user_id'  =>  $finder_user_id,
          'shop_id'  =>  $shop_id,
          'update_time'  =>  time(),
        ];
        if(!empty($title)){
          $data['title'] = $title;
        }
        if(!empty($description)){
          $data['description'] = $description;
        }
        if(!empty($out_link)){
          $data['out_link'] = $out_link;
        }
        if(!empty($product_status)){
          $data['product_status'] = $product_status;
        }
        if(!empty($tag_ids)){
          $data['tag_ids'] = $tag_ids;
        }
        if(!empty($category_id)){
          $data['category_id'] = $category_id;
        }
        if(!empty($tag_ids)){
          $data['product_type'] = $product_type;
        }
        if(!empty($country_id)){
          $data['country_id'] = $country_id;
        }
        if(!empty($supplier_id)){
          $data['supplier_id'] = $supplier_id;
        }
        if(!empty($sku)){
          $data['sku'] = $sku;
        }
        $data['HScode'] = $HScode;

        $res = $product_query->where(['id'=>$product_id])->update($data);
        if(!$res){
          Db::rollback();
          $this->error(__('update fail'));
        }

        $option_ids = $option_query->where($prdid.' = '.$product_id)->column('id');
        $variant_ids = $variant_query->where($prdid.' = '.$product_id)->column('id');
        // var_dump($option_ids);var_dump($variant_ids);
          $options = json_decode(stripslashes($options),1);
          foreach($options as $k => $option){
            if(isset($option['id'])){
              $var_data = [
                'name'  =>  $option['name'],
                'values'  =>  implode(',',$option['values']),
                'position'  =>  $option['position'],
                'update_time'  =>  time()
              ];
              $res_op = $option_query->where(['id'=>$option['id']])->update($var_data);
              if(!$res_op){
                Db::rollback();
                $this->error(__('update fail'));
              }
              $option_ids = array_diff($option_ids, [$option['id']]);
            }else{
              $var_data = [
                $prdid  =>  $product_id,
                'name'  =>  $option['name'],
                'values'  =>  implode(',',$option['values']),
                'position'  =>  $k+1,
                'create_time'  =>  time()
              ];
              $res_op = $option_query->insert($var_data);
              if(!$res_op){
                Db::rollback();
                $this->error(__('update fail'));
              }
            }
            
          }
          $variants = json_decode(stripslashes($variants),1);
          if(count($variants)==1 && $variants[0]['option1']==''){
            $var_info = $variant_query->where(['id'=>$variants[0]['id']])->field('inventory_quantity')->find();
            $var_data = [
              'compare_at_price'  =>  $compare_at_price,
              'cost'  =>  $cost,
              'market_price'  =>  $market_price,
              'barcode'  =>  $barcode,
              'weight'  =>  $weight,
              'weight_unit'  =>  $weight_unit,
              'height'  =>  $height,
              'width'  =>  $width,
              'length'  =>  $length,
              'inventory_policy'  =>  $inventory_policy,
              'inventory_quantity'  =>  $quantity,
              'sku'  =>  $sku,
              'update_time'  =>  time(),
            ];

            // $var_data = array_filter($var_data);
            $res_va = $variant_query->where(['id'=>$variants[0]['id']])->update($var_data);
            if(!$res_va){
              Db::rollback();
              $this->error(__('update fail'));
            }
            
            if($var_info && $var_info['inventory_quantity']!=$quantity){
              if($var_info['inventory_quantity'] > $quantity){
                $log_data = [
                  'out_quantity'  =>  $var_info['inventory_quantity']-$quantity,
                  'stock'  =>  $quantity,
                  'product_variant_id'  =>  $variants[0]['id'],
                  'memo'  =>  '修改商品库存',
                  'create_time'  =>  time()
                ];
                
              }else{
                $log_data = [
                  'in_quantity'  =>  $quantity-$var_info['inventory_quantity'],
                  'stock'  =>  $quantity,
                  'product_variant_id'  =>  $variants[0]['id'],
                  'memo'  =>  '修改商品库存',
                  'shop_id'  =>  $shop_id,
                  'create_time'  =>  time()
                ];
              }
              $log_res = Db::name('inventory_log')->insert($log_data);
                if(!$log_res){
                  Db::rollback();
                  $this->error(__('add inventory_log fail'));
                }
            }
            $variant_ids = array_diff($variant_ids, [$variants[0]['id']]);
            // var_dump($variant_query->getLastSql());die;
          }else{
            foreach($variants as $variant){
              if(isset($variant['id'])){
                $var_info = $variant_query->where(['id'=>$variant['id']])->field('inventory_quantity')->find();
                $var_data = [
                  'barcode'  =>  $variant['barcode'],
                  'sku'  =>  $variant['sku'],
                  'cost'  =>  $cost,
                  'compare_at_price'  =>  $compare_at_price,
                  'market_price'  =>  $variant['market_price']!=0 ? $variant['market_price'] : $market_price,
                  'shipping'  =>  $shipping,
                  'inventory_quantity'  =>  $variant['inventory_quantity'],
                  'option1'  =>  $variant['option1'],
                  'option2'  =>  $variant['option2'],
                  'option3'  =>  $variant['option3'],
                  'weight'  =>  $weight,
                  'weight_unit'  =>  $weight_unit,
                  'height'  =>  $height,
                  'width'  =>  $width,
                  'length'  =>  $length,
                  'inventory_policy'  =>  $inventory_policy,
                  'image_id'  =>  $variant['image_id'],
                  'update_time'  =>  time(),
                ];
                
                // $var_data = array_filter($var_data);

                $res_va = $variant_query->where(['id'=>$variant['id']])->update($var_data);
                // var_dump($variant_query->getLastSql());die;
                if(!$res_va){
                  Db::rollback();
                  $this->error(__('update fail'));
                }
                
                if($var_info && $var_info['inventory_quantity']!=$var_data['inventory_quantity']){
                  if($var_info['inventory_quantity'] > $var_data['inventory_quantity']){
                    $log_data = [
                      'out_quantity'  =>  $var_info['inventory_quantity']-$var_data['inventory_quantity'],
                      'stock'  =>  $var_data['inventory_quantity'],
                      'product_variant_id'  =>  $variant['id'],
                      'memo'  =>  '修改商品库存',
                      'create_time'  =>  time()
                    ];
                    
                  }else{
                    $log_data = [
                      'in_quantity'  =>  $var_data['inventory_quantity']-$var_info['inventory_quantity'],
                      'stock'  =>  $var_data['inventory_quantity'],
                      'product_variant_id'  =>  $variant['id'],
                      'memo'  =>  '修改商品库存',
                      'shop_id'  =>  $shop_id,
                      'create_time'  =>  time()
                    ];
                  }
                  $log_res = Db::name('inventory_log')->insert($log_data);
                    if(!$log_res){
                      Db::rollback();
                      $this->error(__('add inventory_log fail'));
                    }
                }
                $variant_ids = array_diff($variant_ids, [$variant['id']]);
              }else{
                $var_data = [
                  $prdid  =>  $product_id,
                  'barcode'  =>  isset($variant['barcode']) ? $variant['barcode'] : '',
                  'sku'  =>  $variant['sku'],
                  'cost'  =>  $cost,
                  'compare_at_price'  =>  $compare_at_price,
                  'market_price'  =>  $variant['market_price']!=0 ? $variant['market_price'] : $market_price,
                  'shipping'  =>  $shipping,
                  'inventory_quantity'  =>  $variant['inventory_quantity'],
                  'image_id'  =>  $variant['image_id'],
                  'option1'  =>  $variant['option1'],
                  'option2'  =>  $variant['option2'],
                  'option3'  =>  $variant['option3'],
                  'weight'  =>  $weight,
                  'weight_unit'  =>  $weight_unit,
                  'inventory_policy'  =>  $inventory_policy,
                  'height'  =>  $height,
                  'width'  =>  $width,
                  'length'  =>  $length,
                  'create_time'  =>  time()
                ];
                $variant_id = $variant_query->insertGetId($var_data);
                if(!$variant_id){
                  Db::rollback();
                  $this->error(__('add variant fail'));
                }
                if($variant['inventory_quantity']!=0){
                  $log_data = [
                    'in_quantity'  =>  $variant['inventory_quantity'],
                    'stock'  =>  $variant['inventory_quantity'],
                    'product_variant_id'  =>  $variant_id,
                    'shop_id'  =>  $shop_id,
                    'memo'  =>  '新增商品入库',
                    'create_time'  =>  time()
                  ];
                  $log_res = Db::name('inventory_log')->insert($log_data);
                  if(!$log_res){
                    Db::rollback();
                    $this->error(__('add inventory_log fail'));
                  }
                }
                
              }
              
            }
          }
          // var_dump($option_ids);var_dump($variant_ids);die;
          //删除option && variant
          // $option_ids = implode(',', $option_ids);
          // $variant_ids = implode(',', $variant_ids);
          if(!empty($option_ids)){
            $res_option = $option_query->where(['id'=>['in',$option_ids]])->delete();
            if(!$res_option){
              Db::rollback();
              $this->error(__('delete option fail'));
            }
          }
          if(!empty($variant_ids)){ 
            $res_variant = $variant_query->where(['id'=>['in',$variant_ids]])->delete();
            if(!$res_variant){
              Db::rollback();
              $this->error(__('delete variant fail'));
            }
          }
  
        

          if(!empty($image_urls)){
            $img_arr = explode(',',$image_urls);
            foreach($img_arr as $img){
              $img_data = [
                $prdid  =>  $product_id,
                'src'  =>  $img,
                'create_time'  =>  time()
              ];
              $res = $image_query->insert($img_data);
              if(!$res){
                Db::rollback();
                $this->error(__('add images fail'));
              }
            }
            
          }


          if(!empty($image_ids)){
            $imgid_arr = explode(',',$image_ids);
            foreach($imgid_arr as $id){
              $res = $image_query->where(['id'=>$id])->delete();
              if(!$res){
                Db::rollback();
                $this->error(__('delete images fail'));
              }
            }
            
          }
        Db::commit();

        if($shop_type=='shopify'){
          $result = updateProductToSohpify($product_id,$finder_user_id,$image_urls);
          // var_dump($result."1");die;
          if($result!='ok'){
            $this->error(__('update to shopify fail plaese try again'),$result);
          }
        }

        $this->success(__('successful'));
      }catch (Exception $e) {
        Db::rollback();
        $this->error($e->getMessage());
      }
      
    }


    /**
     * 直接导入商品到shopify
     * @ApiMethod (POST)
     * @ApiMethod (POST)
     * @ApiParams (name="product_ids", type="integer", required=true, description="产品id")
     * @ApiParams (name="finder_user_id", type="integer", required=true, description="用户id")
     */
    public function importToSohpifyDirect()
    {
      // $post_data = $this->request->instance()->post(false);
      // var_dump($post_data);die;
      $product_id = $this->request->post('product_ids','');
      $finder_user_id = $this->request->post('finder_user_id','');
      $token = $this->request->post('token','');
      if(empty($finder_user_id)||empty($product_id)){
        $this->error(__('Invalid parameters'));
      }
      $where = [];
      if(!empty($product_id)){
        $where = [
                    'id'=>['in',$product_id],
                    'finder_user_id'=>$finder_user_id
                  ];
      }
      $product_list = Db::name('product')->where($where)->select();
      if(!$product_list){
        $this->error(__('unndefind product'));
      }
      $shop_id = Db::name('shop')->where(['finder_user_id'=>$finder_user_id,'type'=>'shopify'])->value('id');
      Db::startTrans();
      try {
      $ids = "";
      foreach($product_list as $k => $product){
        
        $find = Db::name('product_import')->where(['product_id'=>$product['id']])->field('id,is_inport')->find();
        if($find){
          if($find['is_inport']!=1){
            $this->tocurl('http://interface.ddtechinfo.com/api/productimport/importToSohpify',[],['product_ids'=>$find['id'],'finder_user_id'=>$finder_user_id,'token'=>$token]);
            Db::name('product_import')->where(['id'=>$find['id']])->update(['is_inport'=>1]);
          }
          continue;
        }
        
            $create_data = [
              'product_id'  =>  $product['id'],
              'finder_user_id'  =>  $finder_user_id,
              'description'  =>  $product['description'],
              'status'  =>  $product['status'],
              'body_html'  =>  $product['body_html'],
              'handle'  =>  $product['handle'],
              'product_type'  =>  $product['product_type'],
              'title'  =>  $product['title'],
              'supplier_id'  =>  $product['supplier_id'],
              'category_id'  =>  $product['category_id'],
              'brand_id'  =>  $product['brand_id'],
              'product_data'  =>  $product['product_data'],
              'out_link'  =>  $product['out_link'],
              'shop_id'  =>  $shop_id,
              'country_id'  =>  $product['country_id'],
              'HScode'  =>  $product['HScode'],
              'is_inport'  =>  1,
              'create_time'  =>  time(),
            ];
            $import_id = Db::name('product_import')->insertGetId($create_data);
            if($k==0){
              $ids .= $import_id;
            }else{
              $ids .= ','.$import_id;
            }
            $variants = Db::name('product_variants')->where(['product_id'=>$product['id']])->select();
            if($import_id>0 && $variants){
              foreach($variants as $k => $var){
                $variants_data = [
                  'import_id'  =>  $import_id,
                  'sku'  =>  $var['sku'],
                  'weight'  =>  $var['weight'],
                  'weight_unit'  =>  $var['weight_unit'],
                  'barcode'  =>  $var['barcode'],
                  'compare_at_price'  =>  $var['compare_at_price'],
                  'image_id'  =>  $var['image_id'],
                  'cost'  =>  $var['cost'],
                  'shipping'  =>  $var['shipping'],
                  'market_price'  =>  $var['market_price'],
                  'form'  =>  $var['form'],
                  'bullet_point1'  =>  $var['bullet_point1'],
                  'bullet_point2'  =>  $var['bullet_point2'],
                  'bullet_point3'  =>  $var['bullet_point3'],
                  'bullet_point4'  =>  $var['bullet_point4'],
                  'bullet_point5'  =>  $var['bullet_point5'],
                  'length'  =>  $var['length'],
                  'width'  =>  $var['width'],
                  'height'  =>  $var['height'],
                  'option1'  =>  $var['option1'],
                  'option2'  =>  $var['option2'],
                  'option3'  =>  $var['option3'],
                  'inventory_quantity' => $var['inventory_quantity'],
                  'create_time'  =>  time(),
                ];
                $res_var = Db::name('product_import_variants')->insert($variants_data);
                if(!$res_var){
                  Db::rollback();
                  $this->error(__('Import is fail'));
                }
              }
            }

            $options = Db::name('product_options')->where(['product_id'=>$product['id']])->select();
            if($import_id>0 && $options){
              foreach($options as $k => $op){
                $op_data = [
                  'import_id'  =>  $import_id,
                  'name'  =>  $op['name'],
                  'values'  =>  $op['values'],
                  'position'  =>  $op['position'],
                  'create_time'  =>  time(),
                ];
                $res_img = Db::name('product_import_options')->insert($op_data);
                if(!$res_img){
                  Db::rollback();
                  $this->error(__('Import is fail'));
                }
              }
            }

            $images = Db::name('product_images')->where(['product_id'=>$product['id']])->select();
            if($import_id>0 && $images){
              foreach($images as $k => $img){
                $images_data = [
                  'import_id'  =>  $import_id,
                  'src'  =>  $img['src'],
                  'width'  =>  $img['width'],
                  'height'  =>  $img['height'],
                  'position'  =>  $img['position'],
                  'variant_ids'  =>  $img['variant_ids'],
                  'create_time'  =>  time(),
                ];
                $res_img = Db::name('product_import_images')->insert($images_data);
                if(!$res_img){
                  Db::rollback();
                  $this->error(__('Import is fail'));
                }
              }
            }

      }

      Db::commit();
      } catch (Exception $e) {
        Db::rollback();
        $this->error($e->getMessage());
      }
        
      // $result = $this->tocurl('http://interface.ddtechinfo.com/api/productimport/importToSohpify',[],['product_ids'=>$ids,'finder_user_id'=>$finder_user_id,'token'=>$token]);
      // if(!$result){
      //   $this->error(__('Import is fail'));
      // }
      if($ids!=''){
        $result = importProductToSohpify($ids,$finder_user_id);
        if($result!='ok'){
          $this->error(__('import fail plaese try again'),$result);
        }
      }else{
        $this->success(__('product is already exist'));
      }
      $this->success(__('successful'));
    }


    /**
     * 线上平台导入本地仓库
     * @ApiMethod (POST)
     * @ApiParams (name="product_ids", type="integer", required=true, description="产品id,多个以,分隔")
     * @ApiParams (name="finder_user_id", type="integer", required=true, description="用户id")
     * @ApiParams (name="shop_id", type="integer", required=true, description="店铺id")
     */
    public function importToLocalDirect()
    {
      // $post_data = $this->request->instance()->post(false);
      // var_dump($post_data);die;
      $product_id = $this->request->post('product_ids','');
      $finder_user_id = $this->request->post('finder_user_id','');
      $shop_id = $this->request->post('shop_id','');
      $token = $this->request->post('token','');
      if(empty($finder_user_id)||empty($shop_id)){
        $this->error(__('Invalid parameters'));
      }
      $where = [];
      $where['finder_user_id'] = $finder_user_id;
      $where['shop_id'] = $shop_id;
      $where['product_id'] = 0;
      if(!empty($product_id)){
        $where['id'] = ['in',$product_id];
      }
      $product_list = Db::name('product_import')->where($where)->select();
      if(!$product_list){
        $this->error(__('unndefind product or is already exist'));
      }
      $p_shop_id = Db::name('shop')->where(['finder_user_id'=>$finder_user_id,'type'=>'self'])->value('id');
      Db::startTrans();
      try {
      foreach($product_list as $k => $product){
          
            $create_data = [
              // 'product_id'  =>  $product['id'],
              'finder_user_id'  =>  $finder_user_id,
              'description'  =>  $product['description'],
              'status'  =>  $product['status'],
              'body_html'  =>  $product['body_html'],
              'handle'  =>  $product['handle'],
              'product_type'  =>  $product['product_type'],
              'title'  =>  $product['title'],
              'supplier_id'  =>  $product['supplier_id'],
              'category_id'  =>  $product['category_id'],
              'brand_id'  =>  $product['brand_id'],
              'product_data'  =>  $product['product_data'],
              'out_link'  =>  $product['out_link'],
              'shop_id'  =>  $p_shop_id,
              'country_id'  =>  $product['country_id'],
              'HScode'  =>  $product['HScode'],
              'create_time'  =>  time(),
            ];
            $import_id = Db::name('product')->insertGetId($create_data);

            $variants = Db::name('product_import_variants')->where(['import_id'=>$product['id']])->select();
            if($import_id>0 && $variants){
              foreach($variants as $k => $var){
                $variants_data = [
                  'product_id'  =>  $import_id,
                  'sku'  =>  $var['sku'],
                  'weight'  =>  $var['weight'],
                  'weight_unit'  =>  $var['weight_unit'],
                  'barcode'  =>  $var['barcode'],
                  'compare_at_price'  =>  $var['compare_at_price'],
                  'image_id'  =>  $var['image_id'],
                  'cost'  =>  $var['cost'],
                  'shipping'  =>  $var['shipping'],
                  'market_price'  =>  $var['market_price'],
                  'form'  =>  $var['form'],
                  'bullet_point1'  =>  $var['bullet_point1'],
                  'bullet_point2'  =>  $var['bullet_point2'],
                  'bullet_point3'  =>  $var['bullet_point3'],
                  'bullet_point4'  =>  $var['bullet_point4'],
                  'bullet_point5'  =>  $var['bullet_point5'],
                  'shopify_variant_id'  =>  $var['shopify_variant_id'],
                  'length'  =>  $var['length'],
                  'width'  =>  $var['width'],
                  'height'  =>  $var['height'],
                  'option1'  =>  $var['option1'],
                  'option2'  =>  $var['option2'],
                  'option3'  =>  $var['option3'],
                  'create_time'  =>  time(),
                ];
                $res_var = Db::name('product_variants')->insert($variants_data);
                if(!$res_var){
                  Db::rollback();
                  $this->error(__('Import is fail'));
                }
              }
            }

            $options = Db::name('product_import_options')->where(['import_id'=>$product['id']])->select();
            if($import_id>0 && $options){
              foreach($options as $k => $op){
                $op_data = [
                  'product_id'  =>  $import_id,
                  'name'  =>  $op['name'],
                  'values'  =>  $op['values'],
                  'position'  =>  $op['position'],
                  'create_time'  =>  time(),
                ];
                $res_img = Db::name('product_options')->insert($op_data);
                if(!$res_img){
                  Db::rollback();
                  $this->error(__('Import is fail'));
                }
              }
            }

            $images = Db::name('product_import_images')->where(['import_id'=>$product['id']])->select();
            if($import_id>0 && $images){
              foreach($images as $k => $img){
                $images_data = [
                  'product_id'  =>  $import_id,
                  'src'  =>  $img['src'],
                  'width'  =>  $img['width'],
                  'height'  =>  $img['height'],
                  'position'  =>  $img['position'],
                  // 'variant_ids'  =>  $img['variant_ids'],
                  'create_time'  =>  time(),
                ];
                $res_img = Db::name('product_images')->insert($images_data);
                if(!$res_img){
                  Db::rollback();
                  $this->error(__('Import is fail'));
                }
              }
            }

      }

      Db::commit();
      } catch (Exception $e) {
        Db::rollback();
        $this->error($e->getMessage());
      }

      $this->success(__('successful'));
    }


    /**
     * 商品调价
     * @ApiMethod (POST)
     * @ApiParams (name="product_ids", type="integer", required=true, description="产品id")
     * @ApiParams (name="finder_user_id", type="integer", required=true, description="用户id")
     * @ApiParams (name="shop_id", type="integer", required=true, description="店铺id")
     * @ApiParams (name="cost", type="integer", required=false, description="成本价")
     * @ApiParams (name="compare_at_price", type="integer", required=false, description="原价")
     * @ApiParams (name="market_price", type="integer", required=false, description="市场价")
     */
    public function updateProductPrice()
    {
      $product_id = $this->request->post('product_ids',0);
      $finder_user_id = $this->request->post('finder_user_id',0);
      $shop_id = $this->request->post('shop_id',0);
      $cost = $this->request->post('cost',0);
      $compare_at_price = $this->request->post('compare_at_price',0);
      $market_price = $this->request->post('market_price',0);
      // $all_percent = $this->request->post('all_percent',0);

      if(empty($product_id)||empty($finder_user_id)||empty($shop_id)){
        $this->error(__('Invalid parameters'));
      }


      $shop = Db::name('shop')->where(['id'=>$shop_id])->field('name,type')->find();
      if(!$shop){
        $this->error(__('Undefind shop'));
      }

      $data = [];

        // if(!empty($all_percent)){
        //   $data['cost'] = ['exp','cost*'.$all_percent];
        //   $data['compare_at_price'] = ['exp','compare_at_price*'.$all_percent];
        //   $data['market_price'] = ['exp','market_price*'.$all_percent];
        // }else{
          if(!empty($cost)){
            $data['cost'] = $cost>0 ? Db::raw('cost+cost*'.$cost) : Db::raw('cost-cost*'.abs($cost));
          }
          if(!empty($compare_at_price)){
            $data['compare_at_price'] = $compare_at_price>0 ? Db::raw('compare_at_price+compare_at_price*'.$compare_at_price) : Db::raw('compare_at_price-compare_at_price*'.abs($compare_at_price));
          }
          if(!empty($market_price)){
            $data['market_price'] = $market_price>0 ? Db::raw('market_price+market_price*'.$market_price) : Db::raw('market_price-market_price*'.abs($market_price));
          }
        // }

      if($shop['type']=='self'){

        $where = [];
        if(!empty($product_id)){
          $where = [
                      'id'=>['in',$product_id],
                      'finder_user_id'=>$finder_user_id
                    ];
        }
        $product_list = Db::name('product')->where($where)->select();
        if(!$product_list){
          $this->error(__('Undefind product'));
        }

        

        
        $res = Db::name('product_variants')->where(['product_id'=>['in',$product_id]])->update($data);
        // var_dump(Db::name('product_variants')->getLastSql());die;
        if(!$res){
          $this->error(__('Update fail'));
        }

      }

      
      if($shop['type']=='shopify'){


        $product_ids = Db::name('product_import')->where(['finder_user_id'=>$finder_user_id,'id'=>['in',$product_id]])->column('id');
        $ids = implode(',', $product_ids);

        $ress = Db::name('product_import_variants')->where(['import_id'=>['in',$ids]])->update($data);
        if(!$ress){
          $this->error(__('Update fail'));
        }

        $variants = Db::name('product_import_variants')->where(['import_id'=>['in',$ids]])->field('market_price,shopify_variant_id,compare_at_price,cost')->select();

        foreach($variants as $v){
          if($v['shopify_variant_id']==0){
            continue;
          }
          $postData = 	[
            "variant" => [
              "id" => $v['shopify_variant_id'],
              "compare_at_price" => $v['compare_at_price'],
              "price" => $v['market_price'],
              "cost" => $v['cost'],
            ]
          ]; 
          
          $shop_name = Db::name('finder_user')->where(['id'=>$finder_user_id])->value('shop');
          // Context::initialize($this->apiKey,$this->apiSecretKey,$this->scopes,$this->hoseName,new FileSessionStorage());
          $session = Context::$SESSION_STORAGE->loadSession($shop_name);
          $client = new Rest($session->getShop(), $session->getAccessToken());
          $response = $client->put('variants/'.$v['shopify_variant_id'],$postData);
          $res=json_decode($response->getBody());
          if(!empty($res->errors))$this->error(__('Update fail'),$res->errors);
        }

        
      }


      $this->success(__('successful'));

    }


    /**
     * 删除自有产品
     * @ApiMethod (POST)
     * @ApiParams (name="product_ids", type="string", required=true, description="产品id,多个以逗号隔开")
     * @ApiParams (name="finder_user_id", type="integer", required=true, description="用户id")
     */
    public function deleteOwnerList()
    {
      $product_ids = $this->request->post('product_ids');
      $finder_user_id = $this->request->post('finder_user_id','');
      if(!empty($product_ids) && !empty($finder_user_id)){
        Db::startTrans();
        try {
            $res = Db::name('product')->where('id in ('.$product_ids.') and finder_user_id = '.$finder_user_id)->delete();
            $res_img = Db::name('product_images')->where('product_id in ('.$product_ids.')')->delete();
            $res_var = Db::name('product_variants')->where('product_id in ('.$product_ids.')')->delete();
            // if(!$res || !$res_img || !$res_var){
            //   Db::rollback();
            //   $this->error(__('delete fail'));
            // }
            

            Db::commit();
          } catch (Exception $e) {
            Db::rollback();
            $this->error($e->getMessage());
        }
        
      }
      $this->success(__('successful'));
    }

    /**
     * 删除店铺内产品
     * @ApiMethod (POST)
     * @ApiParams (name="product_ids", type="string", required=true, description="产品id,多个以逗号隔开")
     * @ApiParams (name="finder_user_id", type="integer", required=true, description="用户id")
     * @ApiParams (name="shop_id", type="integer", required=true, description="店铺id")
     */
    public function deleteShopProduct()
    {
      $product_ids = $this->request->post('product_ids');
      $finder_user_id = $this->request->post('finder_user_id','');
      $shop_id = $this->request->post('shop_id','');
      if(!empty($product_ids) && !empty($finder_user_id) && !empty($shop_id)){
        Db::startTrans();
        try {
            $res = Db::name('product_import')->where('id in ('.$product_ids.') and finder_user_id = '.$finder_user_id." and shop_id = ".$shop_id)->delete();
            $res_img = Db::name('product_import_images')->where('import_id in ('.$product_ids.')')->delete();
            $res_var = Db::name('product_import_variants')->where('import_id in ('.$product_ids.')')->delete();
            // if(!$res || !$res_img || !$res_var){
            //   Db::rollback();
            //   $this->error(__('delete fail').Db::getLastSql());
            // }
            

            Db::commit();
          } catch (Exception $e) {
            Db::rollback();
            $this->error($e->getMessage());
        }
        
      }
      $this->success(__('successful'));
    }


    /**
     * 产品分类列表
     * @ApiMethod (POST)
     */
    public function productCategoryList()
    {
      $list = \app\admin\model\product\Category::with('children.children.children')->where('parent_id', 0)->order('orders desc, id asc')->select();
            
      $this->success(__('successful'),$list);
    }

    /**
     * 产品标签列表
     * @ApiMethod (POST)
     */
    public function productTagsList()
    {
      $list = Db::name('product_tags')->order('orders desc, id asc')->select();
            
      $this->success(__('successful'),$list);
    }


    /**
     * 同步shopify产品列表
     * @ApiMethod (POST)
     * @ApiParams (name="finder_user_id", type="integer", required=true, description="用户id")
     * @ApiParams (name="shop_id", type="integer", required=true, description="店铺id")
     */
    public function shopifyProductLoad()
    {

      $finder_user_id = $this->request->post('finder_user_id',0);
      $shop_id = $this->request->post('shop_id',0);

      if(empty($finder_user_id)||empty($shop_id)){
        $this->error(__('Invalid parameters'));
      }
      
      $shop_name = Db::name('finder_user')->where(['id'=>$finder_user_id])->value('shop');
      // Context::initialize($this->apiKey,$this->apiSecretKey,$this->scopes,$this->hoseName,new FileSessionStorage());
      $session = Context::$SESSION_STORAGE->loadSession($shop_name);
      $client = new Rest($session->getShop(), $session->getAccessToken());
      $response = $client->get('products');
      $res=json_decode($response->getBody());
      if(!empty($res->errors))$this->error(__('Import fail'),$res->errors);
      //  var_dump($res->products[0]->variants[0]->id);die;
      foreach($res->products as $product){
        // var_dump($product);die;
                  $tag_ids = "";
                  if(!empty($product->tags)){
                    $tags = explode(',',$product->tags);
                    foreach($tags as $k => $tag){
                      $tag_id = Db::name('product_tags')->where(['name'=>trim($tag)])->value('id');
                      if($tag_id>0){
                        if($k==0){
                          $tag_ids = $tag_id;
                        }else{
                          $tag_ids .= ','.$tag_id;
                        }
                      }
                    }
                  }
                  
                $find = Db::name('product_import')->where(['shopify_product_id'=>$product->id])->find();
                if($find){
                  // echo $product->id."/";
                  continue;
                  Db::startTrans();
                  try{
                  $data = [
                    'title'  =>  $product->title,
                    // 'description'  =>  $product->description,
                    'tag_ids'  =>  $tag_ids,
                    'product_type'  =>  $product->product_type,
                    'body_html'  =>  $product->body_html,
                    'update_time'=>time()
                  ];
                  
                  $product_id = Db::name('product_import')->where(['shopify_product_id'=>$product->id])->update($data);
                  if(!$product_id){
                    Db::rollback();
                    $this->error(__('update fail'));
                  }
                  
                    
                    foreach($product->options as $k => $option){
                      $var_data = [
                        'name'  =>  $option['name'],
                        'values'  =>  implode(',',$option['values']),
                        'position'  =>  $option['position'],
                        'update_time'  =>  time()
                      ];
                      $option_id = Db::name('product_import_options')->where(['import_id'=>$find['id']])->update($var_data);
                      if(!$option_id){
                        Db::rollback();
                        $this->error(__('add option fail'));
                      }
                    }
                    
                    foreach($product->variants as $variant){
                      $var_data = [
                        'barcode'  =>  $variant['barcode'],
                        'sku'  =>  $variant['sku'],
                        // 'cost'  =>  $cost,
                        'compare_at_price'  =>  $variant['compare_at_price']==null ? 0 : $variant['compare_at_price'],
                        'market_price'  =>  $variant['price']==null ? 0 : $variant['price'],
                        // 'shipping'  =>  $shipping,
                        // 'inventory_quantity'  =>  $variant['inventory_quantity'],
                        // 'image_id'  =>  $variant['imagesId'],
                        'option1'  =>  $variant['option1']==null ? '' : $variant['option1'],
                        'option2'  =>  $variant['option2']==null ? '' : $variant['option2'],
                        'option3'  =>  $variant['option3']==null ? '' : $variant['option3'],
                        'weight'  =>  $variant['weight']==null ? 0 : $variant['weight'],
                        'weight_unit'  =>  $variant['weight_unit']==null ? '' : $variant['weight_unit'],
                        // 'inventory_policy'  =>  $variant['inventory_policy'],
                        // 'height'  =>  $height,
                        // 'width'  =>  $width,
                        // 'length'  =>  $length,
                        'update_time'  =>  time()
                      ];
                      $variant_id = Db::name('product_import_variants')->where(['shopify_variant_id'=>$variant->id])->update($var_data);
                      if(!$variant_id){
                        Db::rollback();
                        $this->error(__('add variant fail'));
                      }
                      // $log_data = [
                      //   'in_quantity'  =>  $variant['inventory_quantity'],
                      //   'stock'  =>  $variant['inventory_quantity'],
                      //   'product_variant_id'  =>  $variant_id,
                      //   'create_time'  =>  time()
                      // ];
                      // $log_res = Db::name('inventory_log')->insert($log_data);
                      // if(!$log_res){
                      //   Db::rollback();
                      //   $this->error(__('add inventory_log fail'));
                      // }
                    }
                  
                    foreach($product->images as $k => $image){
                      $var_data = [
                        'import_id'  =>  $product_id,
                        'src'  =>  $image['src'],
                        'width'  =>  $image['width'],
                        'height'  =>  $image['height'],
                        'position'=>$image['position'],
                        'create_time'  =>  time()
                      ];
                      $option_id = Db::name('product_import_images')->insertGetId($var_data);
                      if(!$option_id){
                        Db::rollback();
                        $this->error(__('add option fail'));
                      }
                    }
                  
                  Db::commit();
                  }catch (Exception $e) {
                      Db::rollback();
                      var_dump($e->getMessage());
                      die;
                  }
                }else{
                  
                  Db::startTrans();
                  try{
                  $data = [
                    'title'  =>  $product->title,
                    'description'  =>  $product->body_html,
                    'tag_ids'  =>  $tag_ids,
                    'product_type'  =>  $product->product_type,
                    'body_html'  =>  $product->body_html,
                    'shop_id'  =>  $shop_id,
                    'finder_user_id'  =>  $finder_user_id,
                    'shopify_product_id'  =>  $product->id,
                    'is_inport' => 1,
                    'create_time'=>time()
                  ];
                  
                  $product_id = Db::name('product_import')->insertGetId($data);
                  if(!$product_id){
                    Db::rollback();
                    $this->error(__('add fail'));
                  }
                  
                    
                    foreach($product->options as $k => $option){
                      $var_data = [
                        'import_id'  =>  $product_id,
                        'name'  =>  $option->name,
                        'values'  =>  implode(',',$option->values),
                        'position'  =>  $option->position,
                        'create_time'  =>  time()
                      ];
                      $option_id = Db::name('product_import_options')->insertGetId($var_data);
                      if(!$option_id){
                        Db::rollback();
                        $this->error(__('add option fail'));
                      }
                    }
                    
                    foreach($product->variants as $variant){
                      
                      $var_data = [
                        'import_id'  =>  $product_id,
                        'barcode'  =>  $variant->barcode==null ? '' : $variant->barcode,
                        'sku'  =>  $variant->sku,
                        // 'cost'  =>  $variant->cost==null ? 0 : $variant->cost,
                        'compare_at_price'  =>  $variant->compare_at_price==null ? 0 : $variant->compare_at_price,
                        'market_price'  =>  $variant->price==null ? 0 : $variant->price,
                        // 'shipping'  =>  $shipping,
                        'inventory_quantity'  =>  $variant->inventory_quantity,
                        // 'image_id'  =>  $variant['imagesId'],
                        'option1'  =>  $variant->option1==null ? '' : $variant->option1,
                        'option2'  =>  $variant->option2==null ? '' : $variant->option2,
                        'option3'  =>  $variant->option3==null ? '' : $variant->option3,
                        'weight'  =>  $variant->weight==null ? 0 : $variant->weight,
                        'weight_unit'  =>  $variant->weight_unit==null ? '' : $variant->weight_unit,
                        'inventory_policy'  =>  $variant->inventory_policy,
                        // 'height'  =>  $height,
                        // 'width'  =>  $width,
                        // 'length'  =>  $length,
                        'create_time'  =>  time()
                      ];
                      $variant_id = Db::name('product_import_variants')->insertGetId($var_data);
                      if(!$variant_id){
                        Db::rollback();
                        $this->error(__('add variant fail'));
                      }
                      $log_data = [
                        'in_quantity'  =>  $variant->inventory_quantity,
                        'stock'  =>  $variant->inventory_quantity,
                        'product_variant_id'  =>  $variant_id,
                        'shop_id'  =>  $shop_id,
                        'memo'  =>  '新增商品入库',
                        'create_time'  =>  time()
                      ];
                      $log_res = Db::name('inventory_log')->insert($log_data);
                      if(!$log_res){
                        Db::rollback();
                        $this->error(__('add inventory_log fail'));
                      }
                    }
                  
                    foreach($product->images as $k => $image){
                      $var_data = [
                        'import_id'  =>  $product_id,
                        'src'  =>  $image->src,
                        'width'  =>  $image->width,
                        'height'  =>  $image->height,
                        'position'=>$image->position,
                        'create_time'  =>  time()
                      ];
                      $image_id = Db::name('product_import_images')->insertGetId($var_data);
                      if(!$image_id){
                        Db::rollback();
                        $this->error(__('add option fail'));
                      }
                    }
                  
                  Db::commit();
                  }catch (Exception $e) {
                      Db::rollback();
                      var_dump($e->getMessage());
                      die;
                  }
                }
      }

      $this->success('请求成功');
    }
}
