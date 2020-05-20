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

        // add handler if available for testing
        $client = new HttpClient($httpConfig);

        // Create the Client
        $this->firer = new Firer($client, $config);

        // Start session if none
        $this->session = new Session();
    }

    public function buttonClick(string $button_name, string $page_name)
    {
        $button_analytic = new ButtonClick($button_name, $page_name);
        $button_analytic->setSession($this->session);
        $this->firer->enqueue($button_analytic);
    }

    public function pageView(string $page_name)
    {
        $page_analytics = new PageView($page_name);
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