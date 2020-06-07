<?php

namespace datonique;

use GuzzleHttp\Client as HttpClient;
use GuzzleHttp\Command\Guzzle\GuzzleClient;
use datonique\Analytic\ButtonClick;
use datonique\Analytic\PageView;
use datonique\Firer\Firer;
use datonique\Session\Session;


/**
 * Web Service Client for Datonique
 *
 * @author George Torres <george@datonique.com>
 *
 */
class AnalyticsFirer
{
    /**
     * PHP Client Version
     */
    const VERSION = '0.1.0';

    private $session;

    /**
     * Constructor
     *
     * @param array $config
     */
    public function __construct(array $config = [])
    {
        $defaults = [
            'api_key'        => null,
            'max_queue_size' => 10000,
            'batch_size'     => 100
        ];

        // TODO: warn no api key set
        // TODO: no base_url set fail
        $httpConfig['base_uri'] = $config['base_uri'];
        $httpConfig['headers'] = array(
            'Content-Type' => 'application/json', 
            'x-api-key' => $config['api_key']
        );
        if (isset($config['handler']) ) {
            $httpConfig['handler'] = $config['handler'];
        }

        // $provider = new \League\OAuth2\Client\Provider\GenericProvider([
        //     'clientId'                => $config['client_id'],    // The client ID assigned to you by the provider
        //     'clientSecret'            => $config['client_secret'],    // The client password assigned to you by the provider
        //     // 'redirectUri'             => 'http://my.example.com/your-redirect-url/',
        //     'urlAuthorize'            => 'http://service.example.com/authorize',
        //     'urlAccessToken'          => 'https://hippoed.auth.us-east-2.amazoncognito.com/oauth2/token',
        //     'urlResourceOwnerDetails' => 'http://service.example.com/resource'
        // ]);
        
        // try {
        
        //     // Try to get an access token using the client credentials grant.
        //     $accessToken = $provider->getAccessToken('client_credentials', ['scope' => 'aws.apig/sdk_access']);
        
        // } catch (\League\OAuth2\Client\Provider\Exception\IdentityProviderException $e) {
        
        //     // Failed to get the access token
        //     echo "Cannot initiate analytics: Failed to get Access Token";
        //     exit($e->getMessage());
        
        // }

        // add handler if available for testing
        $client = new HttpClient($httpConfig);

        // Create the Client
        $this->firer = new Firer($client, $config);

        // Start session if none
        $this->session = new Session();
    }

    public function getSession()
    {
        return $this->session;
    }

    public function updateSession(Session $session)
    {
        $this->session = $session;
    }

    public function buttonClick(
        string $button_name, 
        string $html_page_title, 
        string $page_php_class_name, 
        string $page_url)
    {
        $button_analytic = new ButtonClick(        
            $button_name, 
            $html_page_title, 
            $page_php_class_name, 
            $page_url);
        $button_analytic->setSession($this->session);
        $this->firer->enqueue($button_analytic);
    }

    public function pageView(
        string $html_page_title, 
        string $page_php_class_name, 
        string $page_url)
    {
        $page_analytics = new PageView( 
            $html_page_title, 
            $page_php_class_name, 
            $page_url);
        $page_analytics->setSession($this->session);
        $this->firer->enqueue($page_analytics);
    }

    public function checkSuccess()
    {
        return count($this->firer->getSuccessQueue());
    }

    public function checkQueue()
    {
        return count($this->firer->getQueue());
    }

    public function checkFailed()
    {
        return count($this->firer->getFailQueue());
    }
}