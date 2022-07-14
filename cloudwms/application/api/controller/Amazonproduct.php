<?php

namespace app\api\controller;

use app\common\controller\FinderApi;
use think\Db;
use think\Exception;

use app\common\controller\Amazon;

/**
 * 亚马逊产品接口
 */
class Amazonproduct extends FinderApi
{   
    protected $noNeedLogin = ['uploadproduct','operateProduct'];
    protected $noNeedRight = ['*'];


    

    /**
     * 商品操作接口
     * @ApiMethod (POST)
     * @ApiParams (name="finder_user_id", type="integer", required=true, description="用户id")
     * @ApiParams (name="shop_id", type="integer", required=true, description="店铺id")
     * @ApiParams (name="title", type="string", required=true, description="标题")
     * @ApiParams (name="description", type="string", required=false, description="产品介绍")
     * @ApiParams (name="out_link", type="string", required=false, description="外链")
     * @ApiParams (name="sku", type="string", required=false, description="sku")
     * @ApiParams (name="sale_price", type="integer", required=true, description="优惠价")
     * @ApiParams (name="compare_at_price", type="integer", required=true, description="原价")
     * @ApiParams (name="market_price", type="integer", required=true, description="市场价")
    //  * @ApiParams (name="shipping", type="integer", required=false, description="运费价")
     * @ApiParams (name="barcode", type="string", required=false, description="条码")
     * @ApiParams (name="barcode_type", type="string", required=false, description="条码类型")
     * @ApiParams (name="quantity", type="integer", required=false, description="数量")
    //  * @ApiParams (name="options", type="string", required=false, description="选项")
    //  * @ApiParams (name="variants", type="string", required=false, description="变体")
     * @ApiParams (name="image_urls", type="string", required=false, description="图片地址，多个以,隔开")
     * @ApiParams (name="product_status", type="integer", required=false, description="状态:0=active销售中,1=archived已下架,2=draft未上架	")
     * @ApiParams (name="tag_ids", type="string", required=false, description="标签ids，多个以,隔开")
    //  * @ApiParams (name="category_id", type="integer", required=false, description="分类id")
     * @ApiParams (name="product_type", type="string", required=false, description="产品类型")
     * @ApiParams (name="weight", type="integer", required=false, description="重量")
     * @ApiParams (name="weight_unit", type="string", required=false, description="重量单位")
     * @ApiParams (name="height", type="string", required=false, description="高")
     * @ApiParams (name="width", type="string", required=false, description="宽")
     * @ApiParams (name="length", type="string", required=false, description="长")
     * @ApiParams (name="dimensions_unit", type="string", required=false, description="尺寸单位")
     * @ApiParams (name="package_weight", type="integer", required=false, description="包装重量")
     * @ApiParams (name="package_weight_unit", type="string", required=false, description="包装重量单位")
     * @ApiParams (name="package_height", type="string", required=false, description="包装高")
     * @ApiParams (name="package_width", type="string", required=false, description="包装宽")
     * @ApiParams (name="package_length", type="string", required=false, description="包装长")
     * @ApiParams (name="package_dimensions_unit", type="string", required=false, description="包装尺寸单位")
     * @ApiParams (name="shipping_weight", type="integer", required=false, description="运输重量")
     * @ApiParams (name="shipping_weight_unit", type="string", required=false, description="运输重量单位")
    //  * @ApiParams (name="inventory_policy", type="integer", required=false, description="缺货下单:0=deny不能,1=continue能")
    //  * @ApiParams (name="country_id", type="integer", required=false, description="国家id")
    //  * @ApiParams (name="supplier_id", type="integer", required=false, description="供应商id")
    //  * @ApiParams (name="HScode", type="string", required=false, description="海关代码")
     * @ApiParams (name="launchDate", type="string", required=false, description="发售日期")
     * @ApiParams (name="releaseDate", type="string", required=false, description="上线日期")
     * @ApiParams (name="conditionType", type="string", required=false, description="状况")
     * @ApiParams (name="conditionNote", type="string", required=false, description="状况说明")
     * @ApiParams (name="itemPackageQuantity", type="string", required=false, description="商品包装数量")
     * @ApiParams (name="numberOfItems", type="string", required=false, description="商品编码")
     * @ApiParams (name="brand", type="string", required=false, description="品牌")
     * @ApiParams (name="Manufacturer", type="string", required=false, description="制造商")
     * @ApiParams (name="MfrPartNumber", type="string", required=false, description="制造商零件编号")
     * @ApiParams (name="SearchTerms", type="string", required=false, description="搜索词")
     * @ApiParams (name="UnitCount", type="string", required=false, description="单位数量")
     * @ApiParams (name="PPUCountType", type="string", required=false, description="单位类型")
     * @ApiParams (name="IsExpirationDatedProduct", type="string", required=false, description="是否有保质期限")
     * @ApiParams (name="item_type", type="string", required=false, description="子分类")
     * @ApiParams (name="first_product_type", type="string", required=false, description="一级分类")
     * @ApiParams (name="second_product_type", type="string", required=false, description="二级分类")
     * @ApiParams (name="BulletPoint1", type="string", required=false, description="BulletPoint1")
     * @ApiParams (name="BulletPoint2", type="string", required=false, description="BulletPoint2")
     * @ApiParams (name="BulletPoint3", type="string", required=false, description="BulletPoint3")
     * @ApiParams (name="BulletPoint4", type="string", required=false, description="BulletPoint4")
     * @ApiParams (name="BulletPoint5", type="string", required=false, description="BulletPoint5")
     * @ApiParams (name="operation_type", type="string", required=true, description="操作类型:添加:'ADD',修改:'MODIFY'")
     * @ApiParams (name="product_id", type="string", required=false, description="产品id")
     */
    public function operateProduct(){
      $post_data = $this->request->instance()->post(false);
      // var_dump($post_data);die;
      $finder_user_id = $post_data['finder_user_id'];
      $shop_id = isset($post_data['shop_id']) ? $post_data['shop_id'] : '';
      $title = $post_data['title'];
      $description = isset($post_data['description']) ? $post_data['description'] : '';
      $out_link = isset($post_data['out_link']) ? $post_data['out_link'] : '';
      $sku = isset($post_data['sku']) ? $post_data['sku'] : '';
      $sale_price = isset($post_data['sale_price']) ? $post_data['sale_price'] : 0;
      $compare_at_price = isset($post_data['compare_at_price']) ? $post_data['compare_at_price'] : 0;
      $market_price = $post_data['market_price'];
    //   $shipping = isset($post_data['shipping']) ? $post_data['shipping'] : '';
      $barcode = isset($post_data['barcode']) ? $post_data['barcode'] : '';
      $barcode_type = isset($post_data['barcode_type']) ? $post_data['barcode_type'] : '';
      $quantity = isset($post_data['quantity']) ? $post_data['quantity'] : '';
      // $options = $post_data['options'];
      // $variants = $post_data['variants'];
      $image_urls = isset($post_data['image_urls']) ? $post_data['image_urls'] : '';
    //   $product_status = isset($post_data['product_status']) ? $post_data['product_status'] : 2;
      $tag_ids = isset($post_data['tag_ids']) ? $post_data['tag_ids'] : '';
      // $category_id = isset($post_data['category_id']) ? $post_data['category_id'] : 0;
      $product_type = isset($post_data['product_type']) ? $post_data['product_type'] : '';
      $weight = isset($post_data['weight']) ? $post_data['weight'] : 0;
      $weight_unit = isset($post_data['weight_unit']) ? $post_data['weight_unit'] : '';
    //   $inventory_policy = isset($post_data['inventory_policy']) ? $post_data['inventory_policy'] : 0;
      $height = isset($post_data['height']) ? $post_data['height'] : 0;
      $width = isset($post_data['width']) ? $post_data['width'] : 0;
      $length = isset($post_data['length']) ? $post_data['length'] : 0;
      $dimensions_unit = isset($post_data['dimensions_unit']) ? $post_data['dimensions_unit'] : '';

      $package_weight = isset($post_data['package_weight']) ? $post_data['package_weight'] : 0;
      $package_weight_unit = isset($post_data['package_weight_unit']) ? $post_data['package_weight_unit'] : '';
    //   $inventory_policy = isset($post_data['inventory_policy']) ? $post_data['inventory_policy'] : 0;
      $package_height = isset($post_data['package_height']) ? $post_data['package_height'] : 0;
      $package_width = isset($post_data['package_width']) ? $post_data['package_width'] : 0;
      $package_length = isset($post_data['package_length']) ? $post_data['package_length'] : 0;
      $package_dimensions_unit = isset($post_data['package_dimensions_unit']) ? $post_data['package_dimensions_unit'] : '';

      $shipping_weight = isset($post_data['shipping_weight']) ? $post_data['shipping_weight'] : 0;
      $shipping_weight_unit = isset($post_data['shipping_weight_unit']) ? $post_data['shipping_weight_unit'] : '';
    //   $country_id = isset($post_data['country_id']) ? $post_data['country_id'] : 0;
    //   $supplier_id = isset($post_data['supplier_id']) ? $post_data['supplier_id'] : 0;
    //   $HScode = isset($post_data['HScode']) ? $post_data['HScode'] : '';
      $launchDate = isset($post_data['launchDate']) ? $post_data['launchDate'] : '';
      $releaseDate = isset($post_data['releaseDate']) ? $post_data['releaseDate'] : '';
      $conditionType = isset($post_data['conditionType']) ? $post_data['conditionType'] : '';
      $conditionNote = isset($post_data['conditionNote']) ? $post_data['conditionNote'] : '';
      $itemPackageQuantity = isset($post_data['itemPackageQuantity']) ? $post_data['itemPackageQuantity'] : '';
      $numberOfItems = isset($post_data['numberOfItems']) ? $post_data['numberOfItems'] : '';
      $brand = isset($post_data['brand']) ? $post_data['brand'] : '';
      $Manufacturer = isset($post_data['manufacturer']) ? $post_data['manufacturer'] : '';
      $MfrPartNumber = isset($post_data['mfrPartNumber']) ? $post_data['mfrPartNumber'] : '';
      $SearchTerms = isset($post_data['searchTerms']) ? $post_data['searchTerms'] : '';
      $UnitCount = isset($post_data['unitCount']) ? $post_data['unitCount'] : '';
      $PPUCountType = isset($post_data['PPUCountType']) ? $post_data['PPUCountType'] : '';
      $IsExpirationDatedProduct = isset($post_data['IsExpirationDatedProduct']) ? $post_data['IsExpirationDatedProduct'] : 0;
      $item_type = isset($post_data['item_type']) ? $post_data['item_type'] : '';
      $first_product_type = isset($post_data['first_product_type']) ? $post_data['first_product_type'] : '';
      $second_product_type = isset($post_data['second_product_type']) ? $post_data['second_product_type'] : '';
      $BulletPoint1 = isset($post_data['BulletPoint1']) ? $post_data['BulletPoint1'] : '';
      $BulletPoint2 = isset($post_data['BulletPoint2']) ? $post_data['BulletPoint2'] : '';
      $BulletPoint3 = isset($post_data['BulletPoint3']) ? $post_data['BulletPoint3'] : '';
      $BulletPoint4 = isset($post_data['BulletPoint4']) ? $post_data['BulletPoint4'] : '';
      $BulletPoint5 = isset($post_data['BulletPoint5']) ? $post_data['BulletPoint5'] : '';
      $operation_type = isset($post_data['operation_type']) ? $post_data['operation_type'] : '';
      $product_id = isset($post_data['product_id']) ? $post_data['product_id'] : '';

      if(empty($title)||empty($sale_price)||empty($compare_at_price)||empty($market_price)||empty($operation_type)){
        $this->error(__('Invalid parameters'));
      }

      $product_query = Db::name('product_import');
      $variant_query = Db::name('product_import_variants');
      $image_query = Db::name('product_import_images');
      $option_query = Db::name('product_import_options');
      $prdid = 'import_id';
        
      Db::startTrans();
      try{
        $data = [
          'title'  =>  $title,
          'description'  =>  $description,
          'out_link'  =>  $out_link,
          'finder_user_id'  =>  $finder_user_id,
          'shop_id'  =>  $shop_id,
          // 'is_open'  =>  1,
          // 'status'  =>  $product_status,
          'tag_ids'  =>  $tag_ids,
          'product_type'  =>  $product_type,
          // 'category_id'  =>  $category_id,
          // 'supplier_id'  =>  $supplier_id,
          // 'country_id'  =>  $country_id,
          // 'HScode'  =>  $HScode,
          'manufacturer'  =>  $Manufacturer,
          'mfr_part_number'  =>  $MfrPartNumber,
        ];

        if($operation_type == 'ADD'){
          $res_product_id = $product_query->insertGetId($data);
        }else if($operation_type == 'MODIFY'){
          $res_product_id = $product_query->where('id = '.$product_id)->update($data);
        }
        if(!$res_product_id){
          Db::rollback();
          $this->error(__('do fail').$product_query->getLastSql());
        }
        
          $var_data = [
            'barcode'  =>  $barcode,
            'sku'  =>  $sku,
            // 'sale_price'  =>  $sale_price,
            'compare_at_price'  =>  $compare_at_price,
            'market_price'  =>  $market_price,
            // 'shipping'  =>  $shipping,
            'inventory_quantity'  =>  $quantity,
            'weight'  =>  $weight,
            'weight_unit'  =>  $weight_unit,
            // 'inventory_policy'  =>  $inventory_policy,
            'height'  =>  $height,
            'width'  =>  $width,
            'length'  =>  $length,
            'bullet_point1'  =>  $BulletPoint1,
            'bullet_point2'  =>  $BulletPoint2,
            'bullet_point3'  =>  $BulletPoint3,
            'bullet_point4'  =>  $BulletPoint4,
            'bullet_point5'  =>  $BulletPoint5,
            'barcode_type'  =>  $barcode_type,
            'is_product_expirable'  =>  $IsExpirationDatedProduct,
            'sale_price'  =>  $sale_price,
            'create_time'  =>  time()
          ];

          if($operation_type == 'ADD'){
            $var_data[$prdid]  =  $res_product_id;
            $variant_id = $variant_query->insertGetId($var_data);
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
          }else if($operation_type == 'MODIFY'){
            $variant_id = $variant_query->where('import_id = '.$product_id)->update($var_data);
          }
          
          if(!$variant_id){
            Db::rollback();
            $this->error(__('do variant fail'));
          }
          
  
        

        if(!empty($image_urls)){
          $img_arr = explode(',',$image_urls);
          foreach($img_arr as $k => $img){
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
            if($k==0){
              $type = 'MAIN';
            }else{
              $type = 'PT'.$k;
            }
            //使用redis
              $redis = new \Redis;
              $redis->connect('127.0.0.1',6379);
              $redis->lPush('wait_uploadimg_queue',json_encode(['sku'=>$sku,'type'=>$type,'location'=>cdnurl($img)]));
          }
          
        }

        $v=\think\View::instance();
        $file=$v->fetch($_SERVER['DOCUMENT_ROOT']."/template/amazon/product.xml",["product"=>$post_data]);
        // $result = uploadproduct($file,'POST_PRODUCT_DATA');

        $options = [
              'refresh_token' => 'Atzr|IwEBIJNVKrtgw2rlp6cpOaarulY0UoWvGQUlVfNZpOe9Phc-6erCr9P_ZtYbVhgLxPYMavCfWEjxjzyS7wX3H5rNnBqLhmsBtJxAeLoFmW52o6JB5hiFe8R6avkKpz0B2olDQzz6g6K4yfmwTwEAkOXvqgPD5js7W4Qr1U0jMzd62nBj_aM8mMojYFWy32QDTuuHwwcOJP3iSeT8Qhzo5GxXZTjBACj6ezQGHr_JoG7RoE1v5LaFvkKmHwm8GJyN1-uV5QZFdh2_MpVlql9aN3YE3S-dWEP8O_5BA-JXOwCbOpEaI3wK2aaNl-FNBp2HJog0atA', // Aztr|...
              'client_id' => 'amzn1.application-oa2-client.ed76124a57eb438fbfdfcaf71c146798', // App ID from Seller Central, amzn1.sellerapps.app.cfbfac4a-......
              'client_secret' => 'd4194f87b6a774b56c5d8515b2db34984a78c18a973d7a33509e762e4f3c51ff', // The corresponding Client Secret
              'region' => \ClouSale\AmazonSellingPartnerAPI\SellingPartnerRegion::$NORTH_AMERICA, // or NORTH_AMERICA / FAR_EAST
              'access_key' => 'AKIA3XXRPRTQJDRZOVSN', // Access Key of AWS IAM User, for example AKIAABCDJKEHFJDS
              'secret_key' => 'WG1y7+G1OOX3bljJBzcmxVOLB5gW79SCcc85WhCD', // Secret Key of AWS IAM User
  
              'endpoint' => \ClouSale\AmazonSellingPartnerAPI\SellingPartnerEndpoint::$NORTH_AMERICA, // or NORTH_AMERICA / FAR_EAST
              'role_arn' => 'arn:aws:iam::806886542560:role/SellingPartnerRole',
        ];

        $amazon = new Amazon($options);
        $result = $amazon->uploadproduct($file,'POST_PRODUCT_DATA');

        if(!$result){
            Db::rollback();
            $this->error(__('import fail plaese try again'));
        }

        Db::commit();
        
        
        $this->success(__('successful'));
      }catch (Exception $e) {
        Db::rollback();
        $this->error($e->getMessage());
      }
      
      

        

    }


