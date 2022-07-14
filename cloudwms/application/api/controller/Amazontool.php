<?php
namespace app\api\controller;

use app\common\controller\Api;
use app\common\controller\Backend;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\IOFactory;
use think\Db;

use DOMDocument;
use DOMElement;
use DOMNode;
use DOMText;
use DOMXPath;
use app\common\controller\Amazon;

class Amazontool extends Api
{
    protected $noNeedLogin = ['*'];
    protected $noNeedRight = ['*'];


    public $fileJson='["arts-and-crafts_browse_tree_guide._TTH_.xls","automotive_browse_tree_guide.xls","baby-products_browse_tree_guide.xls","beauty_browse_tree_guide.xls","books_browse_tree_guide.xls","cell-phones_browse_tree_guide.xls","electronics_browse_tree_guide.xls","fashion_browse_tree_guide (1).xls","fashion_browse_tree_guide (2).xls","fashion_browse_tree_guide (3).xls","fashion_browse_tree_guide.xls","garden_browse_tree_guide.xls","grocery_browse_tree_guide._TTH_.xls","health_browse_tree_guide.xls","home-improvement_browse_tree_guide.xls","industrial_browse_tree_guide._TTH_.xls","jewelry_browse_tree_guide.xls","musical-instruments_browse_tree_guide._TTH_.xls","office-products_browse_tree_guide.xls","pet-supplies_browse_tree_guide.xls","software_browse_tree_guide.xls","sporting-goods_browse_tree_guide._TTH_.xls","toys-and-games_browse_tree_guide.xls","videogames_browse_tree_guide.xls","watches_browse_tree_guide.xls"]';

    public function initItemType(){
        set_time_limit(0);
        ini_set ('memory_limit', '512M') ;
        $filePath=$_SERVER['DOCUMENT_ROOT']."/amazon/itemTypes/";
        $inputFileType = 'Xls';
        if(!file_exists($filePath)) {
            return  $this->error('filePath '.$filePath.' does not exist!');
        }

        $files = scandir($filePath);

        $fileList=[];
        foreach($files as $v) {
           
            if($v=="." || $v==".."){
                continue;
            }
            // array_push($fileList,$v);

            $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xls();
            $readerFile=$filePath.$v;
            echo "begin load file ".$readerFile."<br>";
            $spreadsheet = $reader->load($readerFile);
            $currentSheet=$spreadsheet->getSheet(1);

            $allColumn = $currentSheet->getHighestDataColumn(); //取得最大的列号
            $allRow = $currentSheet->getHighestRow(); //取得一共有多少行
            $maxColumnNumber = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::columnIndexFromString($allColumn);
            if ($allRow <= 2) {
               continue;//no data
            }
            echo "begin parser and save data ".$readerFile."<br>";
          //  $orderList = [];
            $nodeData = [];
            for ($currentRow = 2; $currentRow <= $allRow - 1; $currentRow++) {
                $itemData = [];
                $itemData['node_id'] = $currentSheet->getCellByColumnAndRow(1, $currentRow)->getValue();
                $itemData['node_path'] = $currentSheet->getCellByColumnAndRow(2, $currentRow)->getValue();
                $itemData['query'] = $currentSheet->getCellByColumnAndRow(3, $currentRow)->getValue();
                $itemData['createtime']=time();
                $itemData['status']='Enable';
                array_push($nodeData,$itemData);
                // Db::name("amazon_item_type")->insert($itemData);
            }
            Db::name("amazon_item_type")->insertAll($nodeData,false,200);
            echo "File ".$readerFile." complete!<br>";

            

        }

        echo "All job complete!<br>";

        // echo json_encode($fileList);
 
    }


    public function initItemTypeBak(){
        set_time_limit(0);
        $index=$this->request->get("index");
        if(empty($index)){
            $index=0;
        }
        $fileList=json_decode($this->fileJson,true);
        if($index>=count($fileList)){
            echo "All job complete!<br>";
            die();
        }
        $v=$fileList[$index];
        $index=$index+1;
        $filePath=$_SERVER['DOCUMENT_ROOT']."/amazon/itemTypes/";
        $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xls();
        $readerFile=$filePath.$v;
        echo "begin load file ".$readerFile."<br>";
        $spreadsheet = $reader->load($readerFile);
        $currentSheet=$spreadsheet->getSheet(1);

        $allColumn = $currentSheet->getHighestDataColumn(); //取得最大的列号
        $allRow = $currentSheet->getHighestRow(); //取得一共有多少行
        $maxColumnNumber = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::columnIndexFromString($allColumn);
        if ($allRow <= 2) {
            echo "File ".$v." No data Skipped!<br>";
            $this->jumptoNext($index);
          //  header("location:http://amazon.jankow.com.cn/api/amazontool/readData?index=".$index);
        }
        echo "begin parser and save data ".$readerFile."<br>";
        $nodeData = [];
        for ($currentRow = 2; $currentRow <= $allRow - 1; $currentRow++) {
            $itemData = [];
            $itemData['node_id'] = $currentSheet->getCellByColumnAndRow(1, $currentRow)->getValue();
            $itemData['node_path'] = $currentSheet->getCellByColumnAndRow(2, $currentRow)->getValue();
            $itemData['query'] = $currentSheet->getCellByColumnAndRow(3, $currentRow)->getValue();
            $itemData['createtime']=time();
            $itemData['status']='Enable';
            // Db::name("amazon_item_type")->insert($itemData);
            array_push($nodeData,$itemData);
            
        }

        // echo json_encode($nodeData);
        // die();
        Db::name("amazon_item_type")->insertAll($nodeData,false,100);
        // Db::name("amazon_item_type")->data($nodeData)->limit(100)->insertAll();
        echo "File ".$readerFile." complete!<br>";
        $this->jumptoNext($index);
       // header("location:http://amazon.jankow.com.cn/api/amazontool/readData?index=".$index);
       //select DISTINCT SUBSTR(node_path,1,INSTR(node_path,'/')-1) from `pf_amazon_item_type` WHERE 1

    }


