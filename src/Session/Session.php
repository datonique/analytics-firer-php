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

    static $COOKIE_SESSION_ID = 'datonique_session_id';
    /**
     * Constructor
     *
     * @param string                $button_name
     */
    public function __construct(Cookie $cookie)
    {
        $this->cookie = $cookie;
        $this->session_id = $cookie->getCookie(Session::$COOKIE_SESSION_ID);
        if (is_null($this->session_id)) {
            $this->session_id = $this->getGuidV4();
            $this->cookie->setCookie(Session::$COOKIE_SESSION_ID, $this->session_id);
        }
        $browser = new Browser();
        $client_info = $browser->browser_detection('full_assoc');
        $this->os = $client_info['os'];
        $this->os_version = $client_info['os_number'];
        $this->browser = $client_info['browser_name'];
        $this->browser_version = $client_info['browser_number'];
        
        if ($client_info['ua_type'] == 'mobile') {
            $this->web_or_mobile = 'mobile';
        } else if ($client_info['ua_type'] == 'bro' || $client_info['ua_type'] == 'bbro' ) {
            $this->web_or_mobile = 'web';
        } else {
            $this->web_or_mobile = 'other';
        }
    }

    public function toOutArray()
    {
        return array(
            'session_id' => $this->session_id,
            'os' => $this->os,
            'os_version' => $this->os_version,
            'browser' => $this->browser,
            'broweser_version' => $this->browser_version,
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

    private function getOS() { 
        
        if (is_null($this->user_agent)) {
            throw new Exception("no user agent to get OS");
        }
        
        $os_platform    =   "Unknown OS Platform";

        $os_array       =   array(
                                '/windows nt 10.0/i'    =>  'Windows 10',
                                '/windows nt 6.2/i'     =>  'Windows 8',
                                '/windows nt 6.1/i'     =>  'Windows 7',
                                '/windows nt 6.0/i'     =>  'Windows Vista',
                                '/windows nt 5.2/i'     =>  'Windows Server 2003/XP x64',
                                '/windows nt 5.1/i'     =>  'Windows XP',
                                '/windows xp/i'         =>  'Windows XP',
                                '/windows nt 5.0/i'     =>  'Windows 2000',
                                '/windows me/i'         =>  'Windows ME',
                                '/win98/i'              =>  'Windows 98',
                                '/win95/i'              =>  'Windows 95',
                                '/win16/i'              =>  'Windows 3.11',
                                '/macintosh|mac os x/i' =>  'Mac OS X',
                                '/mac_powerpc/i'        =>  'Mac OS 9',
                                '/linux/i'              =>  'Linux',
                                '/ubuntu/i'             =>  'Ubuntu',
                                '/iphone/i'             =>  'iPhone',
                                '/ipod/i'               =>  'iPod',
                                '/ipad/i'               =>  'iPad',
                                '/android/i'            =>  'Android',
                                '/blackberry/i'         =>  'BlackBerry',
                                '/webos/i'              =>  'Mobile'
                            );

        foreach ($os_array as $regex => $value) { 
            if (preg_match($regex, $this->user_agent)) {
                $os_platform    =   $value;
            }
        }   

        return $os_platform;
    }

    private function getBrowser() {
        if (is_null($this->user_agent)) {
            throw new Exception("no user agent to get browser");
        }
        $browser        =   "Unknown Browser";

        $browser_array  =   array(
                                '/msie/i'       =>  'Internet Explorer',
                                '/firefox/i'    =>  'Firefox',
                                '/safari/i'     =>  'Safari',
                                '/chrome/i'     =>  'Chrome',
                                '/opera/i'      =>  'Opera',
                                '/netscape/i'   =>  'Netscape',
                                '/maxthon/i'    =>  'Maxthon',
                                '/konqueror/i'  =>  'Konqueror',
                                '/mobile/i'     =>  'Handheld Browser'
                            );

        foreach ($browser_array as $regex => $value) { 
            if (preg_match($regex, $this->user_agent)) {
                $browser    =   $value;
            }
        }

        return $browser;
    }
}
