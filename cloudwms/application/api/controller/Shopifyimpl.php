<?php

namespace app\api\controller;

use app\common\controller\Api;

use Shopify\Utils;
use Shopify\Context;
use Shopify\Auth\OAuth;
use Shopify\Auth\Session;
use Shopify\Clients\Rest;
use Shopify\Auth\FileSessionStorage;

use think\Db;
use app\common\library\Finderauth;

class Shopifyimpl extends Api
{
    protected $noNeedLogin = ['*'];
    protected $noNeedRight = ['*'];

    /**
     * 首页
     *
     */
    // $shopifyConfig=["API_key"=>
    //     ];
    // protected $shopifyConfig;
    // $shopifyConfig['API_key']="3c6bac23c028babb12de1ca007c0f742";
    // $shopifyConfig['API_secret_key']="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";
    // $shopifyConfig['scopes']="write_orders,read_orders,read_customers,write_products,read_products,write_product_listings";
    
    
    protected $apiKey="3c6bac23c028babb12de1ca007c0f742";
    protected $apiSecretKey="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";
    protected $scopes="write_orders,read_orders,read_customers,write_products,read_products,read_product_listings,write_inventory";
    protected $hostName="interface.ddtechinfo.com";
    
    
    // protected $shipifyAuthUrl="https://{shop}.myshopify.com/admin/oauth/authorize?client_id={api_key}&scope={scopes}&redirect_uri={redirect_uri}&state={nonce}&grant_options[]={access_mode}";
    // protected $productUrl="http://120.24.234.102/index/user/index.html";

    // private $authUrl="http://120.24.234.102/api/Shopifyimpl/login";

    
    private $webHookUrl="https://shopify.ddtechinfo.com/api/webhook/orders";
    private $listProductUrl="https://shopify.ddtechinfo.com/api/Shopifyimpl/list";

    private $oauthSessionId = 'ddinfotech_oauth_session';
    
    
    private $appurl="https://shopify.ddtechinfo.com/index/home";


    public function _initialize()
    {
       session_start();
       Context::initialize($this->apiKey,$this->apiSecretKey,$this->scopes,$this->hostName,new FileSessionStorage());
    }
     
    public function login(){
       
        $shop=$this->request->get("shop");
        $callbackUrl="/api/Shopifyimpl/callback";
      //  echo "shop:".$shop."<br>callbackUrl:".$this->callbackUrl;
       // return;
        $url=OAuth::begin($shop,$callbackUrl,false);
        header("Content-Security-Policy: frame-ancestors 'none';");
        header("location:".$url);
    }


    public function callback(){

        $shop=$this->request->get("shop");
        $code=$this->request->get("code");
        $hmac=$this->request->get("hmac");
        $state=$this->request->get("state");
        $timestamp=$this->request->get("timestamp");
        
        $this->createSession(false,$shop,$state);

        $mockCookies = [OAuth::SESSION_ID_COOKIE_NAME => $shop,'shop' => $shop,
        'state' => $state,
        'code' => $code,
        'hmac' => $hmac];

        $mockQuery =$this->request->param();

        // $mockQuery = [
        //     'code' => $code,
        //     'shop' => $shop,
        //     'state' => $state,
        //     'hmac' => $hmac,
        //     'timestamp' => $timestamp,
        // ];

        

        $result=OAuth::callback($mockCookies, $mockQuery);
        // var_dump($result);die;
        // $response = \Shopify\Webhooks\Registry::register(
        //   $this->webHookUrl,
        //   \Shopify\Webhooks\Topics::ORDERS_CREATE,
        //   $result->getShop(),
        //   $result->getAccessToken(),
        // );

        // if ($response->isSuccess()) {
          header("Content-Security-Policy: frame-ancestors 'none';");

          //echo "result:".json_encode($result);
          $finder_token = "";
          if(!empty($shop)){
            $finder_token = $this->getUserToken($shop);
          }
          header("location:".$this->appurl."?token=".$finder_token);
      // }

    }