    /**
     * 商品调价
     * @ApiMethod (POST)
     * @ApiParams (name="product_ids", type="integer", required=true, description="产品id")
     * @ApiParams (name="finder_user_id", type="integer", required=true, description="用户id")
     * @ApiParams (name="shop_id", type="integer", required=true, description="店铺id")
     * @ApiParams (name="sale_price", type="integer", required=false, description="优惠价格")
     * @ApiParams (name="StartDate", type="integer", required=false, description="优惠开始日期")
     * @ApiParams (name="EndDate", type="integer", required=false, description="优惠结束日期")
     * @ApiParams (name="compare_at_price", type="integer", required=false, description="原价")
     */
    public function updateProductPrice()
    {
      $product_id = $this->request->post('product_ids',0);
      $finder_user_id = $this->request->post('finder_user_id',0);
      $shop_id = $this->request->post('shop_id',0);
      $sale_price = $this->request->post('sale_price',0);
      $compare_at_price = $this->request->post('compare_at_price',0);
      // $market_price = $this->request->post('market_price',0);
      // $all_percent = $this->request->post('all_percent',0);
      $StartDate = $this->request->post('StartDate','');
      $EndDate = $this->request->post('EndDate','');

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
          if(!empty($sale_price)){
            $data['sale_price'] = $cost>0 ? Db::raw('sale_price+sale_price*'.$sale_price) : Db::raw('sale_price-sale_price*'.abs($sale_price));
          }
          if(!empty($compare_at_price)){
            $data['compare_at_price'] = $compare_at_price>0 ? Db::raw('compare_at_price+compare_at_price*'.$compare_at_price) : Db::raw('compare_at_price-compare_at_price*'.abs($compare_at_price));
          }
          // if(!empty($market_price)){
          //   $data['market_price'] = $market_price>0 ? Db::raw('market_price+market_price*'.$market_price) : Db::raw('market_price-market_price*'.abs($market_price));
          // }
        // }

      

      
      if($shop['type']=='amazon'){


        $product_ids = Db::name('product_import')->where(['finder_user_id'=>$finder_user_id,'id'=>['in',$product_id]])->column('id');
        $ids = implode(',', $product_ids);

        $ress = Db::name('product_import_variants')->where(['import_id'=>['in',$ids]])->update($data);
        if(!$ress){
          $this->error(__('Update fail'));
        }

        $variants = Db::name('product_import_variants')->where(['import_id'=>['in',$ids]])->field('sku,compare_at_price,sale_price,cost')->select();

        foreach($variants as $v){
          if($v['shopify_variant_id']==0){
            continue;
          }
          $postData = 	[
              "sku" => $v['shopify_variant_id'],
              "compare_at_price" => $v['compare_at_price'],
              "sale_price" => $v['sale_price'],
              "StartDate" => $StartDate ? $StartDate : '',
              "EndDate" => $EndDate ? $EndDate : '',
          ]; 
          
          $v=\think\View::instance();
          $file=$v->fetch($_SERVER['DOCUMENT_ROOT']."/template/amazon/productprice.xml",$postData);
          $result = uploadproduct($file,'POST_PRODUCT_PRICING_DATA');
          if(!$result )$this->error(__('Update fail'));
        }

        
      }


      $this->success(__('successful'));

    }

    

}