<?php

namespace datonique\Analytic;
use datonique\Analytic\Analytic;

class SubscriptionStart extends Subscription {

    public function __construct($subscription_info, bool $is_free_trial)
    {
        $event_name = $is_free_trial ? 'free_trial_start' : 'subscription_start';
        parent::__construct($subscription_info, $event_name);
    }
}