<?php
namespace app\api\controller;

use app\common\controller\FinderApi;
use think\Db;

use app\common\controller\Amazon;

class Amazonopration extends FinderApi
{
    protected $noNeedLogin = ['*'];
    protected $noNeedRight = ['*'];



    /**
     * 商品操作接口
     * @ApiMethod (POST)
     * @ApiParams (name="title", type="string", required=true, description="标题")
     * @ApiParams (name="description", type="string", required=false, description="产品介绍")
     * @ApiParams (name="out_link", type="string", required=false, description="外链")
     * @ApiParams (name="sku", type="string", required=false, description="sku")
     * @ApiParams (name="sale_price", type="integer", required=true, description="优惠价")
     * @ApiParams (name="compare_at_price", type="integer", required=true, description="原价")
     * @ApiParams (name="market_price", type="integer", required=true, description="市场价")
     * @ApiParams (name="barcode", type="string", required=false, description="条码")
     * @ApiParams (name="barcode_type", type="string", required=false, description="条码类型")
     * @ApiParams (name="quantity", type="integer", required=false, description="数量")
     * @ApiParams (name="image_urls", type="string", required=false, description="图片地址，多个以,隔开")
     * @ApiParams (name="product_status", type="integer", required=false, description="状态:0=active销售中,1=archived已下架,2=draft未上架	")
     * @ApiParams (name="tag_ids", type="string", required=false, description="标签ids，多个以,隔开")
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
     */
    public function operateFeed(){
        $post_data = $this->request->instance()->post(false);
        // var_dump($post_data);die;
  
        if(empty($post_data['title'])||empty($post_data['sale_price'])||empty($post_data['compare_at_price'])||empty($post_data['market_price'])){
          $this->error(__('Invalid parameters').'1');
        }

        $v=\think\View::instance();
          $file=$v->fetch($_SERVER['DOCUMENT_ROOT']."/template/amazon/product.xml",["product"=>$post_data]);
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
          $result = $amazon->uploadproduct($file,'POST_PRODUCT_DATA',$post_data['sku']);
          if(!$result){
              $this->error(__('import fail plaese try again'),$result);
          }

          if(!empty($image_urls)){
            $img_arr = explode(',',$image_urls);
            foreach($img_arr as $k => $img){
              
              if($k==0){
                $type = 'MAIN';
              }else{
                $type = 'PT'.$k;
              }
              //使用redis
                $redis = new \Redis;
                $redis->connect('127.0.0.1',6379);
                $redis->lPush('wait_uploadimg_queue',json_encode(['sku'=>$post_data['sku'],'type'=>$type,'location'=>cdnurl($img)]));
            }
            
          }
    
          $this->success(__('successful'));
        
        
      }

     /**
     * 获取商品上架状态接口
     * @ApiMethod (POST)
     * @ApiReturnParams   (name="feedDocumentId", type="string", required=true, description="0")
     * @ApiReturnParams   (name="feed_id", type="string", required=true, description="0")
     * @ApiReturnParams   (name="result_feedDocumentId", type="string", required=true, description="0")
     * @ApiReturnParams   (name="feed_type", type="string", required=true, description="类型")
     * @ApiReturnParams   (name="sku", type="string", required=true, description="0")
     * @ApiReturnParams   (name="feedDocumentReturn", type="string", required=true, description="0")
     * @ApiReturnParams   (name="status", type="string", required=true, description="状态:0=未处理,1=已完成")
     * @ApiReturnParams   (name="create_time", type="string", required=true, description="创建时间")
     * @ApiReturnParams   (name="update_time", type="string", required=true, description="更新时间")
     */
      public function getFeedLog(){
        $list = Db::name('amazon_feed_log')->order('id desc')->select();
        $this->success(__('successful'),$list);
      }



