<?php

namespace datonique\Analytic;

use datonique\Session\Session;

class Analytic {

    // Event
    private $event_name;
    private $unix_timestamp;
    private $session;

    /**
     * Constructor
     *
     * @param string                $event_name
     */
    public function __construct($event_name) {
        $this->event_name = $event_name;
        $this->timestamp = time();
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
                'unix_timestamp' => $this->timestamp,
            )
        );
    }


}