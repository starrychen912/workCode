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
use think\Db;

use function GuzzleHttp\json_decode;

class Shopifyorders extends Command
{

    protected function configure()
    {
        $this
            ->setName('Shopifyorders')
            ->setDescription('Import orders from shopify store');
    }

    protected function execute(Input $input, Output $output)
    {
        $shop_list = Db::name('shop')->where(['type'=>'shopify'])->select();
        if(!$shop_list){
            echo "no shop";
            die;
        }
        Context::initialize(config('shopify.apiKey'),config('shopify.apiSecretKey'),config('shopify.scopes'),config('shopify.hostName'),new FileSessionStorage());
        foreach($shop_list as $shop){
            // if(empty($shop['apiKey']) || empty($shop['apiSecretKey'])){
            //     echo "no key";
            //     continue;
            // }
            
            $postData = [
                    "created_at_min" => date("Y-m-d H:i:s",time()-30*86400),
                    // "fields" => "id,name,total_price"
                    // "limit" => "1",
            ];
            // $shop_name = Db::name('finder_user')->where(['id'=>$shop['finder_user_id']])->value('shop');
            $session = Context::$SESSION_STORAGE->loadSession($shop['name']);
            $client = new Rest($session->getShop(), $session->getAccessToken());     
            $response = $client->get('orders',[],$postData);
            $res_order=json_decode($response->getBody());
            if(!empty($res_order->errors))var_dump($res_order->errors);
            // var_dump($res_order);die;
            Db::startTrans();
            try{
            foreach($res_order->orders as $order){
                $find = Db::name('order')->where(['shopify_order_id'=>$order->id])->find();
                if($find){
                    if(!in_array($find['financial_status'],array(3,5,6)) && $find['financial_status']!=$order->financial_status){
                        Db::name('order')->where(['shopify_order_id'=>$order->id])->update(['financial_status'=>$this->getFinancialStatus($order->financial_status)]);
                    }
                    foreach($order->line_items as $v){
                        $find_item = Db::name('order_item')->where(['shopify_item_id'=>$v->id])->find();
                        if($find_item && $find_item['fulfillment_status']!=$this->getFulfillmentStatus($v->fulfillment_status)){
                            Db::name('order_item')->where(['shopify_item_id'=>$v->id])->update(['fulfillment_status'=>$this->getFulfillmentStatus($v->fulfillment_status)]);
                        }
                    }
                    continue;
                }

                    $data = [
                        'shopify_order_id'  => $order->id,
                        'app_id'  => $order->app_id,
                        'browser_ip'  => $order->browser_ip ? $order->browser_ip : '',
                        'cancel_reason'  => $order->cancel_reason ? $order->cancel_reason : '',
                        'currency'  => $order->currency,
                        'current_total_discounts'  => $order->current_total_discounts,
                        // 'current_total_discounts_set'  => $order->current_total_discounts_set,
                        // 'current_total_duties_set'  => $order->current_total_duties_set,
                        'current_total_price'  => $order->current_total_price,
                        // 'current_total_price_set'  => $order->current_total_price_set,
                        'current_subtotal_price'  => $order->current_subtotal_price,
                        // 'current_subtotal_price_set'  => $order->current_subtotal_price_set,
                        'current_total_tax'  => $order->current_total_tax,
                        'current_total_tax_set'  => $order->current_total_tax_set,
                        'estimated_taxes'  => $order->estimated_taxes,
                        'financial_status'  => $order->financial_status,
                        'name'  => $order->name,
                        'note'  => $order->note ? $order->note : '',
                        'token'  => $order->token,
                        'finder_user_id'=>$shop['finder_user_id'],
                        'shop_id'=>$shop['id'],
                        'create_time'  => time(),
                    ];
                    
                    $data['financial_status'] = $this->getFinancialStatus($order->financial_status);
                    $data['fulfillment_status'] = $this->getFinancialStatus($order->fulfillment_status);

                    $order_id = Db::name('order')->insertGetId($data);
                    if(!$order_id>0){
                        Db::rollback();
                        echo "添加订单失败";
                        die;
                    }
                    foreach($order->line_items as $v){

                        
                        $item_data = [
                            'shopify_item_id'  => $v->id,
                            'price'  => $v->price,
                            'quantity'  => $v->quantity,
                            'sku'  => $v->sku,
                            'order_id'  => $order_id,
                            'name'  => $v->name,
                            'finder_user_id'=>$shop['finder_user_id'],
                            'shop_id'=>$shop['id'],
                            'create_time'  => time(),
                        ];
                        
                        $item_data['fulfillment_status'] = $this->getFulfillmentStatus($v->fulfillment_status);
                        
                        $order_item_id = Db::name('order_item')->insertGetId($item_data);
                        if(!$order_item_id){
                            Db::rollback();
                            echo "添加订单item失败";
                            die;
                        }

                        $product_variant = Db::name('product_variants')->alias('v')
                                           ->join('product p','v.product_id = p.id')
                                           ->where(['v.sku'=>$v->sku,'p.title'=>$v->name])->field('v.id,v.product_id')->find();

                        if($product_variant){
                                $order_item_res = Db::name('order_item')->where(['id'=>$order_item_id])->update(['product_variant_id'=>$product_variant['id']]);
                                // $order_res = Db::name('order')->where(['id'=>$order_id])->update(['product_id'=>$product_variant['product_id']]);
                                Db::name('product')->where(['id'=>$product_variant['product_id']])->setinc('orders');
                                if(!$order_item_res){
                                    Db::rollback();
                                    echo "更新订单失败".Db::name('order_item')->getLastSql();
                                    die;
                                }
                            
                        }
                    }

                
            } 
            Db::commit();
            }catch (Exception $e) {
                Db::rollback();
                var_dump($e->getMessage());
                die;
            }
            echo "添加成功";
        }

        
        




        // file_put_contents("/tmp/order.txt","order:".json_encode($res_order)."\n",FILE_APPEND);
        // var_dump($res_order);die;
        

    }

    protected function getFinancialStatus($status = ""){
        switch($status){
            case 'pending':
                $status = 0;
                break;
            case 'partially_paid':
                $status = 2;
                break;
            case 'paid':
                $status = 3;
                break;
            case 'partially_refunded':
                $status = 4;
                break;
            case 'refunded':
                $status = 5;
                break;
            case 'voided':
                $status = 6;
                break;
            default:
                $status = 0;
                break;
        }
        return $status;
    }


    protected function getFulfillmentStatus($status = ""){
        switch(trim($status)){
            case 'fulfilled':
                $status = 1;
                break;
            case 'partial':
                $status = 3;
                break;
            // case 'shipped':
            //     $status = 2;
            //     break;
            // case 'unshipped':
            //     $status = 3;
            //     break;
            case 'unfulfilled':
                $status = 0;
                break;
            default:
                $status = 0;
                break;
        }
        return $status;
    }
}