    public function initProductType(){
        set_time_limit(0);
        $filePath=$_SERVER['DOCUMENT_ROOT']."/amazon/xsd/";
        $attributes = array();   
        $xsdFile = "Product.xsd";  
        $xsdDoc = new DOMDocument();  
        $xsdDoc->preserveWhiteSpace = false;    
        if (file_exists($filePath.$xsdFile) && $xsdDoc->load($filePath.$xsdFile))  {
            // $root=$xsdDoc->documentElement;  
            // echo "ssss";
            // echo json_encode($xsdDoc);
            //  $attributeNodes=$root->getElementsByTagName("ProductData");
            //  echo json_encode($attributeNodes);
            //  die();
            $xsdpath = new DOMXPath($xsdDoc);     
            // $attributeNodes =$xsdpath->query('//xsd:element[@name="ProductData"]')->item(0);    
            $attributeNodes =$xsdpath->query('//xsd:choice')->item(0);    
            // echo json_encode($attributeNodes);
            // die();
            // //    $attributeNodes =$xsdpath->getElementsByTagName("ProductData")->item(0);
            //    echo json_encode($attributeNodes);
            //   die();   
            // echo "Sss";
            // echo json_encode($attributeNodes->childNodes);
            // die();  
            if(is_object($attributeNodes)){
                   
             
                foreach ($attributeNodes->childNodes as $attr) {  
                    $productType=[];    
                    $productType["pid"]=0;
                    $productType["type_name"]=$attr->getAttribute('ref'); 
                    $productType["status"]="Enable";
                    $productType["createtime"]=time();

                    $resultId= Db::name("amazon_product_type")->insertGetId($productType);

                    $xsdChildDoc = new DOMDocument();  
                    $xsdChildDoc->preserveWhiteSpace = false;  
                    $childFile=$filePath.$productType["type_name"].".xsd";

                   
                    if (file_exists($childFile) && $xsdChildDoc->load($childFile))  {
                            echo "load child file:".$childFile."<br>";
                            $xsdChildpath = new DOMXPath($xsdChildDoc);     
                            // $attributeNodes =$xsdpath->query('//xsd:element[@name="ProductData"]')->item(0);    
                            $attributeChildNodes =$xsdChildpath->query('//xsd:choice')->item(0);  
                            $childList=[];
                            if(is_object($attributeChildNodes)){
                                foreach ($attributeChildNodes->childNodes as $childAttr) {  
                                    $childProductType=[];    
                                    $childProductType["pid"]=$resultId;
                                    $childProductType["type_name"]=$childAttr->getAttribute('ref'); 
                                    $childProductType["status"]="Enable";
                                    $childProductType["createtime"]=time();
                                    array_push($childList,$childProductType);
                                }

                                Db::name("amazon_product_type")->insertAll($childList,false,400);
                            }
                    
                    }  
                }

                // echo "Sss1111";  
                //    echo   json_encode($resultId);
                   
                 //  die();
                 //  $attributes[$attr->getAttribute('value') ] = $attr->getAttribute('name');      
            }      
              //  unset($xsdpath);  
        } 
      //  print_r($attributes); 


    }

    function jumptoNext($index){
        // sleep(5);
        echo "<script>";
        echo "window.location.href='http://amazon.jankow.com.cn/api/amazontool/readData?index=".$index."'";
        echo "</script>";
    }


    public function operateFeed(){
        $post_data = $this->request->instance()->post(false);
        // var_dump($post_data);die;
  
        if(empty($title)||empty($sale_price)||empty($compare_at_price)||empty($market_price)||empty($operation_type)){
          $this->error(__('Invalid parameters'));
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
              $this->error(__('import fail plaese try again'));
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


      public function getFeedLog(){
        $list = Db::name('amazon_feed_log')->order('id desc')->select();
        $this->success(__('successful'),$list);
      }
}