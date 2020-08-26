<?php

namespace datonique\Session;

class Cookie {

    static $COOKIE_SESSION_ID = 'datonique_session';

    private $domain;

    public function __construct(string $domain) {
        $this->$domain = $domain;
    }

    public function getSessionFromCookie() {
        $cookie = json_decode($this->getCookie(Cookie::$COOKIE_SESSION_ID));
        return $cookie->session;
    }

    public function setSessionInCookie(string $session_id, int $session_length) {
        $cookie = array(
            'session' => $session_id,
            'ts' => date("Y-m-d H:i:s")
        );
        $encoded = json_encode($cookie, JSON_UNESCAPED_SLASHES|JSON_UNESCAPED_UNICODE);

        $this->setCookie(Cookie::$COOKIE_SESSION_ID, $encoded, $session_length);
    }

    private function setCookie(string $cookie_name, string $cookie_value, int $cookie_time) {
        if (count($_COOKIE) > 0) {
            setcookie($cookie_name, $cookie_value, $cookie_time, "/", $this->domain);
        }
    }
    private function getCookie(string $cookie_name) {
        return isset($_COOKIE[$cookie_name]) ? $_COOKIE[$cookie_name] : null;
    }
}
