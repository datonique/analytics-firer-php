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
        $httpConfig['base_uri'] = $config['base_uri'];
        if (is_null($config['base_uri'])) {
            exit("Need a base_uri to initialize\n");
        }
        if (is_null($config['client_id'])) {
            exit("Need a client_id to initialize\n");
        }
        if (is_null($config['client_secret'])) {
            exit("Need a client_secret to initialize\n");
        }
        if (isset($config['handler']) ) {
            $httpConfig['handler'] = $config['handler'];
            $accessToken = 'XXXX';
        } else {
            $accessToken = $this->getAccessToken($config['client_id'], $config['client_secret']);
        }

        $httpConfig['headers'] = array(
            'Content-Type' => 'application/json',
            'Authorization' => '' . $accessToken
        );

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

    private function getAccessToken(string $client_id, string $client_secret)
    {
        if (isset($config['handler']))
        $provider = new \League\OAuth2\Client\Provider\GenericProvider([
            'clientId'                => $client_id,
            'clientSecret'            => $client_secret,
            'urlAuthorize'            => 'http://my.example.com/your-redirect-url/',
            'urlAccessToken'          => 'https://hippoed.auth.us-east-2.amazoncognito.com/oauth2/token',
            'urlResourceOwnerDetails' => 'http://my.example.com/your-redirect-url/'
        ]);

        try {
            // Try to get an access token using the client credentials grant.
            return $provider->getAccessToken('client_credentials', ['scope' => 'aws.apig/sdk_access']);
        } catch (\League\OAuth2\Client\Provider\Exception\IdentityProviderException $e) {
            // Failed to get the access token
            echo "Cannot initiate analytics: Failed to get Access Token\n";
            exit($e->getMessage());
        }
    }
}
