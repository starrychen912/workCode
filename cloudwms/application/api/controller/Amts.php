<?php
namespace app\api\controller;

use app\common\controller\Api;
use app\common\controller\Backend;
use think\Env;
use app\api\amazon\XmlUtil;
use app\api\model\amazon\Product;
use think\Template;
use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Request;
use ClouSale\AmazonSellingPartnerAPI\Helpers\ASECryptoStream;

class Amts extends Backend
{
    protected $noNeedLogin = ['*'];
    protected $noNeedRight = ['*'];

    
    protected $options = [];
    protected $config;

    function initData(){
        $this->options = [
            // 'refresh_token' => 'Atzr|IwEBIKMN15u07FKrsjuKMnqi4TaBLGD6oI39HT0Q4PsunwuZAabYY9xfahTOLhAs5p2R2fRbIFSGPRLxRuyqEXfL60GGrCY0eqfqfH9heTtg2mOJBX_c4TJFisGNHYQBdVnk-8RrdY4Ug06Jsy3Mnc7FagcA9uvkJkyhbW2yCCjTPwIFWqhE3RPYvu9FztmUZy2fczOaIlp664JwMi_cAX98-5KohEGsaQggR7tPCggrZa7tYxJmTHSCsu6TpKh8ZrbMWGCdKEhUjTX_SCKe0S39fGnSIzNoBzh-3dz-o76oXSMCWj2wuLez8QZlHdLOPoH2FT8', // Aztr|...
            // 'client_id' => 'amzn1.application-oa2-client.bf1fe56fbe5b49b7bd8e0808d2b46c99', // App ID from Seller Central, amzn1.sellerapps.app.cfbfac4a-......
            // 'client_secret' => 'c2d360af0c3c077eaffe918a6398cba505b2c0ed034ef6185d82d1c0f555e131', // The corresponding Client Secret
            // 'region' => \ClouSale\AmazonSellingPartnerAPI\SellingPartnerRegion::$NORTH_AMERICA, // or NORTH_AMERICA / FAR_EAST
            // // 'access_key' => 'AKIA5I3NTQS62LGLSV4Q', // Access Key of AWS IAM User, for example AKIAABCDJKEHFJDS
            // // 'secret_key' => 'vBtWyqxX2epKG1kmKgaf6naUa4FN0jf8A7ieLBB5', // Secret Key of AWS IAM User
            // 'access_key' => 'AKIA5I3NTQS6XSMORLO6', // Access Key of AWS IAM User, for example AKIAABCDJKEHFJDS
            // 'secret_key' => '5YKGunVruHJRr7rOGb540FBgqb5xX+F09myUIhCs', // Secret Key of AWS IAM User

            // 'endpoint' => \ClouSale\AmazonSellingPartnerAPI\SellingPartnerEndpoint::$NORTH_AMERICA, // or NORTH_AMERICA / FAR_EAST
            // 'role_arn' => 'arn:aws:iam::912373548221:role/partnerRole',
            
            
            'refresh_token' => 'Atzr|IwEBIJNVKrtgw2rlp6cpOaarulY0UoWvGQUlVfNZpOe9Phc-6erCr9P_ZtYbVhgLxPYMavCfWEjxjzyS7wX3H5rNnBqLhmsBtJxAeLoFmW52o6JB5hiFe8R6avkKpz0B2olDQzz6g6K4yfmwTwEAkOXvqgPD5js7W4Qr1U0jMzd62nBj_aM8mMojYFWy32QDTuuHwwcOJP3iSeT8Qhzo5GxXZTjBACj6ezQGHr_JoG7RoE1v5LaFvkKmHwm8GJyN1-uV5QZFdh2_MpVlql9aN3YE3S-dWEP8O_5BA-JXOwCbOpEaI3wK2aaNl-FNBp2HJog0atA', // Aztr|...
            'client_id' => 'amzn1.application-oa2-client.ed76124a57eb438fbfdfcaf71c146798', // App ID from Seller Central, amzn1.sellerapps.app.cfbfac4a-......
            'client_secret' => 'd4194f87b6a774b56c5d8515b2db34984a78c18a973d7a33509e762e4f3c51ff', // The corresponding Client Secret
            'region' => \ClouSale\AmazonSellingPartnerAPI\SellingPartnerRegion::$NORTH_AMERICA, // or NORTH_AMERICA / FAR_EAST
            // 'access_key' => 'AKIA5I3NTQS62LGLSV4Q', // Access Key of AWS IAM User, for example AKIAABCDJKEHFJDS
            // 'secret_key' => 'vBtWyqxX2epKG1kmKgaf6naUa4FN0jf8A7ieLBB5', // Secret Key of AWS IAM User
            'access_key' => 'AKIA3XXRPRTQJDRZOVSN', // Access Key of AWS IAM User, for example AKIAABCDJKEHFJDS
            'secret_key' => 'WG1y7+G1OOX3bljJBzcmxVOLB5gW79SCcc85WhCD', // Secret Key of AWS IAM User

            'endpoint' => \ClouSale\AmazonSellingPartnerAPI\SellingPartnerEndpoint::$NORTH_AMERICA, // or NORTH_AMERICA / FAR_EAST
            'role_arn' => 'arn:aws:iam::806886542560:role/SellingPartnerRole',
        ];
        $accessToken = \ClouSale\AmazonSellingPartnerAPI\SellingPartnerOAuth::getAccessTokenFromRefreshToken(
            $this->options['refresh_token'],
            $this->options['client_id'],
            $this->options['client_secret']
        );
        $assumedRole = \ClouSale\AmazonSellingPartnerAPI\AssumeRole::assume(
            $this->options['region'],
            $this->options['access_key'],
            $this->options['secret_key'],
            $this->options['role_arn'],
        );
        $this->config = \ClouSale\AmazonSellingPartnerAPI\Configuration::getDefaultConfiguration();
        $this->config->setHost($this->options['endpoint']);
        $this->config->setAccessToken($accessToken);
        $this->config->setAccessKey($assumedRole->getAccessKeyId());
        $this->config->setSecretKey($assumedRole->getSecretAccessKey());
        $this->config->setRegion($this->options['region']);
        $this->config->setSecurityToken($assumedRole->getSessionToken());
    }