      /**
       * 创建InboundShipmentPlan接口
       * @ApiMethod (POST)
       * @ApiParams (name="Name", type="string", required=true, description="货件名称")
       * @ApiParams (name="AddressLine1", type="string", required=true, description="发货地址1")
       * @ApiParams (name="AddressLine2", type="string", required=false, description="发货地址2")
       * @ApiParams (name="DistrictOrCounty", type="string", required=false, description="地区或国家")
       * @ApiParams (name="City", type="string", required=true, description="城市")
       * @ApiParams (name="StateOrProvinceCode", type="string", required=true, description="州或省编码")
       * @ApiParams (name="CountryCode", type="string", required=true, description="国家编码")
       * @ApiParams (name="PostalCode", type="string", required=true, description="邮政编码")
       * @ApiParams (name="LabelPrepPreference", type="string", required=true, description="标签偏好固定值：SELLER_LABEL，AMAZON_LABEL_ONLY，AMAZON_LABEL_PREFERRED")
       * @ApiParams (name="ShipToCountryCode", type="string", required=true, description="收货国家编码")
       * @ApiParams (name="ShipToCountrySubdivisionCode", type="string", required=false, description="标题")
       * @ApiParams (name="SellerSKU", type="string", required=true, description="卖家sku")
       * @ApiParams (name="ASIN", type="string", required=true, description="识别号")
       * @ApiParams (name="Condition", type="string", required=true, description="条件，固定值")
       * @ApiParams (name="Quantity", type="integer", required=true, description="数量")
       * @ApiParams (name="QuantityInCase", type="string", required=false, description="每箱数量")
       */
    public function CreateInboundShipmentPlan(){
        $post_data = $this->request->instance()->post(false);

        if(!isset($post_data['Name']) || !isset($post_data['AddressLine1']) || !isset($post_data['City']) || !isset($post_data['StateOrProvinceCode'])){
            $this->error(__('requied parameters is missing'));
        }

        if(!isset($post_data['CountryCode']) || !isset($post_data['PostalCode']) || !isset($post_data['LabelPrepPreference']) || !isset($post_data['ShipToCountryCode'])){
            $this->error(__('requied parameters is missing'));
        }
        
        if(!isset($post_data['SellerSKU']) || !isset($post_data['ASIN']) || !isset($post_data['Condition']) || !isset($post_data['Quantity'])){
            $this->error(__('requied parameters is missing'));
        }

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
          $result = $amazon->CreateInboundShipmentPlan($post_data);
          if(!$result){
            $this->error(__('import fail plaese try again'),$result);
          }

        $this->success(__('successful'),$result);
    }



    /**
     * 创建InboundShipment接口
       * @ApiMethod (POST)
       * @ApiParams (name="ShipmentName", type="string", required=true, description="货件名称")
       * @ApiParams (name="Name", type="string", required=true, description="商家名称")
       * @ApiParams (name="AddressLine1", type="string", required=true, description="发货地址1")
       * @ApiParams (name="AddressLine2", type="string", required=false, description="发货地址2")
       * @ApiParams (name="DistrictOrCounty", type="string", required=false, description="地区或国家")
       * @ApiParams (name="City", type="string", required=true, description="城市")
       * @ApiParams (name="StateOrProvinceCode", type="string", required=true, description="州或省编码")
       * @ApiParams (name="CountryCode", type="string", required=true, description="国家编码")
       * @ApiParams (name="PostalCode", type="string", required=true, description="邮政编码")
       * @ApiParams (name="LabelPrepPreference", type="string", required=true, description="标签偏好固定值：SELLER_LABEL，AMAZON_LABEL_ONLY，AMAZON_LABEL_PREFERRED")
       * @ApiParams (name="DestinationFulfillmentCenterId", type="string", required=true, description="仓库标识,CreateInboundShipmentPlan返回")
       * @ApiParams (name="AreCasesRequired", type="string", required=false, description="是否箱子包装 true or false")
       * @ApiParams (name="ShipmentStatus", type="string", required=true, description="货件状态 固定值")
       * @ApiParams (name="IntendedBoxContentsSource", type="string", required=false, description="提供箱子信息方式：NONE,FEED,2D_BARCODE")
       * @ApiParams (name="SellerSKU", type="string", required=true, description="卖家sku")
       * @ApiParams (name="FulfillmentNetworkSKU", type="string", required=false, description="CreateInboundShipmentPlan返回")
       * @ApiParams (name="QuantityShipped", type="integer", required=true, description="发货数量")
       * @ApiParams (name="MarketplaceId", type="integer", required=true, description="市场ID")
       * @ApiParams (name="ShipmentId", type="integer", required=true, description="货件ID,CreateInboundShipmentPlan返回")
     *
     */
    public function CreateInboundShipment(){
        $post_data = $this->request->instance()->post(false);

        if(!isset($post_data['Name']) || !isset($post_data['AddressLine1']) || !isset($post_data['City']) || !isset($post_data['StateOrProvinceCode'])){
            $this->error(__('requied parameters is missing'));
        }

        if(!isset($post_data['CountryCode']) || !isset($post_data['PostalCode']) || !isset($post_data['LabelPrepPreference'])){
            $this->error(__('requied parameters is missing'));
        }
        
        if(!isset($post_data['SellerSKU']) || !isset($post_data['ShipmentName']) || !isset($post_data['QuantityShipped'])){
            $this->error(__('requied parameters is missing'));
        }

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
          $result = $amazon->CreateInboundShipment($post_data);
          if(!$result){
            $this->error(__('import fail plaese try again'),$result);
          }

        $this->success(__('successful'),$result);
    }


