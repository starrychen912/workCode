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

class Amazonimg extends Command
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
            ->setName('Amazonimg')
            ->setDescription('Upload img to amazon store');
    }

    protected function execute(Input $input, Output $output)
    {
        $this->initRedis();
        // $info_json = $this->redis->lRange('wait_import_images',0,-1);
        $length = $this->redis->lLen('wait_uploadimg_queue');
        if($length==0)
        {
            echo "empty";die;
        }
        // var_dump($info_json);die;
        
        for($i=0;$i<$length;$i++){
            $info_json = $this->redis->rPop('wait_uploadimg_queue');
            $info = json_decode($info_json,true);
            var_dump($info);
            $v=\think\View::instance();
            $file=$v->fetch(ROOT_PATH."public/template/amazon/productimg.xml",$info);
            $result = uploadproduct($file,'POST_PRODUCT_IMAGE_DATA');
            if(!$result){
                
                $this->error(__('Upload fail plaese try again'));
            }
                
                echo "Upload success";
            
        }
        
        
        echo "Upload success";die;

    }
}