    public function test(){
        $data=array(["a"=>"avalue"]);
        $tempStr=XmlUtil::getProductXml($data);

        $config = [
            'view_path'   => APP_PATH . DS . 'views' . DS,
            'view_suffix' => '.html',
            'layout_on'   => false,
            // 'layout_name' => 'layout'
        ];

        $this->template = new Template($config);
        $product=new Product();
        $product->merchantIdentifier="ABCD1234";

        $this->template->assign(["product"=>$product]);
        $result=$this->template->display($tempStr);
        echo $result;
        die();
        return;
    }

    public function outXml(){
        // $templat_path="/public/template/amazon/product.xml";
        // $this->view->assign(["skuId"=>"testSKU"]);
        // $this->display($templat_path);


    }

    public function getAccessToken(){
        $this->initData();
        $accessToken = \ClouSale\AmazonSellingPartnerAPI\SellingPartnerOAuth::getAccessTokenFromRefreshToken(
            $this->options['refresh_token'],
            $this->options['client_id'],
            $this->options['client_secret']
        );

        $this->success("Get AccessToken",$accessToken);
    }

    public function roleTest(){
        $this->initData();
        $accessToken = \ClouSale\AmazonSellingPartnerAPI\SellingPartnerOAuth::getAccessTokenFromRefreshToken(
            $this->options['refresh_token'],
            $this->options['client_id'],
            $this->options['client_secret']
        );
        $assumedRole = \ClouSale\AmazonSellingPartnerAPI\AssumeRole::assume(
            $this->options['region'],
            $this->options['access_key'],
            $this->options['secret_key'],
            $this->options['role_arn'],
        );
        $config = \ClouSale\AmazonSellingPartnerAPI\Configuration::getDefaultConfiguration();
        $config->setHost($this->options['endpoint']);
        $config->setAccessToken($accessToken);
        $config->setAccessKey($assumedRole->getAccessKeyId());
        $config->setSecretKey($assumedRole->getSecretAccessKey());
        $config->setRegion($this->options['region']);
        $config->setSecurityToken($assumedRole->getSessionToken());
        $apiInstance = new \ClouSale\AmazonSellingPartnerAPI\Api\CatalogApi($config);
        $marketplace_id = 'ATVPDKIKX0DER';
        $asin = 'B0002ZFTJA';
        
        $result = $apiInstance->getCatalogItem($marketplace_id, $asin);
        var_dump($result);die;
        echo $result->getPayload()->getAttributeSets()[0]->getTitle(); // Never Gonna Give You Up [Vinyl Single]


    }
    
    
    public function getListingsItems(){
        $this->initData();
        $apiInstance = new \ClouSale\AmazonSellingPartnerAPI\Api\ListingsItemsApi($this->config);
        $marketplace_id = 'ATVPDKIKX0DER';//A3F9BCC6PZGEFO';
        // $asin = 'B09R1TFFBH';
        $seller_id  = 'A3F9BCC6PZGEFO' ;
        $sku = 'JK-JJL-0001-01';
        // $result=$apiInstance->listCatalogCategories();
        // echo json_encode($result);
        $result = $apiInstance->getListItems($marketplace_id,$seller_id,$sku);
         var_dump($result);
    }
    
