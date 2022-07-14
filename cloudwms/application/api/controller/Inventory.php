<?php

namespace app\api\controller;

use app\common\controller\FinderApi;
use think\Db;


/**
 * 库存接口
 */
class Inventory extends FinderApi
{

    protected $noNeedLogin = [];
    protected $noNeedRight = ['*'];
    /**
     * 库存日志列表
     * @ApiMethod (POST)
     * @ApiParams (name="finder_user_id", type="integer", required=true, description="用户id")
     * @ApiParams (name="shop_id", type="integer", required=true, description="店铺id")
     * @ApiParams (name="sku", type="string", required=false, description="sku")
     * @ApiParams (name="start_time", type="integer", required=false, description="查询开始日期")
     * @ApiParams (name="end_time", type="integer", required=false, description="查询结算日期")
     * @ApiParams (name="page_num", type="integer", required=false, description="第几页")
     * @ApiParams (name="per_page_num", type="integer", required=false, description="每页数量")
     */
    public function inventoryLogList()
    {
        $finder_user_id = $this->request->post('finder_user_id','0');
        $shop_id = $this->request->post('shop_id','0');
        $sku = $this->request->post('sku','');
        $start_time = $this->request->post('start_time','');
        $end_time = $this->request->post('end_time','');
        $page_num = $this->request->post('page_num',1);
        $per_page_num = $this->request->post('per_page_num',10);

        $shop_type = Db::name('shop')->where(['id'=>$shop_id])->value('type');
        if($shop_type=='self'){
          $product_query = Db::name('product');
          $product_str = 'product';
          $variant_str = 'product_variants';
          $prdid = 'product_id';
        }else{
          $product_query = Db::name('product_import');
          $product_str = 'product_import';
          $variant_str = 'product_import_variants';
          $prdid = 'import_id';
        }

        $wherep = ['p.finder_user_id'=>$finder_user_id,'p.shop_id'=>$shop_id];
        if(!empty($sku)){
          $wherep['v.sku'] = ['like','%'.$sku.'%'];
        }
        $variant_ids = $product_query->alias('p')
                      ->join($variant_str.' v','p.id = v.'.$prdid)
                      ->where($wherep)
                      ->column('v.id');
        if(!$variant_ids){
            $this->error(__('Empty product'));
        }

        $ids = implode(',', $variant_ids);
        $wherel = ['l.product_variant_id'=>['in',$ids]];
        $wherel['l.shop_id'] = $shop_id;
        if(!empty($start_time) && !empty($end_time)){
          $wherel['l.create_time'] = ['between',[strtotime($start_time),strtotime($end_time)]];
        }
        $data=Db::name('inventory_log')->alias('l')
            ->join($variant_str.' v','v.id = l.product_variant_id')
            ->join($product_str.' p','v.'.$prdid.'  = p.id')
            ->where($wherel)
            ->field('l.*,v.sku,p.title')
            ->order('l.id desc')
            ->paginate($per_page_num,false,['page'=>$page_num]);
        $data = [
              'total'     => $data->total(),         // 总记录数
              'cur'       => $data->currentPage(),   // 当前页码
              'size'      => $data->listRows(),      // 每页记录数
              'data'      => $data->items()          // 分页数据
        ];
        // var_dump(Db::name('inventory_log')->getLastSql());die;
        // if(!$data){
        //     $this->error(__('Empty Log'));
        // }

        $this->success(__('successful'), $data);
    }


    /**
     * 出入库接口
     * @ApiMethod (POST)
     * @ApiParams (name="product_variant_id", type="integer", required=true, description="sku_id")
     * @ApiParams (name="in_quantity", type="string", required=false, description="入库数量")
     * @ApiParams (name="out_quantity", type="integer", required=false, description="出库数量")
     * @ApiParams (name="memo", type="integer", required=false, description="备注")
     */
    public function operateInventoryLog()
    {
        $product_variant_id = $this->request->post('product_variant_id',0);
        $in_quantity = $this->request->post('in_quantity',0);
        $out_quantity = $this->request->post('out_quantity',0);
        $memo = $this->request->post('memo','');

        if($product_variant_id==0){
          $this->error(__('Invalid parameters'));
        }
        $inventory_quantity = Db::name('product_variants')
                      ->where(['id'=>$product_variant_id])
                      ->value('inventory_quantity');
        if($in_quantity!=0){
          $data = [
            'product_variant_id'  => $product_variant_id,
            'in_quantity'  => $in_quantity,
            'memo'  => $memo,
            'stock'  => $inventory_quantity + $in_quantity,
            'type'  => 'in_quantity',
            'create_time'  => time()
          ];
          $res = Db::name('inventory_log')->insert($data);
          if(!$res){
            $this->error(__('in_quantity false'));
          }
        }

        if($out_quantity!=0){
          if($inventory_quantity<$out_quantity){
            $this->error(__('no enought stock'));
          }
          $data = [
            'product_variant_id'  => $product_variant_id,
            'out_quantity'  => $out_quantity,
            'memo'  => $memo,
            'stock'  => $inventory_quantity - $out_quantity,
            'type'  => 'out_quantity',
            'create_time'  => time()
          ];
          $res = Db::name('inventory_log')->insert($data);
          if(!$res){
            $this->error(__('out_quantity false'));
          }
        }

        

        $this->success(__('successful'), $data);
    }

    /**
     * 供应商列表接口
     * @ApiMethod (POST)
     */
    public function getSupplierList(){

      $list = Db::name('supplier')->where('supplier_status = 1')->select();
            
      $this->success(__('successful'),$list);
    }


    
    /**
     * 国家列表接口
     * @ApiMethod (POST)
     */
    public function getCountryList(){

      $list = Db::name('country')->order('id asc')->select();
            
      $this->success(__('successful'),$list);
    }
}