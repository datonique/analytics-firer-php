<?php

namespace datonique\Analytic;
use datonique\Analytic\Analytic;

abstract class Subscription extends Analytic {
    private $subscription_id;
    private $subscription_start_date;
    private $subscription_end_date;
    private $subscription_type_id;
    private $subscription_type_title;
    private $order_id;
    private $order_email;
    private $order_createdate;
    private $order_item_quantity;
    private $order_item_price;
    private $order_item_total;
    private $order_promotion_code;
    private $order_promotion_title;
    private $order_promotion_total;
    private $order_groupnum;
    private $order_group_discount_total;
    private $order_total;
    private $automatic_renewal;
    private $braintree_subscription_id;
    
    
    
    
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
        parent::__construct($subsription_event, array());
        $this->subscription_id = isset($subscription_info['subscription_id']) ? $subscription_info['subscription_id'] : null;
        $this->subscription_start_date = isset($subscription_info['subscription_start_date']) ? $subscription_info['subscription_start_date'] : null;
        $this->subscription_end_date = isset($subscription_info['subscription_end_date']) ? $subscription_info['subscription_end_date'] : null;
        $this->subscription_type_id = isset($subscription_info['subscription_type_id']) ? $subscription_info['subscription_type_id'] : null;
        $this->subscription_type_title = isset($subscription_info['subscription_type_title']) ? $subscription_info['subscription_type_title'] : null;
        $this->order_id = isset($subscription_info['order_id']) ? $subscription_info['order_id'] : null;
        $this->order_email = isset($subscription_info['order_email']) ? $subscription_info['order_email'] : null;
        $this->order_createdate = isset($subscription_info['order_createdate']) ? $subscription_info['order_createdate'] : null;
        $this->order_item_quantity = isset($subscription_info['order_item_quantity']) ? $subscription_info['order_item_quantity'] : null;
        $this->order_item_price = isset($subscription_info['order_item_price']) ? $subscription_info['order_item_price'] : null;
        $this->order_item_total = isset($subscription_info['order_item_total']) ? $subscription_info['order_item_total'] : null;
        $this->order_promotion_code = isset($subscription_info['order_promotion_code']) ? $subscription_info['order_promotion_code'] : null;
        $this->order_promotion_title = isset($subscription_info['order_promotion_title']) ? $subscription_info['order_promotion_title'] : null;
        $this->order_promotion_total = isset($subscription_info['order_promotion_total']) ? $subscription_info['order_promotion_total'] : null;
        $this->order_groupnum = isset($subscription_info['order_groupnum']) ? $subscription_info['order_groupnum'] : null;
        $this->order_group_discount_total = isset($subscription_info['order_group_discount_total']) ? $subscription_info['order_group_discount_total'] : null;
        $this->order_total = isset($subscription_info['order_total']) ? $subscription_info['order_total'] : null;
        $this->automatic_renewal = isset($subscription_info['automatic_renewal']) ? $subscription_info['automatic_renewal'] : null;
        $this->braintree_subscription_id = isset($subscription_info['braintree_subscription_id']) ? $subscription_info['braintree_subscription_id'] : null;

    }

    public function toOutArray() 
    {
        return array_merge(parent::toOutArray(), array(
            'subscription_id' => $this->subscription_id,
            'subscription_start_date' => $this->subscription_start_date,
            'subscription_end_date' => $this->subscription_end_date,
            'subscription_type_id' => $this->subscription_type_id,
            'subscription_type_title' => $this->subscription_type_title,
            'order_id' => $this->order_id,	
            'order_email' => $this->order_email,
            'order_createdate' => $this->order_createdate,
            'order_item_quantity' => $this->order_item_quantity,
            'order_item_price' => $this->order_item_price,
            'order_item_total' => $this->order_item_total,
            'order_promotion_code' => $this->order_promotion_code,
            'order_promotion_title' => $this->order_promotion_title,
            'order_promotion_total' => $this->order_promotion_total,
            'order_groupnum' => $this->order_groupnum,
            'order_group_discount_total' => $this->order_group_discount_total,
            'order_total' => $this->order_total,
            'automatic_renewal' => $this->automatic_renewal ? true : false,
            'braintree_subscription_id' => $this->braintree_subscription_id
        ));
    }
}