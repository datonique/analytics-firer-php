<?php

namespace datonique\Session;

class Session {
    private $cookie;

    /**
     * Required
     */
    public $session_id;
    private $os;
    private $os_version;
    private $browser;
    private $broweser_version;
    private $platform;
    
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
    private $user_createdate;
    private $profession_id;
    private $profession_title;

    private $is_new_session;
    static $COOKIE_SESSION_ID = 'datonique_session_id';
    static $MAX_SESSION_LENGTH = 60*30; // 30 min
    /**
     * Constructor
     *
     * @param string                $button_name
     */
    public function __construct(Cookie $cookie, string $product_shortname, string $product_description)
    {
        $this->cookie = $cookie;
        $this->session_id = $cookie->getCookie(Session::$COOKIE_SESSION_ID);
        $this->is_new_session = false;
        if (is_null($this->session_id)) {
            $this->session_id = $this->getGuidV4();
            if (count($_COOKIE) > 0) {
                $this->cookie->setCookie(Session::$COOKIE_SESSION_ID, $this->session_id, time()+Session::$MAX_SESSION_LENGTH);
                $this->setIsNewSession(true);
                $this->is_new_session = true;
            }
        }

        $browser = new Browser();
        $client_info = $browser->browser_detection('full_assoc');
        $this->os = $client_info['os'];
        $this->os_version = $client_info['os_number'];
        $this->browser = $client_info['browser_name'];
        $this->browser_version = $client_info['browser_number'];
        
        if ($client_info['ua_type'] == 'bro' || $client_info['ua_type'] == 'bbro' ) {
            $this->platform = 'web';
        } else {
            $this->platform = $client_info['ua_type'];
        }

        if (!isset($product_description) || !isset($product_shortname)) {
            throw new Exception('Need product_description and product_shortname to initialize');
        }

        $this->product_shortname = $product_shortname;
        $this->product_description = $product_description;
    }

    public function toOutArray()
    {
        $out_array = array(
            'visitor_session_id' => $this->session_id,
            'os' => $this->os,
            'os_version' => $this->os_version,
            'browser' => $this->browser,
            'browser_version' => $this->browser_version,
            'platform' => $this->platform,
            'product_description' => $this->product_description,
            'product_shortname' => $this->product_shortname,
        );

        if (isset($this->user_id)) {
            $out_array['user_id'] = sprintf('%s', $this->user_id);
        }
        if (isset($this->uas_user_id)) {
            $out_array['uas_user_id'] = sprintf('%s', $this->uas_user_id);
        }
        if (isset($this->user_first_name)) {
            $out_array['user_first_name'] = $this->user_first_name;
        }
        if (isset($this->user_last_name)) {
            $out_array['user_last_name'] = $this->user_last_name;
        }
        if (isset($this->user_email)) {
            $out_array['user_email'] = $this->user_email;
        }
        if (isset($this->user_createdate)) {
            $out_array['user_createdate'] = $this->user_createdate;
        }
        if (isset($this->profession_id)) {
            $out_array['profession_id'] = $this->profession_id;
        }
        if (isset($this->profession_title)) {
            $out_array['profession_title'] = $this->profession_title;
        }
        return $out_array;
    }

    private function getGuidV4()
    {
        $data = openssl_random_pseudo_bytes(16);
        assert(strlen($data) == 16);

        $data[6] = chr(ord($data[6]) & 0x0f | 0x40); // set version to 0100
        $data[8] = chr(ord($data[8]) & 0x3f | 0x80); // set bits 6-7 to 10

        return vsprintf('%s%s-%s-%s-%s-%s%s%s', str_split(bin2hex($data), 4));
    }

    public function setIsNewSession(bool $new_session)
    {
        $this->is_new_session =  $new_session;
    }

    public function isNewSession()
    {
        return $this->is_new_session;
    }

    public function setUserInfo(array $user_info) {
        $this->user_id = $user_info['user_id'];
        $this->user_first_name = $user_info['user_first_name'];
        $this->user_last_name = $user_info['user_last_name'];
        $this->profession_title = $user_info['profession_title'];
        $this->user_email = $user_info['user_email'];
        $this->profession_id = $user_info['profession_id'];
        $this->user_createdate = $user_info['user_createdate'];

        // TODO: still need
        $this->uas_user_id = $user_info['uas_user_id'];

    }
}
