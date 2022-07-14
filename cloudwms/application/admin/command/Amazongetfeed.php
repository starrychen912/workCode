<?php

namespace app\admin\command;

use think\Config;
use think\console\Command;
use think\console\Input;
use think\console\Output;
use think\Db;
use app\common\controller\Amazon;

use function GuzzleHttp\json_decode;

class Amazongetfeed extends Command
{

    protected function configure()
    {
        $this
            ->setName('Amazongetfeed')
            ->setDescription('GetFeed from amazon store');
    }

    protected function execute(Input $input, Output $output)
    {
        $feedlist = Db::name('amazon_feed_log')->where('status = 0')->select();
        if(!$feedlist)
        {
            echo "empty";die;
        }
        // var_dump($info_json);die;
        
        foreach($feedlist as $k => $feed){
            if($feed['status']==0){
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
                  $ResultFeedDocumentId = $amazon->getFeed($feed['feed_id']);
                  if($ResultFeedDocumentId && ($ResultFeedDocumentId!=null || !empty($ResultFeedDocumentId))){
                    $result = $amazon->getFeedDocument($ResultFeedDocumentId);
                    $data = [
                        'result_feedDocumentId'=>$ResultFeedDocumentId,
                        'status'=>1,
                        'feedDocumentReturn'=>$result,
                        'update_time'=>time()
                    ];
                    Db::name('amazon_feed_log')->where('id = '.$feed['id'])->update($data);
                  }
            }
                
                echo "Upload success";
            
        }
        
        
        echo "Upload success";die;

    }
}
