<?php

namespace app\api\controller;

use app\common\controller\FinderApi;
use think\Db;


/**
 * 订单接口类
 */
class Order extends FinderApi
{

    protected $noNeedLogin = [];
    protected $noNeedRight = ['*'];
    /**
     * 订单列表
     * @ApiMethod (POST)
     * @ApiParams (name="finder_user_id", type="integer", required=true, description="用户id")
     * @ApiParams (name="shop_id", type="integer", required=false, description="店铺id")
     * @ApiParams (name="type", type="integer", required=false, description="订单类型0：自有供应，1：其他")
     * @ApiParams (name="status", type="integer", required=false, description="订单状态0：代发货，1：已发货，2：已完成")
     * @ApiParams (name="page_num", type="integer", required=false, description="第几页")
     * @ApiParams (name="per_page_num", type="integer", required=false, description="每页数量")
     */
    public function orderList()
    {
        $finder_user_id = $this->request->post('finder_user_id',0);
        $shop_id = $this->request->post('shop_id',0);
        $type = $this->request->post('type',0);
        $status = $this->request->post('status','');
        $page_num = $this->request->post('page_num',1);
        $per_page_num = $this->request->post('per_page_num',10);
        if(empty($finder_user_id)){
            $this->error(__('Invalid parameters'));
        }
        $data = [];
        $where = [];
            $where['o.finder_user_id'] = $finder_user_id;
            if(!empty($shop_id)){
                $where['o.shop_id'] = $shop_id;
            }
            if($status!=''){
                $where['i.fulfillment_status'] = $status;
            }
        $order_list = \app\admin\model\order\Order::alias('o')
                      ->join('order_item i','o.id = i.order_id')
                      ->where($where)
                      ->field('o.*')
                      ->order('o.id desc')
                      ->paginate($per_page_num,false,['page'=>$page_num]);
        // $data = $order_list;
        $data = [
              'total'     => $order_list->total(),         // 总记录数
              'cur'       => $order_list->currentPage(),   // 当前页码
              'size'      => $order_list->listRows(),      // 每页记录数
              'data'      => $order_list->items()          // 分页数据
        ];
        // var_dump($data['data']);die;
        foreach($order_list as $k=>$v){

            $where = [];
            $where['order_id'] = $v->id;
            if($status!=''){
                $where['fulfillment_status'] = $status;
            }
            $item_list = Db::name('order_item')->where($where)->select();
            foreach($item_list as $j=>$i){
                $product_variant = Db::name('product_variants')->where(['id'=>$i['product_variant_id']])->field('product_id')->find();
                $product = \app\admin\model\product\Product::where(['id'=>$product_variant['product_id']])->field('title,shop_id')->find();
                $images = \app\admin\model\product\Images::where(['product_id'=>$product_variant['product_id']])->find();
                $shop = Db::name('shop')->where(['id'=>$product['shop_id']])->value('name');
                
// if($v->id==29)var_dump($product['title']);die;
                if(empty($shop_id)){
                    $shop_id_arr = Db::name('shop')->where(['finder_user_id'=>$finder_user_id])->column('id');
                    if($type==0){
                        if(in_array($product['shop_id'],$shop_id_arr)){
                            $item_list[$j]['images'] = $images['src'] ? cdnurl($images['src'],true) : '';
                            
                            $item_list[$j]['title'] = $product['title'];
            
                            $item_list[$j]['supplier_name'] = !empty($shop)?$shop:'';
                        }else{
                            unset($item_list[$j]);
                        }
                    }else if($type==1){
                        if(!in_array($product['shop_id'],$shop_id_arr)){
                            $item_list[$j]['images'] = $images['src'] ? cdnurl($images['src'],true) : '';
                            
                            $item_list[$j]['title'] = $product['title'];
            
                            $item_list[$j]['supplier_name'] = !empty($shop)?$shop:'';
                        }else{
                            unset($item_list[$j]);
                        }
                    }
                }else{
                    if($type==0){
                        if($shop_id==$product['shop_id']){
                            $item_list[$j]['images'] = $images['src'] ? cdnurl($images['src'],true) : '';
                            
                            $item_list[$j]['title'] = $product['title'];
            
                            $item_list[$j]['supplier_name'] = !empty($shop)?$shop:'';
                        }else{
                            unset($item_list[$j]);
                        }
                    }else if($type==1){
                        if($shop_id!=$product['shop_id']){
                            $item_list[$j]['images'] = $images['src'] ? cdnurl($images['src'],true) : '';
                            
                            $item_list[$j]['title'] = $product['title'];
            
                            $item_list[$j]['supplier_name'] = !empty($shop)?$shop:'';
                        }else{
                            unset($item_list[$j]);
                        }
                    }
                }
                

                
            }
            if(!empty($item_list)){
                $data['data'][$k]['order_item'] = $item_list;
            }else{
                unset($data['data'][$k]);
            }
            
            // $shop = Db::name('shop')->where(['id'=>$shop_id])->value('name');
            // $data[$k]['shop_name'] = $shop;
        }

        $this->success(__('successful'), $data);
    }


