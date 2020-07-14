<?php

namespace datonique;

use Exception;
use GuzzleHttp\Client as HttpClient;
use GuzzleHttp\Command\Guzzle\GuzzleClient;
use datonique\Analytic\ButtonClick;
use datonique\Analytic\InquisitionEnd;
use datonique\Analytic\InquisitionProgress;
use datonique\Analytic\PageView;
use datonique\Analytic\Registration;
use datonique\Analytic\SessionStart;
use datonique\Analytic\SubscriptionCancelled;
use datonique\Analytic\SubscriptionStart;
use datonique\Analytic\SubscriptionRenewed;
use datonique\Firer\Firer;
use datonique\Firer\EmptyFirer;
use datonique\Session\Session;
use datonique\Session\Cookie;


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
        if (!isset($config['base_uri']) || is_null($config['base_uri'])) {
            throw new Exception("Need a base_uri to initialize");
        }
        if (!isset($config['client_id']) || is_null($config['client_id'])) {
            throw new Exception("Need a client_id to initialize");
        }
        if (!isset($config['client_secret']) || is_null($config['client_secret'])) {
            throw new Exception("Need a client_secret to initialize");
        }
        if (!isset($config['api_key']) || is_null($config['api_key'])) {
            throw new Exception("Need a api_key to initialize");
        }
        if (!isset($config['is_user_session']) || is_null($config['is_user_session'])) {
            throw new Exception("Need is_user_session to initialize");
        }
        if (isset($config['handler']) ) {
            $httpConfig['handler'] = $config['handler'];
            $accessToken = 'XXXX';
        } else {
            $accessToken = $this->getAccessToken($config['client_id'], $config['client_secret']);
        }

        $httpConfig['headers'] = array(
            'Content-Type' => 'application/json',
            'Authorization' => '' . $accessToken,
            'x-api-key' => $config['api_key'],
        );

        // add handler if available for testing
        $client = new HttpClient($httpConfig);

        // Create the Client
        if (count($_COOKIE) > 0 || isset($config['mock_cookie'])) {
            $this->firer = new Firer($client, $config);
        } else {
            $this->firer = new EmptyFirer();
        }

        if(!isset($config['product_shortname'])) {
            throw new Exception("Need a product_shortname to initialize");
        }
        if(!isset($config['product_description'])) {
            throw new Exception("Need a product_description to initialize");
        }

        if (isset($config['mock_cookie'])) {
            $this->session = new Session($config['mock_cookie'], $config['product_shortname'], $config['product_description']);
        } else {
            // Start session if none
            $this->session = new Session(new Cookie(), $config['product_shortname'], $config['product_description']);
        }

        if (isset($config['user_info'])) {
            // TODO: validate user info
            $this->session->setUserInfo($config['user_info']);
        }

        if ($this->session->isNewSession() && $config['is_user_session']) {
            $this->sessionStart();
        }
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
        array $page_info)
    {
        $button_analytic = new ButtonClick(        
            $button_name, 
            $page_info);
        $button_analytic->setSession($this->session);
        $this->firer->enqueue($button_analytic);
    }

    public function pageView(array $page_info)
    {
        $page_analytics = new PageView( 
            $page_info);
        $page_analytics->setSession($this->session);
        $this->firer->enqueue($page_analytics);
    }

    public function sessionStart()
    {
        $session_start_analytic = new SessionStart();
        $session_start_analytic->setSession($this->session);
        $this->firer->enqueue($session_start_analytic);
    }

    public function subscriptionCancelled(array $user_info, array $subscripiton_info)
    {
        $this->session->setUserInfo($user_info);
        $subscription_cancelled_analytic = new SubscriptionCancelled($subscripiton_info, false);
        $subscription_cancelled_analytic->setSession($this->session);
        $this->firer->enqueue($subscription_cancelled_analytic);
    }

    public function freeTrialCancelled(array $user_info, array $subscripiton_info)
    {
        $this->session->setUserInfo($user_info);
        $subscription_cancelled_analytic = new SubscriptionCancelled($subscripiton_info, true);
        $subscription_cancelled_analytic->setSession($this->session);
        $this->firer->enqueue($subscription_cancelled_analytic);
    }

    public function subscriptionStart(array $user_info, array $subscripiton_info)
    {
        $this->session->setUserInfo($user_info);
        $subscription_start_analytic = new SubscriptionStart($subscripiton_info, false);
        $subscription_start_analytic->setSession($this->session);
        $this->firer->enqueue($subscription_start_analytic);
    }

    public function subscriptionRenewed(array $user_info, array $subscripiton_info)
    {
        $this->session->setUserInfo($user_info);
        $subscription_renewed_analytic = new SubscriptionRenewed($subscripiton_info);
        $subscription_renewed_analytic->setSession($this->session);
        $this->firer->enqueue($subscription_renewed_analytic);
    }

    public function freeTrialStart(array $user_info, array $subscripiton_info) 
    {
        $this->session->setUserInfo($user_info);
        $subscription_start_analytic = new SubscriptionStart($subscripiton_info, true);
        $subscription_start_analytic->setSession($this->session);
        $this->firer->enqueue($subscription_start_analytic);
    }

    public function registrationSucceeded(array $user_info, array $page_info)
    {
        $this->session->setUserInfo($user_info);
        $registration_succeeded = new Registration(true, $page_info);
        $registration_succeeded->setSession($this->session);
        $this->firer->enqueue($registration_succeeded);
    }

    public function registrationFailed($page_info)
    {
        $registration_failed = new Registration(false, $page_info);
        $registration_failed->setSession($this->session);
        $this->firer->enqueue($registration_failed);
    }

    public function inquisitionEnd(array $inquisition_info, array $episode_info, array $page_info)
    {
        $inquisition_event = new InquisitionEnd($inquisition_info, $episode_info, $page_info);
        $inquisition_event->setSession($this->session);
        $this->firer->enqueue($inquisition_event);
    }

    public function inquisitionProgress(array $inquisition_info, array $episode_info, array $page_info)
    {
        $inquisition_event = new InquisitionProgress($inquisition_info, $episode_info, $page_info);
        $inquisition_event->setSession($this->session);
        $this->firer->enqueue($inquisition_event);
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
            throw new Exception("Cannot initiate analytics: Failed to get Access Token: " . $e->getMessage());
        }
    }
}
