<?php

namespace app\api\amazon;



final class XmlUtil{


    public static function getProductXml($data){
        $xmlTemplate=file_get_contents($_SERVER['DOCUMENT_ROOT']."/template/amazon/product.xml");
        return $xmlTemplate;
        // echo "xmlTemplate:".$xmlTemplate."\n";
        // $xml = new \SimpleXMLElement($xmlTemplate);  
        // foreach ($xml -> book as $book) {
        //     $attr = $book -> attributes();    //返回的是一个数字
        //     $book -> name = "变形金刚";
        // }
    
    }



}

