<?php

namespace datonique\Analytic;
use datonique\Analytic\PageAnalytic;

class Registration extends PageAnalytic {

    public function __construct(bool $success, array $page_info)
    {
        $event_name = $success ? 'registration_succeeded' : 'registration_failed';
        parent::__construct($event_name, $page_info);
    }
}