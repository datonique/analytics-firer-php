<?php

namespace datonique\Analytic;
use datonique\Analytic\Analytic;

class SessionStart extends Analytic {
    
    /**
     * Constructor
     *
     * @param string                $button_name
     */
    public function __construct()
    {
        parent::__construct('session_start');
    }

    public function toOutArray() 
    {
        return array_merge(parent::toOutArray());
    }
}