    public function getUserToken($shop){
      $user_id = Db::name('finder_user')->where(['shop'=>$shop])->value('id');
      // var_dump(Db::name('finder_user')->getLastSql());die;
      if($user_id>0){
        $finderauth = Finderauth::instance();
        $finderauth->direct($user_id);
        $finder_token = $finderauth->getToken();
        return $finder_token;
      }else{
        $finderauth = Finderauth::instance();
        $ret = $finderauth->register($shop, $shop,$shop,'');
        
        if ($ret) {
            $finder_data = $finderauth->getUserinfo();
            //自动创建店铺
              $data = [
                'myshopify_domain'  => $shop,
                'name'  => $shop,
                'type'  => 'shopify',
                'address1'  => 'https://'.$shop,
                'finder_user_id'  => $finder_data['user_id'],
                'create_time'  => time(),
              ];
              Db::name('shop')->insert($data);
              $data_shop = [
                'name'  => '自有商品',
                'type'  => 'self',
                'finder_user_id'  => $finder_data['user_id'],
                'create_time'  => time(),
              ];
              Db::name('shop')->insert($data_shop);
              // var_dump($finder_data);die;
            return $finder_data['token'];
        } else {
            $this->error($finderauth->getError());
        }
      }
      
    }
    public function list(){
       
        $query = [
            "id" =>7099824111798,
        ];
        $session = Context::$SESSION_STORAGE->loadSession('devddinfotech.myshopify.com');
        $client = new Rest($session->getShop(), $session->getAccessToken());
        $response = $client->get('products');
        $res=json_decode($response->getBody());
        //echo "<br>size:".sizeof($res->products);
        //echo "<br>";
       // var_dump($res);
       // var_dump($res->products[0]);
       echo json_encode($res);

    }


    public function orders(){
       
        
        $session = Context::$SESSION_STORAGE->loadSession($this->oauthSessionId);
        $client = new Rest($session->getShop(), $session->getAccessToken());
        $response = $client->get('orders');
        $res=json_decode($response->getBody());
        //echo "<br>size:".sizeof($res->products);
        // echo "<br>";
        echo json_encode($res);
       // var_dump($res->products[0]);
       // echo "product:".json_encode($res->products[1]);

    }


    public function ordersQuery(){
       
      $getData=["created_at"=>"2021-11-19T11:44:57+08:00"];
      $session = Context::$SESSION_STORAGE->loadSession($this->oauthSessionId);
      $client = new Rest($session->getShop(), $session->getAccessToken());
      $response = $client->get('orders',[] ,["fields"=>"financial_status,created_at",
       // "created_at_min" => "2021-11-19T11:44:57+08:00",
        // "financial_status"=>"pending",
        "created_at_min"=>"2021-11-18T11:44:57+08:00"
      ]);
      // $response = $client->get('orders',[
      //   // "created_at_min" => "2021-11-19T11:44:57+08:00",
      //    "financial_status"=>"pending"
      //  ]);
      $res=json_decode($response->getBody());
      //echo "<br>size:".sizeof($res->products);
      // echo "<br>";
      echo json_encode($res);
     // var_dump($res->products[0]);
     // echo "product:".json_encode($res->products[1]);

  }

    public function update(){
       
        $postData = [
            "product" => [
                "title" => "New product title--fortest",
                'body_html'=> '<strong>Test Body!</strong>',

              ]
        ];
        $session = Context::$SESSION_STORAGE->loadSession($this->oauthSessionId);
        $client = new Rest($session->getShop(), $session->getAccessToken());
        $response = $client->put('products/7055441494198',$postData);
        $res=json_decode($response->getBody());
        //echo "<br>size:".sizeof($res->products);
        echo "<br>";
        var_dump($res);
       // var_dump($res->products[0]);
       // echo "product:".json_encode($res->products[1]);

    }

    public function delete(){
       
       
        $session = Context::$SESSION_STORAGE->loadSession($this->oauthSessionId);
        $client = new Rest($session->getShop(), $session->getAccessToken());
        $response = $client->delete('products/7055441297590');
        $res=json_decode($response->getBody());
        //echo "<br>size:".sizeof($res->products);
        echo "<br>";
        var_dump($res);
       // var_dump($res->products[0]);
       // echo "product:".json_encode($res->products[1]);

    }

