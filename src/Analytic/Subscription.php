<?php

namespace datonique\Analytic;
use datonique\Analytic\Analytic;

abstract class Subscription extends Analytic {
        // user_id,
        // uas_user_id,
        // user_first_name,
        // user_last_name,
        // user_email,
        // user_createdate,
        // profession_id,
        // profession_title,

        // subscription_id,
        // subscription_start_date,
        // subscription_end_date,
        // subscription_type_id,
        // subscription_type_title,
        // order_id,	
        // order_email,
        // order_createdate,
        // order_item_quantity,
        // order_item_price,
        // order_item_total,
        // order_promotion_code,
        // order_promotion_title,
        // order_promotion_total,
        // order_groupnum,
        // order_group_discount_total,
        // order_total,
        // automatic_renewal,
        // braintree_subscription_id
    
    
    
    
    /**
     * Constructor
     *
     * @param array                 $subscription_info
     * @param string                $subsription_event
     */
    public function __construct(
        array $subscription_info,
        string $subsription_event
        )
    {
        parent::__construct($subsription_event);
    }

    public function toOutArray() 
    {
        return array_merge(parent::toOutArray(), array(

        ));
    }
}