<?php 

namespace datonique\AnalyticsFirer;

require 'vendor/autoload.php';

use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Request;



class Index
{
    public function fireAnalytics($greet = "Hello World")
    {
        $client = new Client([
            // Base URI is used with relative requests
            'base_uri' => 'https://3kw66flcr6.execute-api.us-west-1.amazonaws.com/dev/analytic',
            // You can set any number of default request options.
            'timeout'  => 2.0,
        ]);
        $api_key = "4XSn3imjYX22qLAzLJKSs3WbwFiGlmi163WObPRb";
        
        $request = new Request('PUT', '', ['x-api-key' => $api_key]);
        $response = $client->send($request);

        return $response;
    }
}

$package = new Index();
$response = $package->fireAnalytics();
echo $response->getStatusCode();
echo $response->getReasonPhrase();
echo $response->getProtocolVersion();