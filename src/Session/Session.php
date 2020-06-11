<?php

namespace datonique\Session;

class Session {
    private $cookie;

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
    public function __construct(Cookie $cookie)
    {
        // TODO: get unique ID
        $this->session_id = $this->getGuidV4(); 
        $this->cookie = $cookie;
        $this->cookie->setCookie('datonique_session_id', $this->session_id);
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
    private function getGuidV4()
    {
        $data = openssl_random_pseudo_bytes(16);
        assert(strlen($data) == 16);

        $data[6] = chr(ord($data[6]) & 0x0f | 0x40); // set version to 0100
        $data[8] = chr(ord($data[8]) & 0x3f | 0x80); // set bits 6-7 to 10

        return vsprintf('%s%s-%s-%s-%s-%s%s%s', str_split(bin2hex($data), 4));
    }
}