    public function addimg(){
       
        $postData = 	[
            "image" => [
        
              // "attachment" =>$this->base64EncodeImage("/www/wwwroot/pf/public/uploads/20211025/d22d34b9c8ac3a01ffe89ef5776212ce.jpg"),
              // "filename" => "rails_logo1.gif"
              "src" => "https://gimg2.baidu.com/image_search/src=http%3A%2F%2Ffile02.16sucai.com%2Fd%2Ffile%2F2014%2F0829%2F372edfeb74c3119b666237bd4af92be5.jpg&refer=http%3A%2F%2Ffile02.16sucai.com&app=2002&size=f9999,10000&q=a80&n=0&g=0n&fmt=jpeg?sec=1637738001&t=4d45c70aae9538e5d68ee172fc0dbb1e"
            ]
            ];
            // var_dump($this->base64EncodeImage("/www/wwwroot/pf/public/uploads/20211025/d22d34b9c8ac3a01ffe89ef5776212ce.jpg"));
        $session = Context::$SESSION_STORAGE->loadSession($this->oauthSessionId);
        $client = new Rest($session->getShop(), $session->getAccessToken());
        $response = $client->post('products/7126333096118/images',$postData);
        $res=json_decode($response->getBody());
        //echo "<br>size:".sizeof($res->products);
        echo "<br>";
        var_dump($res);
       // var_dump($res->products[0]);
       // echo "product:".json_encode($res->products[1]);

    }


    public function addProd(){

        // $productObj=[
        //     'product'=> [
        //       'id'=> 1071559582,
        //       'title'=> 'Burton Custom Freestyle 151',
        //       'body_html'=> '<strong>Good snowboard!</strong>',
        //       'vendor'=> 'Burton',
        //       'product_type'=> 'Snowboard',
        //       'created_at'=> '2021-10-01T16=>43=>16-04=>00',
        //       'handle'=> 'burton-custom-freestyle-151',
        //       'updated_at'=> '2021-10-01T16=>43=>16-04=>00',
        //       'published_at'=> '2021-10-01T16=>43=>16-04=>00',
        //       'template_suffix'=> null,
        //       'status'=> 'active',
        //       'published_scope'=> 'web',
        //       'tags'=> "Barnes & Noble, Big Air, John's Fav",
        //       'admin_graphql_api_id'=> 'gid=>//shopify/Product/1071559582',
        //       'variants'=> [
        //         [
        //           'id'=> 1070325028,
        //           'product_id'=> 1071559582,
        //           'title'=> 'Default Title',
        //           'price'=> '0.00',
        //           'sku'=> '',
        //           'position'=> 1,
        //           'inventory_policy'=> 'deny',
        //           'compare_at_price'=> null,
        //           'fulfillment_service'=> 'manual',
        //           'inventory_management'=> null,
        //           'option1'=> 'Default Title',
        //           'option2'=> null,
        //           'option3'=> null,
        //           'created_at'=> '2021-10-01T16=>43=>16-04=>00',
        //           'updated_at'=> '2021-10-01T16=>43=>16-04=>00',
        //           'taxable'=> true,
        //           'barcode'=> null,
        //           'grams'=> 0,
        //           'image_id'=> null,
        //           'weight'=> 0,
        //           'weight_unit'=> 'lb',
        //           'inventory_item_id'=> 1070325028,
        //           'inventory_quantity'=> 0,
        //           'old_inventory_quantity'=> 0,
        //           'presentment_prices'=> [
        //             [
        //               'price'=> [
        //                 'amount'=> '0.00',
        //                 'currency_code'=> 'USD'
        //               ],
        //               'compare_at_price'=> null
        //             ]
        //           ],
        //           'requires_shipping'=> true,
        //           'admin_graphql_api_id'=> 'gid=>//shopify/ProductVariant/1070325028'
        //         ]
        //       ],
        //       'options'=> [
        //         [
        //           'id'=> 1055547193,
        //           'product_id'=> 1071559582,
        //           'name'=> 'Title',
        //           'position'=> 1,
        //           'values'=> [
        //             'Default Title'
        //           ]
        //         ]
        //       ],
        //       'images'=> [],
        //       'image'=> null
        //     ]
        // ];

        // $productObj = [
        //   "product" => [
        //     "title" => "Burton Custom Freestyle 1511",
        //     "body_html" => "<strong>Good snowboard!</strong>",
        //     "vendor" => "Burton",
        //     "product_type" => "Snowboard",
        //     "sku" => 'asdasdad',
        //     "cost" => 25,
        //     "compare_at_price" => 35,
        //     "barcode" => '2342342',
        //     'weight'=>26,
        //     'weight_unit'=>'g',
        //     'inventory_quantity'=>60,
        //     "price" =>30
        //     // "variants" => [
        //     //   ["option1"=>"First",
        //     //    "price"=>"10.00", 
        //     //    "sku"=>"123",
        //     //     "img_id"=>"123"]]
        //   ]
        //   ];
         
        //  $session = Context::$SESSION_STORAGE->loadSession($this->oauthSessionId);
        //  $client = new Rest($session->getShop(), $session->getAccessToken());
        //  $response = $client->post('products',$productObj);
        //  $res=json_decode($response->getBody());
        // var_dump($res);
        //  $variants_data= [
        //   "variant" => [
        //     "id" => 41060680695990,
        //     "sku" => 'asdasd',
        //     // "cost" => $info['cost'],
        //     // "compare_at_price" => $info['compare_at_price'],
        //     // "barcode" => $info['barcode'],
        //     // 'weight'=>$info['weight'],
        //     // 'weight_unit'=>$info['weight_unit'],
        //     // 'inventory_quantity'=>$info['inventory_quantity'],
        //     "price" => 56
        //   ]
        // ];
        //  $session = Context::$SESSION_STORAGE->loadSession($this->oauthSessionId);
        //  $client = new Rest($session->getShop(), $session->getAccessToken());
        //  $response = $client->put('variants/41060680695990',$variants_data);
        //  $res_var=json_decode($response->getBody());
        //  var_dump($res_var);


         $session = Context::$SESSION_STORAGE->loadSession('devddinfotech.myshopify.com');
         $client = new Rest($session->getShop(), $session->getAccessToken());
         $response = $client->get(
          "locations"
        );
         $res_var=json_decode($response->getBody());
         var_dump($res_var);
         
    }


