<?php

namespace datonique\Analytic;
use datonique\Analytic\Analytic;

class SubscriptionCancelled extends Subscription {

    public function __construct($subscription_info)
    {
        parent::__construct($subscription_info, 'subscription_end');
    }
}