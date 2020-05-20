<?php

namespace datonique\Session;

class Session {
    /**
     * Required
     */
    private $session_id;

    /**
     * Optional
     */
    private $user_id;

    /**
     * Constructor
     *
     * @param string                $button_name
     */
    public function __construct()
    {
        // TODO: get unique ID
        $this->session_id = "UUID"; 
    }

    public function toOutArray()
    {
        return array(
            'session_id' => $this->session_id,
        );
    }

    // TODO: set userID
}