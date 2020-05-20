<?php

namespace datonique\Firer;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Psr7\Response;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7;
use datonique\Analytic\Analytic;
use GuzzleHttp\Middleware;

/**
 * BatchRequestFirer Class
 *
 * @author George Torres <george@datonique.com>
 */
class Firer
{
    /**
     * dantonique Client
     *
     * @var Client
     */
    private $client = null;

    /**
     * Queue of Analytixs
     *
     * @var array
     */
    private $queue = [];

    /**
     * Queue of successfully fired
     * 
     * @var array Response
     */
    private $success_queue = [];

    /**
     * Queue of successfully fired
     * 
     * @var array
     */
    private $failed_queue = [];

    /**
     * Determines the maximum size the queue is allowed to reach. New items pushed
     * to the queue will be ignored if this size is reached and cannot be flushed.
     * Defaults to 10000.
     *
     * @var integer
     */
    private $maxQueueSize = 10000;

    /**
     * Determines how many operations are sent to Segment.io in a single request.
     * Defaults to 100.
     *
     * @var integer
     */
    private $batchSize = 100;

    /**
     * Constructor
     *
     * @param array                $options An array of configuration options
     */
    public function __construct(Client $client, array $options = [])
    {
        // TODO: error checking around client setting
        $this->client = $client;

        if (isset($options['max_queue_size'])) {
            $this->maxQueueSize = $options['max_queue_size'];
        }

        if (isset($options['batch_size'])) {
            $this->batchSize = $options['batch_size'];
        }
    }

    /**
     * Destructor
     *
     * Flushes any queued Operations
     */
    public function __destruct()
    {
        $this->flush();
        unset($this->client);
    }

    /**
     * Adds Events to the Queue
     *
     * Will attempt to flush the queue if the size of the queue has reached
     * the Max Queue Size
     *
     * @param  array   $analytic Analytics as an associative array
     *
     * @return boolean
     */
    public function enqueue(Analytic $analytic)
    {
        if (count($this->queue) >= $this->maxQueueSize)
            return false;

        array_push($this->queue, $analytic);

        if (count($this->queue) >= $this->maxQueueSize) {
            $this->flush();
        }

        return true;
    }

    /**
     * Flushes the queue by batching Import operations
     *
     * @return boolean
     */
    public function flush()
    {
        if (empty($this->queue)) {
            return false;
        }

        // TODO: true batching https://docs.guzzlephp.org/en/5.3/clients.html#batching-requests
        while ($analytic = array_pop( $this->queue )) {
            // TODO: validate to send
            try {
                $response = $this->sendRequest($analytic);  

                if ($response->getStatusCode() === 200) {
                    array_push($this->success_queue, $response);
                }
            } catch (ClientException $e) {
                array_push($this->failed_queue, $analytic);
                if ($e->hasResponse()) {
                    echo Psr7\str($e->getResponse());
                }
            }
        }

        // TODO: re-enque failed attemps

        return true;
    }

    /**
     * Get success queue
     * 
     * @return array
     */
    public function getQueue()
    {
        return $this->queue;
    }

    /**
     * Get success queue
     * 
     * @return array
     */
    public function getSuccessQueue()
    {
        return $this->success_queue;
    }

    /**
     * Get fail queue
     * 
     * @return array
     */
    public function getFailQueue()
    {
        return $this->failed_queue;
    }


    /**
     * 
     */
    private function sendRequest(Analytic $analytic) 
    {
        $response = $this->client->put('', [
            'json'    => $analytic->toOutArray()
        ]);

        return $response;
    }

}