    public function getproduct(){
       
      $session = Context::$SESSION_STORAGE->loadSession($this->oauthSessionId);
      $client = new Rest($session->getShop(), $session->getAccessToken());
      $response = $client->get('products/7099824111798');
      $res=json_decode($response->getBody());
      //echo "<br>size:".sizeof($res->products);
      echo "<br>";
      var_dump($res);
     // var_dump($res->products[0]);
     // echo "product:".json_encode($res->products[1]);

  }


    // public function index()
    // {
        
    //    $config["shop"]=$this->request->get("shop");
    //    $config["api_key"]=$this->shopifyConfig1;
    //    $config["scopes"]=$this->shopifyConfig3;
    //    $config["redirect_uri"]=$this->authUrl;
    //    $config["nonce"]=$this->create_uuid();
    //    $config["access_mode"]="online";
       
    //   header("Location: ".$this-> contactAuthUrl($config));
       
    // }

    // public function auth()
    // {
        
    //    $authInfo["code"]=$this->request->get("code");
    //    $authInfo["hmac"]=$this->request->get("hmac");
    //    $authInfo["host"]=$this->request->get("host");
    //    $authInfo["timestamp"]=$this->request->get("timestamp");
    //    $authInfo["state"]=$this->request->get("state");
    //    $authInfo["shop"]=$this->request->get("shop");
    //    $authInfo["host"]=$this->request->get("host");

    //   echo "authInfo:".json_encode($authInfo);
       
    // }

    
    
    // function contactAuthUrl($config){
    //     $shipifyAuthUrl="https://".$config["shop"];
    //     $shipifyAuthUrl=$shipifyAuthUrl."/admin/oauth/authorize?client_id=".$config["api_key"];
    //     $shipifyAuthUrl=$shipifyAuthUrl."&scope=".$config["scopes"];
    //     $shipifyAuthUrl=$shipifyAuthUrl."&redirect_uri=".$config["redirect_uri"];
    //     $shipifyAuthUrl=$shipifyAuthUrl."&state=".$config["nonce"];
    //     $shipifyAuthUrl=$shipifyAuthUrl."&grant_options[]=".$config["access_mode"];
    //     return $shipifyAuthUrl;
    // }
    
    // function create_uuid($prefix=""){
    //     $chars = md5(uniqid(mt_rand(), true));
    //     $uuid = substr ( $chars, 0, 8 ) . '-'
    //         . substr ( $chars, 8, 4 ) . '-'
    //         . substr ( $chars, 12, 4 ) . '-'
    //         . substr ( $chars, 16, 4 ) . '-'
    //         . substr ( $chars, 20, 12 );
    //     return $prefix.$uuid ;
    // }

