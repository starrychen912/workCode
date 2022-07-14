<?php

namespace app\common\controller;


use think\Template;
use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Request;
use ClouSale\AmazonSellingPartnerAPI\Helpers\ASECryptoStream;
use think\exception;
use think\Response;
use think\Db;

/**
 * Amazon基类
 */
class Amazon
{

    /**
     * @var array options 请求参数
     */
    protected $options = [];

    /**
     * @var config 配置
     */
    protected $config;


    /**
     * 构造方法
     * @access public
     */
    public function __construct($options = [])
    {

        // 控制器初始化
        $this->options = $options;
        // $this->options = [
            
            
        //     'refresh_token' => 'Atzr|IwEBIJNVKrtgw2rlp6cpOaarulY0UoWvGQUlVfNZpOe9Phc-6erCr9P_ZtYbVhgLxPYMavCfWEjxjzyS7wX3H5rNnBqLhmsBtJxAeLoFmW52o6JB5hiFe8R6avkKpz0B2olDQzz6g6K4yfmwTwEAkOXvqgPD5js7W4Qr1U0jMzd62nBj_aM8mMojYFWy32QDTuuHwwcOJP3iSeT8Qhzo5GxXZTjBACj6ezQGHr_JoG7RoE1v5LaFvkKmHwm8GJyN1-uV5QZFdh2_MpVlql9aN3YE3S-dWEP8O_5BA-JXOwCbOpEaI3wK2aaNl-FNBp2HJog0atA', // Aztr|...
        //     'client_id' => 'amzn1.application-oa2-client.ed76124a57eb438fbfdfcaf71c146798', // App ID from Seller Central, amzn1.sellerapps.app.cfbfac4a-......
        //     'client_secret' => 'd4194f87b6a774b56c5d8515b2db34984a78c18a973d7a33509e762e4f3c51ff', // The corresponding Client Secret
        //     'region' => \ClouSale\AmazonSellingPartnerAPI\SellingPartnerRegion::$NORTH_AMERICA, // or NORTH_AMERICA / FAR_EAST
        //     'access_key' => 'AKIA3XXRPRTQJDRZOVSN', // Access Key of AWS IAM User, for example AKIAABCDJKEHFJDS
        //     'secret_key' => 'WG1y7+G1OOX3bljJBzcmxVOLB5gW79SCcc85WhCD', // Secret Key of AWS IAM User

        //     'endpoint' => \ClouSale\AmazonSellingPartnerAPI\SellingPartnerEndpoint::$NORTH_AMERICA, // or NORTH_AMERICA / FAR_EAST
        //     'role_arn' => 'arn:aws:iam::806886542560:role/SellingPartnerRole',
        // ];
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

    



    /**
     * 产品导入到amazon
     * @ApiParams (name="file", type="string", required=true, description="xml内容")
     * @ApiParams (name="feedType", type="string", required=true, description="feedType")
     * @ApiParams (name="sku", type="string", required=true, description="sku")
     *
     */
    public function uploadproduct($file,$feedType,$sku){
        

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
            //createFeedDocument
            $feedDocument = $apiInstance->createFeedDocument($body);

            $feedDocumentId = $feedDocument->getPayload()->getFeedDocumentId();
            $url = $feedDocument->getPayload()->getUrl();
            $key = $feedDocument->getPayload()->getEncryptionDetails()->getKey();
            $initializationVector = $feedDocument->getPayload()->getEncryptionDetails()->getInitializationVector();
            
            
            $key = base64_decode($key, true);
            $initializationVector = base64_decode($initializationVector, true);
    // var_dump($key);die;
            // $file = file_get_contents($xml);
            // $file = preg_replace('/\s+/S', " ", $file);
            $feedData = utf8_encode($file);
    // var_dump($file);die;
            $feedDataEncrypted = ASECryptoStream::encrypt($feedData,  $key,  $initializationVector);
            

            //upload
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

            //createFeed
            $body = '{
                "feedType":"'.$feedType.'",
                "marketplaceIds":[
                  "ATVPDKIKX0DER"
                ],
                "inputFeedDocumentId":'.$feedDocumentId.'
              }';

            $result_createFeed = $apiInstance->createFeed($body);

            //getFeed
            $feed_id = $result_createFeed->getPayload()->getFeedId();
            $result_getFeed = $apiInstance->getFeed($feed_id);
            // var_dump($feed_id);
            // var_dump($result_getFeed);
            $processing_status = $result_getFeed->getPayload()->getProcessingStatus();
            // if($processing_status != 'DONE'){
            //     //使用redis
            //     $redis = new \Redis;
            //     $redis->connect('127.0.0.1',6379);
            //     $redis->lPush('wait_getFeed_queue',$feed_id);
            // }else{
            //     $feed_document_id = $result_createFeed->getPayload()->getResultFeedDocumentId();
            //     // $result_getFeedDocument = $apiInstance->getFeedDocument($feed_document_id);
            // }

            $log = [
                'feedDocumentId'  => $feedDocumentId,
                'url'  => $url,
                'document_key'  => $key,
                'initializationVector'  => $initializationVector,
                'feed_id'  => $feed_id,
                'result_feedDocumentId'  => isset($feed_document_id) ? $feed_document_id : '',
                'feed_type'  => $feedType,
                'sku'  => $sku,
                'create_time'  => time(),
            ];

            Db::name('amazon_feed_log')->insert($log);


            return true;
        } catch (Exception $e) {
            echo 'Exception when calling FeedsApi->createFeedDocument: ', $e->getMessage(), PHP_EOL;
            return false;
        }
    }


    /**
     * 获取产品导入结果
     * @ApiParams (name="feed_id", type="string", required=true, description="feed_id")
     *
     */
    public function getFeed($feed_id){
        $apiInstance = new \ClouSale\AmazonSellingPartnerAPI\Api\FeedsApi(
            // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
            // This is optional, `GuzzleHttp\Client` will be used as default.
            // new \GuzzleHttp\Client(),
            $this->config
        );
        
        try {
            $result = $apiInstance->getFeed($feed_id);
            $ResultFeedDocumentId = $result->getPayload()->getResultFeedDocumentId();
            return $ResultFeedDocumentId;
        } catch (Exception $e) {
            return false;
            //  'Exception when calling FeedsApi->getFeed: ', $e->getMessage(), PHP_EOL;
        }
    }

    /**
     * 获取产品导入结果报告
     * @ApiParams (name="ResultFeedDocumentId", type="string", required=true, description="ResultFeedDocumentId")
     *
     */
    public function getFeedDocument($ResultFeedDocumentId){
        
        $apiInstance = new \ClouSale\AmazonSellingPartnerAPI\Api\FeedsApi(
            // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
            // This is optional, `GuzzleHttp\Client` will be used as default.
            // new \GuzzleHttp\Client(),
            $this->config
        );
        
        
        try {
            $result = $apiInstance->getFeedDocument($ResultFeedDocumentId);
            
            $res = $this->downloadFeedProcessingReport($result->getPayload());
            return $res;
        } catch (Exception $e) {
            return false;
            // echo 'Exception when calling FeedsApi->getFeedDocument: ', $e->getMessage(), PHP_EOL;
        }
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
            $xml = simplexml_load_string($feed_processing_report_content);
            $json = json_encode($xml);
        }

        return json_decode($json, TRUE);
    }


    /**
     * 创建InboundShipmentPlan
     *
     */
    public function CreateInboundShipmentPlan($data){
        
        $apiInstance = new \ClouSale\AmazonSellingPartnerAPI\Api\FbaInboundApi(
            // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
            // This is optional, `GuzzleHttp\Client` will be used as default.
            // new \GuzzleHttp\Client(),
            $this->config
        );
        $body = new \ClouSale\AmazonSellingPartnerAPI\Models\FulfillmentInbound\CreateInboundShipmentPlanRequest();
        // $body = '{"contentType":"text/xml; charset=UTF-8"}';
        $body->setShipFromAddress([
            'Name'  =>  $data['Name'],
            'AddressLine1'  =>  $data['AddressLine1'],
            'AddressLine2'  =>  $data['AddressLine2'],
            'DistrictOrCounty'  =>  $data['DistrictOrCounty'],
            'City'  =>  $data['City'],
            'StateOrProvinceCode'  =>  $data['StateOrProvinceCode'],
            'CountryCode'  =>  $data['CountryCode'],
            'PostalCode'  =>  $data['PostalCode'],
        ]);
        $body->setLabelPrepPreference($data['LabelPrepPreference']);
        $body->setShipToCountryCode($data['ShipToCountryCode']);
        $body->setShipToCountrySubdivisionCode($data['ShipToCountrySubdivisionCode']);
        $body->setInboundShipmentPlanRequestItems([[
            'SellerSKU'  =>  $data['SellerSKU'],
            'ASIN'  =>  $data['ASIN'],
            'Condition'  =>  $data['Condition'],
            'Quantity'  =>  $data['Quantity'],
            'QuantityInCase'  =>  $data['QuantityInCase'],
            'PrepDetailsList'  =>  ''
        ]]);
        // var_dump($body);die;
        try {
            $result = $apiInstance->createInboundShipmentPlan($body);
            $ShipmentId = $result->getPayload()->getInboundShipmentPlans()[0]->getShipmentId();
            $DestinationFulfillmentCenterId = $result->getPayload()->getInboundShipmentPlans()[0]->getDestinationFulfillmentCenterId();
            $FulfillmentNetworkSku = $result->getPayload()->getInboundShipmentPlans()[0]->getItems()[0]->getFulfillmentNetworkSku();
            $data = [
                'ShipmentId' => $ShipmentId,
                'DestinationFulfillmentCenterId'  => $DestinationFulfillmentCenterId,
                'FulfillmentNetworkSku'  => $FulfillmentNetworkSku,
            ];
            return $data;
        } catch (Exception $e) {
            echo  '调用 FbaInboundApi->createInboundShipmentPlan 时出现异常:' , $e->getMessage(), PHP_EOL ;
            return false;
        }
    }


    /**
     * 创建InboundShipment
     *
     */
    public function CreateInboundShipment($data){
        
        $apiInstance = new \ClouSale\AmazonSellingPartnerAPI\Api\FbaInboundApi(
            // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
            // This is optional, `GuzzleHttp\Client` will be used as default.
            // new \GuzzleHttp\Client(),
            $this->config
        );
        $body = new \ClouSale\AmazonSellingPartnerAPI\Models\FulfillmentInbound\InboundShipmentRequest();
        // $body = '{"contentType":"text/xml; charset=UTF-8"}';
        $body->setInboundShipmentHeader([
            'ShipmentName'  =>  $data['ShipmentName'],
            'ShipFromAddress'  =>  [
                'Name'  =>  $data['Name'],
                'AddressLine1'  =>  $data['AddressLine1'],
                'AddressLine2'  =>  $data['AddressLine2'],
                'DistrictOrCounty'  =>  $data['DistrictOrCounty'],
                'City'  =>  $data['City'],
                'StateOrProvinceCode'  =>  $data['StateOrProvinceCode'],
                'CountryCode'  =>  $data['CountryCode'],
                'PostalCode'  =>  $data['PostalCode'],
            ],
            'DestinationFulfillmentCenterId'  =>  $data['DestinationFulfillmentCenterId'],
            'AreCasesRequired'  =>  $data['AreCasesRequired'],
            'ShipmentStatus'  =>  $data['ShipmentStatus'],
            'LabelPrepPreference'  =>  $data['LabelPrepPreference'],
            'IntendedBoxContentsSource'  =>  ''
        ]);
        $body->setInboundShipmentItems([[
            'SellerSKU'  =>  $data['SellerSKU'],
            'FulfillmentNetworkSKU'  =>  $data['FulfillmentNetworkSKU'],
            'QuantityShipped'  =>  $data['QuantityShipped']
        ]]);
        $body->setMarketplaceId($data['MarketplaceId']);
        $shipment_id = $data['ShipmentId'];
        
        // var_dump($body);die;
        try {
            $result = $apiInstance->createInboundShipment($body,$shipment_id);
            $ShipmentId = $result->getPayload()->getShipmentId();
            if(empty($ShipmentId) || $ShipmentId==null){
                return false;
            }
            return true;
        } catch (Exception $e) {
            echo  '调用 FbaInboundApi->createInboundShipment 时出现异常:' , $e->getMessage(), PHP_EOL ;
            return false;
        }
    }


    /**
     * 修改InboundShipment
     *
     */
    public function UpdateInboundShipment($data){
        
        $apiInstance = new \ClouSale\AmazonSellingPartnerAPI\Api\FbaInboundApi(
            // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
            // This is optional, `GuzzleHttp\Client` will be used as default.
            // new \GuzzleHttp\Client(),
            $this->config
        );
        $body = new \ClouSale\AmazonSellingPartnerAPI\Models\FulfillmentInbound\InboundShipmentRequest();
        // $body = '{"contentType":"text/xml; charset=UTF-8"}';
        $body->setInboundShipmentHeader([
            'ShipmentName'  =>  $data['ShipmentName'],
            'ShipFromAddress'  =>  [
                'Name'  =>  $data['Name'],
                'AddressLine1'  =>  $data['AddressLine1'],
                'AddressLine2'  =>  $data['AddressLine2'],
                'DistrictOrCounty'  =>  $data['DistrictOrCounty'],
                'City'  =>  $data['City'],
                'StateOrProvinceCode'  =>  $data['StateOrProvinceCode'],
                'CountryCode'  =>  $data['CountryCode'],
                'PostalCode'  =>  $data['PostalCode'],
            ],
            'DestinationFulfillmentCenterId'  =>  $data['DestinationFulfillmentCenterId'],
            'AreCasesRequired'  =>  $data['AreCasesRequired'],
            'ShipmentStatus'  =>  $data['ShipmentStatus'],
            'LabelPrepPreference'  =>  $data['LabelPrepPreference'],
            'IntendedBoxContentsSource'  =>  ''
        ]);
        $body->setInboundShipmentItems([[
            'SellerSKU'  =>  $data['SellerSKU'],
            'FulfillmentNetworkSKU'  =>  $data['FulfillmentNetworkSKU'],
            'QuantityShipped'  =>  $data['QuantityShipped']
        ]]);
        $body->setMarketplaceId($data['MarketplaceId']);
        $shipment_id = $data['ShipmentId'];
        
        // var_dump($body);die;
        try {
            $result = $apiInstance->updateInboundShipment($body,$shipment_id);
            $ShipmentId = $result->getPayload()->getShipmentId();
            if(empty($ShipmentId) || $ShipmentId==null){
                return false;
            }
            return true;
        } catch (Exception $e) {
            echo  '调用 FbaInboundApi->updateInboundShipment 时出现异常:' , $e->getMessage(), PHP_EOL ;
            return false;
        }
    }


    /**
     * 获取Amazon标签
     *
     * @ApiParams (name="PackageLabelsToPrint", type="string", required=false, description="地区或国家")
     */
    public function getLabels($data){
        
        $apiInstance = new \ClouSale\AmazonSellingPartnerAPI\Api\FbaInboundApi(
            // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
            // This is optional, `GuzzleHttp\Client` will be used as default.
            // new \GuzzleHttp\Client(),
            $this->config
        );
        $shipment_id = $data['ShipmentId']; // string | A shipment identifier originally returned by the createInboundShipmentPlan operation.
        $page_type = $data['PageType']; // string | The page type to use to print the labels. Submitting a PageType value that is not supported in your marketplace returns an error.
        $label_type = $data['LabelType']; // string | The type of labels requested.
        $number_of_packages = $data['NumberOfPackages']; // int | The number of packages in the shipment.
        $package_labels_to_print = array(); // string[] | A list of identifiers that specify packages for which you want package labels printed.  Must match CartonId values previously passed using the FBA Inbound Shipment Carton Information Feed. If not, the operation returns the IncorrectPackageIdentifier error code.
        $number_of_pallets = $data['NumberOfPallets']; // int | The number of pallets in the shipment. This returns four identical labels for each pallet.
        $page_size = $data['PageSize'];
        
        // var_dump($body);die;
        try {
            $result = $apiInstance->getLabels($shipment_id, $page_type, $label_type, $number_of_packages,$package_labels_to_print,$number_of_pallets,$page_size);
            $DownloadUrl = $result->getPayload()->getDownloadUrl();
            if(empty($DownloadUrl) || $DownloadUrl==null){
                return false;
            }
            return $DownloadUrl;
        } catch (Exception $e) {
            echo 'Exception when calling FbaInboundApi->getLabels: ', $e->getMessage(), PHP_EOL;
            return false;
        }
    }

}