    /**
     * 首页统计接口
     * @ApiMethod (POST)
     * @ApiParams (name="finder_user_id", type="integer", required=true, description="用户id")
     * @ApiParams (name="shop_id", type="integer", required=false, description="店铺id")
     * @ApiParams (name="start_time", type="string", required=false, description="开始时间")
     * @ApiParams (name="end_time", type="string", required=false, description="结束时间")
     */
    public function Statistics()
    {
        
        $finder_user_id = $this->request->post('finder_user_id','4');
        $start_time = $this->request->post('start_time','');
        $end_time = $this->request->post('end_time','');
        $shop_id = $this->request->post('shop_id',0);

        if(empty($finder_user_id)){
            $this->error(__('Invalid parameters'));
        }
        
        $last_time = strtotime('-14 days');
        $week_time = strtotime('-7 days');
        $now_time = strtotime('now');
        if(!empty($start_time) && !empty($end_time)){
            $tmp = strtotime($end_time)-strtotime($start_time);
            $last_time = strtotime($start_time)-$tmp;
            $week_time = strtotime($start_time);
            $now_time = strtotime($end_time);
        }
        $where = [
            'finder_user_id'=>$finder_user_id,
            'create_time' => ['between',[$last_time,$week_time]]
        ];
        $where1 = [
            'finder_user_id'=>$finder_user_id,
            'create_time' => ['between',[$week_time,$now_time]]
        ];

        if(!empty($shop_id)){
            $where['shop_id'] = $shop_id;
            $where1['shop_id'] = $shop_id;
        }

        $last_orders = Db::name('order_item')->where($where)
                  ->field('count(1) as total,DATE_FORMAT(FROM_UNIXTIME(create_time),"%Y-%m-%d") as dt,sum(price) as total_price,sum(cost) as total_cost,sum(profit) as total_profit')
                  ->group('dt')->select();
        $orders = Db::name('order_item')->where($where1)
                  ->field('count(1) as total,DATE_FORMAT(FROM_UNIXTIME(create_time),"%Y-%m-%d") as dt,sum(price) as total_price,sum(cost) as total_cost,sum(profit) as total_profit')
                  ->group('dt')->select();
        $orderPriceData=[];
        $orderCostData=[];
        $orderProfitData=[];
		$senveDateTime=[];
		foreach ($orders as $order){
			$orderPriceData[] = $order['total_price'];
			$orderCostData[] = $order['total_cost'];
			$orderProfitData[] = $order['total_profit'];
			$senveDateTime[] = $order['dt'];
		}
        // $this->success(__('successful'), $orders);
        $all_order_count = Db::name('order')->count();
        $notification_count = Db::name('notification')->where(['readtime'=>null])->count();

        $last_order_count = Db::name('order_item')->where($where)->count();
        $last_order_statistics = Db::name('order_item')->where($where)->field(Db::raw('sum(price) as total_sales,sum(cost) as total_cost,sum(profit) as total_profit'))->find();
        $order_count = Db::name('order_item')->where($where1)->count();
        $order_statistics = Db::name('order_item')->where($where1)->field(Db::raw('sum(price) as total_sales,sum(cost) as total_cost,sum(profit) as total_profit'))->find();


        $top_item = Db::name('order_item')->alias('i')
                    ->join('product_variants v','i.product_variant_id = v.id','left')
                    ->join('product_images m','m.product_id = v.product_id','left')
                    ->field(Db::raw('i.name,count(1) as total,sum(i.price) as total_sales,m.src'))
                    ->order('total desc')->group('i.sku')->find();
        $str="/^http(s?):\/\/(?:[A-za-z0-9-]+\.)+[A-za-z]{2,4}(?:[\/\?#][\/=\?%\-&~`@[\]\':+!\.#\w]*)?$/";
        if (!preg_match($str,$top_item['src'])){
            $top_item['src'] = 'https://interface.ddtechinfo.com/'.$top_item['src'];
        }

        $data = [
            'order_count'  =>  $all_order_count,
            'shipment_count'  =>  0,
            'notification_count'  =>  $notification_count,
            'total_sales'  =>  $order_statistics['total_sales'],
            'total_orders'  =>  $order_count,
            'total_cost'  =>  $order_statistics['total_cost'],
            'total_profit'  =>  $order_statistics['total_profit'],
            'total_sales_percent'  =>  $last_order_statistics['total_sales'] == 0 ? 100 : round($order_statistics['total_sales'] / $last_order_statistics['total_sales'] * 100, 2),
            'total_orders_percent'  =>  $last_order_count == 0 ? 100 : round($order_count / $last_order_count * 100, 2),
            'total_cost_percent'  =>  $last_order_statistics['total_cost'] == 0 ? 100 : round($order_statistics['total_cost'] / $last_order_statistics['total_cost'] * 100, 2),
            'total_profit_percent'  =>  $last_order_statistics['total_profit'] == 0 ? 100 : round($order_statistics['total_profit'] / $last_order_statistics['total_profit'] * 100, 2),
            'orderPriceData'  =>   $orderPriceData,
            'orderCostData'  =>   $orderCostData,
            'orderProfitData'  =>   $orderProfitData,
            'senveDateTime'  =>   $senveDateTime,
            'top_item'  =>   $top_item,
        ];
        

        $this->success(__('successful'), $data);
    }

}