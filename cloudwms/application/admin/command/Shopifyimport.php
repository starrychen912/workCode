<?php

namespace app\admin\command;

use think\Config;
use think\console\Command;
use think\console\Input;
use think\console\Output;
use think\Exception;
use Shopify\Utils;
use Shopify\Context;
use Shopify\Auth\OAuth;
use Shopify\Auth\Session;
use Shopify\Clients\Rest;
use Shopify\Auth\FileSessionStorage;

use function GuzzleHttp\json_decode;

class Shopifyimport extends Command
{
    private  $redis = false;

    function initRedis($redis = false){

        if(!extension_loaded('Redis')){
            echo  json_encode(['code'=>0,'msg'=>'找不到Redis扩展'],JSON_UNESCAPED_UNICODE);die;
        }

        $this->redis = $redis;
        if (false === $this->redis) {
            $this->redis = new \Redis;
            $this->redis->connect('127.0.0.1',6379);
        }

        //选择数据库
        // $this->redis->select(1);
    }

    protected function configure()
    {
        $this
            ->setName('Shopifyimport')
            ->setDescription('Import product to shopify store');
    }

    protected function execute(Input $input, Output $output)
    {
        $this->initRedis();
        
        // $info_json = $this->redis->lRange('wait_import_images',0,-1);
        $length = $this->redis->lLen('wait_import_images');
        if($length==0)
        {
            echo "empty";die;
        }
        // var_dump($info_json);die;
        Context::initialize(config('shopify.apiKey'),config('shopify.apiSecretKey'),config('shopify.scopes'),config('shopify.hostName'),new FileSessionStorage());
        for($i=0;$i<$length;$i++){
            $info_json = $this->redis->rPop('wait_import_images');
            $info = json_decode($info_json,true);
            var_dump($info);
            if(isset($info['src'])){
                $postData = [
                    "image" => [
                        "src" => $info['src'],
                        ]
                ];
                $session = Context::$SESSION_STORAGE->loadSession($info['shop_name']);
                $client = new Rest($session->getShop(), $session->getAccessToken());     
                $response = $client->post('products/'.$info['product_id'].'/images',$postData);
                $res_img=json_decode($response->getBody());
                var_dump($res_img);
                if(!empty($res_img->errors)){
                    $this->redis->lPush('wait_import_images',$info_json);
                    echo "import false";continue;
                }
            }
            
            if(isset($info['sku'])){
                if($info['type']==1){
                     $variants_data= [
                        "variant" => [
                          "id" => $info['variant_id'],
                          "sku" => $info['sku'],
                          "cost" => $info['cost'],
                          "compare_at_price" => $info['compare_at_price'],
                          "barcode" => $info['barcode'],
                          'weight'=>$info['weight'],
                          'weight_unit'=>$info['weight_unit'],
                        //   'inventory_quantity'=>$info['inventory_quantity'],
                          "price" => $info['price']
                        ]
                      ];
                }
                if($info['type']==2){
                    $img_id = $res_img->image->id;
                    var_dump($img_id);
                    $variants_data= [
                        "variant" => [
                          "id" => $info['variant_id'],
                          "image_id" => $img_id,
                        ]
                      ];
                }
                $session = Context::$SESSION_STORAGE->loadSession($info['shop_name']);
                $client = new Rest($session->getShop(), $session->getAccessToken());
                $response = $client->put('variants/'.$info['variant_id'],$variants_data);
                $res_var=json_decode($response->getBody());
                if(!empty($res_var->errors)){
                    var_dump($res_var);
                    echo "import variants false";continue;
                }
                var_dump($res_var);
                echo "import variants success";
            }
        }
        
        
        echo "import success";die;

    }
}