    private function createSession(bool $isOnline,$shop,$status): Session
    {
        $session = new Session($shop, $shop, $isOnline, $status);
        Context::$SESSION_STORAGE->storeSession($session);

        return $session;
    }
    
    public function ordersWebHooks(){
       
      $postData = 	[
          "webhook" => [
            "topic" => "orders/create",
            "address" => "https://interface.ddtechinfo.com/api/shopifyimpl/writeorder",
            "format" => "json",
            "fields" => ["id", "note"]
          ]
        ];  
      $session = Context::$SESSION_STORAGE->loadSession($this->oauthSessionId);
      $client = new Rest($session->getShop(), $session->getAccessToken());
      // $response = $client->post("webhooks",$postData);
      $response = $client->get("webhooks");
      // $response = $client->delete("webhooks/1073489707190");
      $res=json_decode($response->getBody());
      //echo "<br>size:".sizeof($res->products);
      // echo "<br>";
      echo json_encode($res);
     // var_dump($res->products[0]);
     // echo "product:".json_encode($res->products[1]);

  }


  public function listWebHooks(){
       
    $postData = 	[
        "webhook" => [
          "topic" => "orders/create",
          "address" => "https://interface.ddtechinfo.com/api/shopifyimpl/writeorder",
          "format" => "json",
          "fields" => ["id", "note"]
        ]
      ];  
    $session = Context::$SESSION_STORAGE->loadSession($this->oauthSessionId);
    $client = new Rest($session->getShop(), $session->getAccessToken());
    // $response = $client->post("webhooks",$postData);
    $response = $client->get("webhooks");
    // $response = $client->delete("webhooks/1073489707190");
    $res=json_decode($response->getBody());
    //echo "<br>size:".sizeof($res->products);
    // echo "<br>";
    echo json_encode($res);
   // var_dump($res->products[0]);
   // echo "product:".json_encode($res->products[1]);

}

public function createHooks(){
       
  $postData = 	[
      "webhook" => [
        "topic" => "orders/create",
        "address" => "http://120.24.234.102/api/shopifyimpl/writeorder",
        "format" => "json",
        "fields" => ["id", "note"]
      ]
    ];  
  $session = Context::$SESSION_STORAGE->loadSession($this->oauthSessionId);
  $client = new Rest($session->getShop(), $session->getAccessToken());
  // $response = $client->post("webhooks",$postData);
  $response = $client->post("webhooks",$postData);
  // $response = $client->delete("webhooks/1073489707190");
  $res=json_decode($response->getBody());
  //echo "<br>size:".sizeof($res->products);
  // echo "<br>";
  echo json_encode($res);
 // var_dump($res->products[0]);
 // echo "product:".json_encode($res->products[1]);

}
  
  
   public function deleteHooks(){

    $hookId=$this->request->get("hookId");
      $session = Context::$SESSION_STORAGE->loadSession($this->oauthSessionId);
      $client = new Rest($session->getShop(), $session->getAccessToken());
       $response = $client->delete("webhooks/".$hookId);
    //   $response = $client->get("webhooks");
      // $response = $client->delete("webhooks/1073489707190");
      $res=json_decode($response->getBody());
      //echo "<br>size:".sizeof($res->products);
      // echo "<br>";
      echo json_encode($res);
     // var_dump($res->products[0]);
     // echo "product:".json_encode($res->products[1]);

  }

  public function writeorder(){
   
   // echo "11110";
    // $data = $this->request->();
    $data = file_get_contents("php://input");
    if(empty($data)){
      echo "0";
      file_put_contents("/tmp/writeOrder.txt",date('Y-m-d H:i:s')."empty\n",FILE_APPEND);
    }else{
      echo "1";
      file_put_contents("/tmp/writeOrder.txt",date('Y-m-d H:i:s')."order:".json_encode($data)."\n",FILE_APPEND);
    }
  }
  
   public function ordercall(){
    $data = $this->request->post();
    if(empty($data)){
      echo "0";
      file_put_contents("/tmp/writeOrder.txt","empty\n",FILE_APPEND);
    }else{
      echo "1";
      file_put_contents("/tmp/writeOrder.txt","order:".json_encode($data)."\n",FILE_APPEND);
    }
  }
  
}
