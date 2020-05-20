<?php

namespace datonique\Analytic;

use datonique\Session\Session;

class Analytic {

    // Browser/client properties

    // Event
    private $event_name;
    private $timestamp;
    private $session;

    /**
     * Constructor
     *
     * @param string                $event_name
     */
    public function __construct($event_name) {
        $this->event_name = $event_name;
        $this->timestamp = round(microtime(true) * 1000);
    }

    /**
     * Add user information
     */

    /**
     * Add session infoemation
     */
    public function setSession(Session $session) {
        $this->session = $session;
    }

    /**
     * toArray
     */
    public function toOutArray() {
        return array_merge(

            // session information
            is_null($this->session) ? [] : $this->session->toOutArray(),
            
            // general event information
            array(
                'event_name' => $this->event_name,
                'timestamp' => $this->timestamp,
            )
        );
    }


}