     public function getCatalogItems(){
        $this->initData();
        $apiInstance = new \ClouSale\AmazonSellingPartnerAPI\Api\CatalogApi($this->config);
        $marketplace_id = 'ATVPDKIKX0DER';//A3F9BCC6PZGEFO';
        $asin = 'B09R1TFFBH';
        $query  = 'Tea' ;
        $sku = 'JK-JJL-0001-01';
        // $result=$apiInstance->listCatalogCategories();
        // echo json_encode($result);
        $result = $apiInstance->listCatalogItems($marketplace_id,'','',$sku);
         var_dump($result);
     }

    public function getCatalogItem(){
        $this->initData();

        $apiInstance = new \ClouSale\AmazonSellingPartnerAPI\Api\CatalogApi($this->config);

        $marketplace_id = 'ATVPDKIKX0DER';//A3F9BCC6PZGEFO';
        $asin = 'B09R1TFFBH';
        // $result=$apiInstance->listCatalogCategories();
        // echo json_encode($result);
        $result = $apiInstance->getCatalogItem($marketplace_id,$asin);
         var_dump($result->getPayload());
       // echo $result->getPayload()->getAttributeSets()[0]->getTitle(); // Never Gonna Give You Up [Vinyl Single]


    }




    public function getFeeds(){
        $this->initData();
        
        // $apiInstance = new \ClouSale\AmazonSellingPartnerAPI\Api\CatalogApi($config);
        // $config = \ClouSale\AmazonSellingPartnerAPI\Configuration::getDefaultConfiguration();
        // $config->setHost($this->options['endpoint']);
        // $config->setAccessToken($accessToken);
        // $config->setAccessKey($this->options['access_key']);
        // $config->setSecretKey($this->options['secret_key']);
        // $config->setRegion($this->options['region']);

        $apiInstance = new \ClouSale\AmazonSellingPartnerAPI\Api\FeedsApi(
            // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
            // This is optional, `GuzzleHttp\Client` will be used as default.
            // new \GuzzleHttp\Client(),
            $this->config
        );
        // $body = new \Swagger\Client\Models\CreateFeedDocumentSpecification(); // \Swagger\Client\Models\CreateFeedDocumentSpecification | 
        // $feed_id = "726367281561"; 
          $feed_types = array("JSON_LISTINGS_FEED","POST_PRODUCT_DATA","POST_INVENTORY_AVAILABILITY_DATA"); 
        // $feed_types = array("POST_PRODUCT_DATA"); // string[] | A list of feed types used to filter feeds. When feedTypes is provided, the other filter parameters (processingStatuses, marketplaceIds, createdSince, createdUntil) and pageSize may also be provided. Either feedTypes or nextToken is required.
        $marketplace_ids = array('ATVPDKIKX0DER'); // string[] | A list of marketplace identifiers used to filter feeds. The feeds returned will match at least one of the marketplaces that you specify.
        // $marketplace_ids = array('A3F9BCC6PZGEFO');
      
        $page_size = 10; // int | The maximum number of feeds to return in a single call.
        $processing_statuses = array("CANCELLED","DONE","FATAL","IN_PROGRESS","IN_QUEUE"); // string[] | A list of processing statuses used to filter feeds.
        $created_since = new \DateTime("2022-01-23T19:20:30+01:00"); // \DateTime | The earliest feed creation date and time for feeds included in the response, in ISO 8601 format. The default is 90 days ago. Feeds are retained for a maximum of 90 days.
        $created_until = new \DateTime("2022-01-25T19:20:30+01:00"); // \DateTime | The latest feed creation date and time for feeds included in the response, in ISO 8601 format. The default is now.
        $next_token = "next_token_example"; // string | A string token returned in the response to your previous request. nextToken is returned when the number of results exceeds the specified pageSize value. To get the next page of results, call the getFeeds operation and include this token as the only parameter. Specifying nextToken with any other parameters will cause the request to fail.

        try {
            $result = $apiInstance->getFeeds($feed_types, $marketplace_ids, $page_size);
            echo "\n";
            var_dump($result);
            print_r($result);
        } catch (Exception $e) {
            echo 'Exception when calling FeedsApi->createFeedDocument: ', $e->getMessage(), PHP_EOL;
        }
    }
    
    
    public function createFeedDocument(){
        $this->initData();
        

        $apiInstance = new \ClouSale\AmazonSellingPartnerAPI\Api\FeedsApi(
            // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
            // This is optional, `GuzzleHttp\Client` will be used as default.
            // new \GuzzleHttp\Client(),
            $this->config
        );
        // $body = new \ClouSale\AmazonSellingPartnerAPI\Models\Feeds\CreateFeedDocumentSpecification(); // \Swagger\Client\Models\CreateFeedDocumentSpecification | 
        $body = '{"contentType":"text/xml; charset=UTF-8"}';
        
// var_dump($body);die;
        try {
            $feedDocument = $apiInstance->createFeedDocument($body);
         var_dump($feedDocument);
            //echo "\n\n\n\n";
            $feedDocumentId = $feedDocument->getPayload()->getFeedDocumentId();
            $url = $feedDocument->getPayload()->getUrl();
            $key = $feedDocument->getPayload()->getEncryptionDetails()->getKey();
            $initializationVector = $feedDocument->getPayload()->getEncryptionDetails()->getInitializationVector();
            
            
            $key = base64_decode($key, true);
            $initializationVector = base64_decode($initializationVector, true);
    // var_dump($key);die;
            $file = file_get_contents($_SERVER['DOCUMENT_ROOT']."/template/amazon/testData1.xml");
            // $feedData = utf8_encode($file);
            //  var_dump($file);die;
            $feedDataEncrypted = ASECryptoStream::encrypt($file,  $key,  $initializationVector);
            // $feedDataEncrypted = preg_replace('/\s+/S', " ", $feedDataEncrypted);
    // var_dump($feedDataEncrypted);die;
            // $api = new Client();
            // $response = $api->request($url, [$feedDataEncrypted], ['Content-Type' => 'application/xml; charset=UTF-8']);
            // $response = $this->tocurl($url,['Content-Type' => 'text/xml; charset=UTF-8'],[$feedDataEncrypted]);

            $client = new Client(['exceptions' => false]);

            $request = new Request(
            // PUT!
                'PUT',
                // predefined url
                $url,
                // content type equal to content type from response createFeedDocument-operation
                array('Content-Type' =>'text/xml; charset=UTF-8'),
                // resource File
                $feedDataEncrypted
            );
    
            $response = $client->send($request);


            print_r($response);
            // print_r($feedDocumentId);print_r($url);print_r($key);print_r($initializationVector);
        } catch (Exception $e) {
            echo 'Exception when calling FeedsApi->createFeedDocument: ', $e->getMessage(), PHP_EOL;
        }
    }
    
