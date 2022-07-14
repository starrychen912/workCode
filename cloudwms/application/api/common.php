<?php


use think\Db;
use think\Exception;
use Shopify\Context;
use Shopify\Clients\Rest;
use Shopify\Auth\FileSessionStorage;
use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Request;
use ClouSale\AmazonSellingPartnerAPI\Helpers\ASECryptoStream;


  


if (!function_exists('importProductToSohpify')) {
    /**
     * 产品导入到shopify
     * @ApiParams (name="product_ids", type="integer", required=true, description="产品id")
     * @ApiParams (name="finder_user_id", type="integer", required=true, description="用户id")
     *
     */
    function importProductToSohpify($product_id="",$finder_user_id=0)
    {
        
        if(empty($finder_user_id)||empty($product_id)){
            return __('Invalid parameters');
        }

        $shopify_shop = Db::name('shop')->where(['finder_user_id'=>$finder_user_id,'type'=>'shopify'])->find();
        if(!$shopify_shop){
            return __('Undefind shopify shop');
        }
        
        

        $where = [];
        if(!empty($product_id)){
          $where = [
                      'id'=>['in',$product_id],
                      'finder_user_id'=>$finder_user_id
                    ];
        }
        
        // $product_list = Db::name('product_import')->alias('p')
        //                 ->join('country c','p.country_id = c.id')
        //                 ->field('p.*,c.namecn,nameeng,nameengsp')
        //                 ->where($where)->select();
        // var_dump($product_list);die;
        $product_list = Db::name('product_import')->where($where)->select();
        if(!$product_list){
          return __('Invalid parameters').Db::name('product_import')->getLastSql();
        }
        
        Context::initialize(config('shopify.apiKey'),config('shopify.apiSecretKey'),config('shopify.scopes'),config('shopify.hostName'),new FileSessionStorage());
        $shop_name = Db::name('finder_user')->where(['id'=>$finder_user_id])->value('shop');

        foreach($product_list as $product){
            // $data = $product_list;
            $images = Db::name('product_import_images')->where(['import_id'=>$product['id']])->select();
            // $data['images'] = $images;
            $field = 'id as v_id,option1,option2,option3,cost,market_price as price,compare_at_price,sku,barcode,weight,weight_unit,inventory_quantity,image_id as img_id';
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
              
              
              $session = Context::$SESSION_STORAGE->loadSession($shop_name);
              $client = new Rest($session->getShop(), $session->getAccessToken());
              $response = $client->post('products',$productObj);
              $res=json_decode($response->getBody());
              // var_dump($res);die;
              if(!empty($res->errors))return $res->errors;

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
                  
                  Db::name('product_import_variants')->where(['id'=>$variants[$k]['v_id']])->update(['shopify_variant_id'=>$var->id]);
                   

                  // if($product['country_id']!=0){
                    $nameengsp = Db::name('country')->where(['id'=>$product['country_id']])->value('nameengsp');
                    $session = Context::$SESSION_STORAGE->loadSession($shop_name);
                    $client = new Rest($session->getShop(), $session->getAccessToken());
                    $response_res_items = $client->put("inventory_items/".$var->inventory_item_id,
                    [
                      "inventory_item" => [
                        "id" => $var->inventory_item_id,
                        "country_code_of_origin" => $nameengsp,
                        "harmonized_system_code" => $product['HScode']=='' ? null : $product['HScode'],
                        "tracked" => "true"
                      ]
                    ]);
                    // var_dump($response_res_items);die;
                    $res_items=json_decode($response_res_items->getBody());
                    if(!empty($res_items->errors))return $res_items->errors;
                  // }
                  $session = Context::$SESSION_STORAGE->loadSession($shop_name);
                  $client = new Rest($session->getShop(), $session->getAccessToken());
                  $response_res_inventory = $client->post("inventory_levels/set",
                  [
                    "location_id" => $location_id,
                    "inventory_item_id" => $var->inventory_item_id,
                    "available" => $variants[$k]['inventory_quantity']
                  ]);
                  $res_inventory=json_decode($response_res_inventory->getBody());
                  if(!empty($res_inventory->errors))return $res_inventory->errors;
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
        

        return 'ok';
    }
}



if (!function_exists('updateProductToSohpify')) {
  /**
   * 产品导入到shopify
   * @ApiParams (name="product_ids", type="integer", required=true, description="产品id")
   * @ApiParams (name="finder_user_id", type="integer", required=true, description="用户id")
   *
   */
  function updateProductToSohpify($product_id="",$finder_user_id=0,$image_urls="")
  {
      
      if(empty($finder_user_id)||empty($product_id)){
          return __('Invalid parameters');
      }

      $shopify_shop = Db::name('shop')->where(['finder_user_id'=>$finder_user_id,'type'=>'shopify'])->find();
      if(!$shopify_shop){
          return __('Undefind shopify shop');
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
        return __('Invalid parameters');
      }
      
      Context::initialize(config('shopify.apiKey'),config('shopify.apiSecretKey'),config('shopify.scopes'),config('shopify.hostName'),new FileSessionStorage());
      $shop_name = Db::name('finder_user')->where(['id'=>$finder_user_id])->value('shop');

      foreach($product_list as $product){

          if(empty($product['shopify_product_id'])){
            continue;
          }

          // $data = $product_list;
          $images = Db::name('product_import_images')->where(['import_id'=>$product['id']])->select();
          // $data['images'] = $images;
          $field = 'shopify_variant_id as id,cost,market_price as price,compare_at_price,sku,barcode,weight,weight_unit,inventory_quantity,image_id as img_id';
          $variants = Db::name('product_import_variants')->where(['import_id'=>$product['id']])->field($field)->select();
          // $data['variants'] = $variants;
          // var_dump($variants);var_dump($images);die;
          // var_dump($variants);die;
          $wait_data = [];
          $productObj=[
              'product'=> [
                'id'=> $product['shopify_product_id'],
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
            $response = $client->put('products/'.$product['shopify_product_id'],$productObj);
            $res=json_decode($response->getBody());
            // var_dump($res);die;
            if(!empty($res->errors))return $res->errors;

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
                if(!empty($res_items->errors))return $res_items->errors;


                if($var->inventory_quantity != $variants[$k]['inventory_quantity']){
                  $session = Context::$SESSION_STORAGE->loadSession($shop_name);
                  $client = new Rest($session->getShop(), $session->getAccessToken());
                  $response_res_inventory = $client->post("inventory_levels/set",
                  [
                    "location_id" => $location_id,
                    "inventory_item_id" => $var->inventory_item_id,
                    "available" => $variants[$k]['inventory_quantity']
                  ]);
                  $res_inventory=json_decode($response_res_inventory->getBody());
                  if(!empty($res_inventory->errors))return $res_inventory->errors;
                }
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
              
            if(!empty($image_urls)){
              $img_arr = explode(',',$image_urls);
              foreach($img_arr as $img){
                $wait_data[] = [
                  'shop_name'=>$shop_name,
                  'product_id'=>$res->product->id,
                  'src'=>'https://interface.ddtechinfo.com/'.$img
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
      }
      

      return 'ok';
  }

  
  
}