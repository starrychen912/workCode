<?php

namespace app\api\controller;

use app\common\controller\Api;

class Webhook extends Api
{

    protected $noNeedLogin = ['*'];
    protected $noNeedRight = ['*'];

    public function orders(){

    
       try {
                $response = \Shopify\Webhooks\Registry::process($this->request->headers, $this->request->getRawBody());
    
                if ($response->isSuccess()) {
                    file_put_contents("/tmp/writeOrder.txt",json_encode($response),FILE_APPEND);
                    return  $this->result(json_encode($response));
                    // Respond with HTTP 200 OK
                } else {
                    file_put_contents("/tmp/writeOrder.txt","Webhook handler failed with message: " . $response->getErrorMessage(),FILE_APPEND);
                   
                    return  $this->result(json_encode("Webhook handler failed with message: " . $response->getErrorMessage()));
                    // The webhook request was valid, but the handler threw an exception
                  //  $this->result("Webhook handler failed with message: " . $response->getErrorMessage());
                }
            } catch (\Exception $error) {
                // The webhook request was not a valid one, likely a code error or it wasn't fired by Shopify
                $this->result($error);
            }
       
    }

}