<?php
// +----------------------------------------------------------------------
// | Tplay [ WE ONLY DO WHAT IS NECESSARY ]
// +----------------------------------------------------------------------
// | Copyright (c) 2017 http://showoow.com All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: yue < 994927909@qq.com >
// +----------------------------------------------------------------------

namespace app\index\controller;
use think\Controller;
use app\index\model\httpPost;
use app\index\model\httpGet;
use app\index\model\login;
use think\Db;
use think\Request;
use think\Session;
use think\cache;
use Mws\MarketplaceWebServiceOrders_Client;
use Mws\MarketplaceWebServiceOrders_Mock;
use Mws\Model\MarketplaceWebServiceOrders_Model_GetOrderRequest;
use Mws\Model\MarketplaceWebServiceOrders_Model_GetServiceStatusRequest;
use Mws\Model\MarketplaceWebServiceOrders_Model_ListOrdersRequest;
include EXTEND_PATH.'Mws/.config.inc.php';

class Index  extends Controller
{	

    public function index()
    {	
        // $dom = new \DomDocument();
        // dump($dom);
        $serviceUrl = "https://mws.amazonservices.com/Orders/2013-09-01";


         $config = array (
           'ServiceURL' => $serviceUrl,
           'ProxyHost' => null,
           'ProxyPort' => -1,
           'ProxyUsername' => null,
           'ProxyPassword' => null,
           'MaxErrorRetry' => 3,
         );


         $service = new MarketplaceWebServiceOrders_Client(
                AWS_ACCESS_KEY_ID,
                AWS_SECRET_ACCESS_KEY,
                APPLICATION_NAME,
                APPLICATION_VERSION,
                $config);
        $request = new MarketplaceWebServiceOrders_Model_ListOrdersRequest(array('MarketplaceId'=>'ATVPDKIKX0DER','CreatedAfter'=>date('Y-m-d')));
         $request->setSellerId(MERCHANT_ID);
       
       
           $response = $service->ListOrders($request);


    }
   

    public function invokeListOrders($service, $request)
      {
          try {
            $response = $service->ListOrders($request);

            echo ("Service Response\n");
            echo ("=============================================================================\n");

            $dom = new DOMDocument();
            $dom->loadXML($response->toXML());
            $dom->preserveWhiteSpace = false;
            $dom->formatOutput = true;
            echo $dom->saveXML();
            echo("ResponseHeaderMetadata: " . $response->getResponseHeaderMetadata() . "\n");

         } catch (MarketplaceWebServiceOrders_Exception $ex) {
            echo("Caught Exception: " . $ex->getMessage() . "\n");
            echo("Response Status Code: " . $ex->getStatusCode() . "\n");
            echo("Error Code: " . $ex->getErrorCode() . "\n");
            echo("Error Type: " . $ex->getErrorType() . "\n");
            echo("Request ID: " . $ex->getRequestId() . "\n");
            echo("XML: " . $ex->getXML() . "\n");
            echo("ResponseHeaderMetadata: " . $ex->getResponseHeaderMetadata() . "\n");
         }
     }




	
}
	