    /**
     * 修改InboundShipment接口
       * @ApiMethod (POST)
       * @ApiParams (name="ShipmentName", type="string", required=true, description="货件名称")
       * @ApiParams (name="Name", type="string", required=true, description="商家名称")
       * @ApiParams (name="AddressLine1", type="string", required=true, description="发货地址1")
       * @ApiParams (name="AddressLine2", type="string", required=false, description="发货地址2")
       * @ApiParams (name="DistrictOrCounty", type="string", required=false, description="地区或国家")
       * @ApiParams (name="City", type="string", required=true, description="城市")
       * @ApiParams (name="StateOrProvinceCode", type="string", required=true, description="州或省编码")
       * @ApiParams (name="CountryCode", type="string", required=true, description="国家编码")
       * @ApiParams (name="PostalCode", type="string", required=true, description="邮政编码")
       * @ApiParams (name="LabelPrepPreference", type="string", required=true, description="标签偏好固定值：SELLER_LABEL，AMAZON_LABEL_ONLY，AMAZON_LABEL_PREFERRED")
       * @ApiParams (name="DestinationFulfillmentCenterId", type="string", required=true, description="仓库标识,CreateInboundShipmentPlan返回")
       * @ApiParams (name="AreCasesRequired", type="string", required=false, description="是否箱子包装 true or false")
       * @ApiParams (name="ShipmentStatus", type="string", required=true, description="货件状态 固定值")
       * @ApiParams (name="IntendedBoxContentsSource", type="string", required=false, description="提供箱子信息方式：NONE,FEED,2D_BARCODE")
       * @ApiParams (name="SellerSKU", type="string", required=true, description="卖家sku")
       * @ApiParams (name="FulfillmentNetworkSKU", type="string", required=false, description="CreateInboundShipmentPlan返回")
       * @ApiParams (name="QuantityShipped", type="integer", required=true, description="发货数量")
       * @ApiParams (name="MarketplaceId", type="integer", required=true, description="市场ID")
       * @ApiParams (name="ShipmentId", type="integer", required=true, description="货件ID,CreateInboundShipmentPlan返回")
     *
     */
    public function UpdateInboundShipment(){
        $post_data = $this->request->instance()->post(false);

        if(!isset($post_data['Name']) || !isset($post_data['AddressLine1']) || !isset($post_data['City']) || !isset($post_data['StateOrProvinceCode'])){
            $this->error(__('requied parameters is missing'));
        }

        if(!isset($post_data['CountryCode']) || !isset($post_data['PostalCode']) || !isset($post_data['LabelPrepPreference'])){
            $this->error(__('requied parameters is missing'));
        }
        
        if(!isset($post_data['SellerSKU']) || !isset($post_data['ShipmentName']) || !isset($post_data['QuantityShipped'])){
            $this->error(__('requied parameters is missing'));
        }

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
          $result = $amazon->UpdateInboundShipment($post_data);
          if(!$result){
            $this->error(__('import fail plaese try again'),$result);
          }

        $this->success(__('successful'),$result);
    }


    /**
     * getLabels接口
       * @ApiMethod (POST)
       * @ApiParams (name="ShipmentId", type="string", required=true, description="货件ID,CreateInboundShipmentPlan返回")
       * @ApiParams (name="PageType", type="string", required=true, description="页面类型，固定值")
       * @ApiParams (name="LabelType", type="string", required=true, description="标签类型：BARCODE_2D，UNIQUE，PALLET")
       * @ApiParams (name="NumberOfPackages", type="integer", required=false, description="包裹数量")
       * @ApiParams (name="NumberOfPallets", type="integer", required=false, description="货物中托盘的数量")
       * @ApiParams (name="PageSize", type="integer", required=false, description="分页的页面大小")
       * @ApiParams (name="PageStartIndex", type="integer", required=false, description="分页的页面起始索引")
     *
     */
    public function getLabels(){
        $post_data = $this->request->instance()->post(false);

        if(!isset($post_data['ShipmentId']) || !isset($post_data['PageType']) || !isset($post_data['LabelType'])){
            $this->error(__('requied parameters is missing'));
        }

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
          $result = $amazon->getLabels($post_data);
          if(!$result){
            $this->error(__('import fail plaese try again'),$result);
          }

        $this->success(__('successful'),$result);
    }
}