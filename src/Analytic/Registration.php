<?php

namespace datonique\Analytic;
use datonique\Analytic\Analytic;

class Registration extends Analytic {

    public function __construct(bool $success)
    {
        $event_name = $success ? 'registration_succeeded' : 'registration_failed';
        parent::__construct($event_name);
    }
}