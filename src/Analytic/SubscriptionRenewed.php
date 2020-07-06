<?php

namespace datonique\Analytic;
use datonique\Analytic\Analytic;

class SubscriptionRenewed extends Subscription {

    public function __construct($subscription_info)
    {
        parent::__construct($subscription_info, 'subscription_renewed');
    }
}