    public function createFeed(){
        $this->initData();
        

        $apiInstance = new \ClouSale\AmazonSellingPartnerAPI\Api\FeedsApi(
            // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
            // This is optional, `GuzzleHttp\Client` will be used as default.
            // new \GuzzleHttp\Client(),
            $this->config
        );
        // $feed_document_id = "amzn1.tortuga.3.38cc48da-c626-4870-a012-38861be0103b.T3OX3U5NI8DND3";
        $body = '{
            "feedType":"POST_PRODUCT_DATA",
            "marketplaceIds":[
              "ATVPDKIKX0DER"
            ],
            "inputFeedDocumentId":"amzn1.tortuga.3.ec59dd9c-d64c-4fa7-9c90-a05e99ffd183.T300X10E71P80T"
          }';
        
        try {
            $result = $apiInstance->createFeed($body);
            print_r($result);
        } catch (Exception $e) {
            echo 'Exception when calling FeedsApi->createFeed: ', $e->getMessage(), PHP_EOL;
        }
    }
    
    
    public function getFeed(){
        $this->initData();
        

        $apiInstance = new \ClouSale\AmazonSellingPartnerAPI\Api\FeedsApi(
            // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
            // This is optional, `GuzzleHttp\Client` will be used as default.
            // new \GuzzleHttp\Client(),
            $this->config
        );
        $feed_id = "50114019038";
                
        try {
            $result = $apiInstance->getFeed($feed_id);
            print_r($result);
        } catch (Exception $e) {
            echo 'Exception when calling FeedsApi->getFeed: ', $e->getMessage(), PHP_EOL;
        }
    }

    
    
    public function getFeedDocument(){
        $this->initData();
        

        $apiInstance = new \ClouSale\AmazonSellingPartnerAPI\Api\FeedsApi(
            // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
            // This is optional, `GuzzleHttp\Client` will be used as default.
            // new \GuzzleHttp\Client(),
            $this->config
        );
        $feed_document_id = "amzn1.tortuga.3.fb19a61c-8cb0-48bc-9487-a9ef7aee9799.T1137LQJZTNNTE";
        
        try {
            $result = $apiInstance->getFeedDocument($feed_document_id);
            $res = $this->downloadFeedProcessingReport($result->getPayload());
            var_dump($res);
        } catch (Exception $e) {
            echo 'Exception when calling FeedsApi->getFeedDocument: ', $e->getMessage(), PHP_EOL;
        }
    }
    
    function tocurl($url, $header, $content){
      $ch = curl_init();
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
      curl_setopt($ch, CURLOPT_URL, $url);
      curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
      curl_setopt($ch, CURLOPT_POST, true);
      curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($content));
      $response = curl_exec($ch);
      if($error=curl_error($ch)){
          die($error);
      }
      curl_close($ch);
      return $response;
    }

    
    /**
     * @param $payload : Response from getFeedDocument Function. e.g.: response['payload']
     * @return array : Feed Processing Report.
     */
    public function downloadFeedProcessingReport($payload)
    {
        $key = null;
        $initializationVector = null;
        $feedUploadUrl = $payload['url'];

        // check if decryption in required
        if (isset($payload['encryption_details'])) {
            $key = $payload['encryption_details']['key'];
            $initializationVector = $payload['encryption_details']['initialization_vector'];

            // base64 decode before using in encryption
            $initializationVector = base64_decode($initializationVector, true);
            $key = base64_decode($key, true);
        }

        $feedDownloadUrl = $payload['url'];
// var_dump($key);var_dump($initializationVector);var_dump($feedDownloadUrl);
        if (!is_null($key)) {
            $feed_processing_report_content = ASECryptoStream::decrypt(file_get_contents($feedDownloadUrl), $key, $initializationVector);
        } else {
            $feed_processing_report_content = file_get_contents($feedDownloadUrl);
        }

        if(isset($payload['compressionAlgorithm']) && $payload['compressionAlgorithm']=='GZIP') {
            $feed_processing_report_content = gzdecode($feed_processing_report_content);
        }
// var_dump($feed_processing_report_content);die;
        // check if report content is json encoded or not
        if ($this->isJson($feed_processing_report_content) == true) {
            $json = $feed_processing_report_content;
        } else {
            $feed_processing_report_content = preg_replace('/\s+/S', " ", $feed_processing_report_content);
            // $feed_processing_report_content = html_entity_decode($feed_processing_report_content);
            // echo $feed_processing_report_content;
            // die();
            $xml = simplexml_load_string($feed_processing_report_content);
            $json = json_encode($xml);
        }

        return json_decode($json, TRUE);
    }

    public function isJson($string) {
        json_decode($string);
        return json_last_error() === JSON_ERROR_NONE;
    }


     /**
     * 创建InboundShipmentPlan
     *
     */
    public function CreateInboundShipmentPlan(){
        $this->initData();
        
        $apiInstance = new \ClouSale\AmazonSellingPartnerAPI\Api\FbaInboundApi(
            // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
            // This is optional, `GuzzleHttp\Client` will be used as default.
            // new \GuzzleHttp\Client(),
            $this->config
        );
        $body = new \ClouSale\AmazonSellingPartnerAPI\Models\FulfillmentInbound\CreateInboundShipmentPlanRequest();
        // $body = '{"contentType":"text/xml; charset=UTF-8"}';
        $body->setShipFromAddress([
            'Name'  =>  'Gorilla Store',
            'AddressLine1'  =>  '9637 Pierront STt1',
            'AddressLine2'  =>  'BURKE',
            'DistrictOrCounty'  =>  'US',
            'City'  =>  'Richmond',
            'StateOrProvinceCode'  =>  'VA',
            'CountryCode'  =>  'US',
            'PostalCode'  =>  '20015',
        ]);
        $body->setLabelPrepPreference("SELLER_LABEL");
        $body->setShipToCountryCode("US");
        $body->setShipToCountrySubdivisionCode("");
        $body->setInboundShipmentPlanRequestItems([[
            'SellerSKU'  =>  'YZB-SHYP-CWL-009-01',
            'ASIN'  =>  'B07VS6FL3T',
            'Condition'  =>  'NewItem',
            'Quantity'  =>  '1',
            'QuantityInCase'  =>  '1',
            'PrepDetailsList'  =>  ''
        ]]);
        // var_dump($body);die;
        try {
            $result = $apiInstance->createInboundShipmentPlan($body);
            
            print_r($result);
        } catch (Exception $e) {
            echo  '调用 FbaInboundApi->createInboundShipmentPlan 时出现异常:' , $e->getMessage(), PHP_EOL ;
        }
    }

 /**
     * 创建InboundShipment
     *
     */
    public function CreateInboundShipment(){
        $this->initData();
        
        $apiInstance = new \ClouSale\AmazonSellingPartnerAPI\Api\FbaInboundApi(
            // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
            // This is optional, `GuzzleHttp\Client` will be used as default.
            // new \GuzzleHttp\Client(),
            $this->config
        );
        $body = new \ClouSale\AmazonSellingPartnerAPI\Models\FulfillmentInbound\InboundShipmentRequest();
        // $body = '{"contentType":"text/xml; charset=UTF-8"}';
        $body->setInboundShipmentHeader([
            'ShipmentName'  =>  'Gorilla Store',
            'ShipFromAddress'  =>  '9637 Pierront STt1',
            'DestinationFulfillmentCenterId'  =>  'CLT2',
            'AreCasesRequired'  =>  '',
            'ShipmentStatus'  =>  'WORKING',
            'LabelPrepPreference'  =>  'SELLER_LABEL',
            'IntendedBoxContentsSource'  =>  ''
        ]);

        
        $fbaInboundShipmentItemList = array();
        $fbaInboundShipmentItem=new \ClouSale\AmazonSellingPartnerAPI\Models\FulfillmentInbound\InboundShipmentItem();
       
        $fbaInboundShipmentItem->setShipmentId("FBA16M0R68M9");
        $fbaInboundShipmentItem->setSellerSku("YZB-SHYP-CWL-009-02");
        $fbaInboundShipmentItem->setQuantityShipped(1);

        // $body->setInboundShipmentItems([[
        //     'SellerSKU'  =>  'YZB-SHYP-CWL-009-02',
        //     'FulfillmentNetworkSKU'  =>  'X0036FDYCN',
        //     'QuantityShipped'  =>  '1'
        // ]]);

        array_push($fbaInboundShipmentItemList,$fbaInboundShipmentItem);

        $body->setInboundShipmentItems($fbaInboundShipmentItemList);
        $body->setMarketplaceId('ATVPDKIKX0DER');
        $shipment_id = 'FBA16M0R68M9';
        // var_dump($body);die;
        try {
            $result = $apiInstance->createInboundShipment($body,$shipment_id);
            
            print_r($result);
        } catch (Exception $e) {
            echo  '调用 FbaInboundApi->createInboundShipment 时出现异常:' , $e->getMessage(), PHP_EOL ;
        }
    }



}
