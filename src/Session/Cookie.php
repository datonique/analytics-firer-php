<?php

namespace datonique\Session;

class Cookie {
    public function setCookie(string $cookie_name, string $cookie_value, int $cookie_time) {
        setcookie($cookie_name, $cookie_value, $cookie_time);
    }
    public function getCookie(string $cookie_name) {
        return isset($_COOKIE[$cookie_name]) ? $_COOKIE[$cookie_name] : null;
    }
}
