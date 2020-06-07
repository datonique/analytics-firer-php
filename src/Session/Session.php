<?php

namespace datonique\Session;

class Session {
    /**
     * Required
     */
    private $session_id;
    private $os;
    private $os_version;
    private $browswer;
    private $broweser_version;
    private $web_or_mobile;
    private $product_description;
    private $product_shortname;

    /**
     * Optional User Information
     */
    private $visitor_id;
    private $user_id;
    private $uas_user_id;
    private $user_first_name;
    private $user_last_name;
    private $user_email;
    private $profession_id;
    private $profession_title;

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
            'os' => $this->os,
            'os_version' => $this->os_version,
            'browswer' => $this->browswer,
            'broweser_version' => $this->broweser_version,
            'web_or_mobile' => $this->web_or_mobile,
            'product_description' => $this->product_description,
            'product_shortname' => $this->product_shortname,
            'visitor_id' => $this->session_id,
            'user_id' => $this->user_id,
            'uas_user_id' => $this->uas_user_id,
            'user_first_name' => $this->user_first_name,
            'user_last_name' => $this->user_last_name,
            'user_email' => $this->user_email,
            'profession_id' => $this->profession_id,
            'profession_title' => $this->profession_title,
        );
    }

    private function isVisitor() 
    {
        return is_null($this->user_id);
    }

    // TODO: set userID
}