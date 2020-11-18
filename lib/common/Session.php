<?php

class Session {
    protected static $sessionData = [];
    public static $id = NULL;

    public static function init() {
        Session::begin(false);
        self::$id = session_id();
        self::$sessionData = !empty($_SESSION) ? $_SESSION : [];
        @session_write_close();
    }

    public static function end() {
        self::$sessionData = [];
        $params = session_get_cookie_params();
        $end = false;
        if (Session::begin(false)) {
            session_destroy();
            $end = true;
        }
        setcookie(
            session_name(), "", -1, $params['path'],
            $params['domain'], $params['secure'], $params['httponly']
        );
        return $end;
    }

    public static function get($key = NULL) {
        if ($key === NULL) {
            return self::$sessionData;
        }
        return isset(self::$sessionData[$key]) ? self::$sessionData[$key] : NULL;
    }

    public static function set($values, $oneValue = NULL) {
        if ($oneValue !== NULL && is_string($values)) {
            $values = [ $values => $oneValue ];
        }
        Session::begin();
        self::$id = session_id();
        $_SESSION = $values + $_SESSION;
        self::$sessionData = $_SESSION;
        session_write_close();
    }

    protected static function begin($always = true) {
        $cfg = App::$config;
        $ssn_name = $cfg['session']['name'];
        if (session_name() != $ssn_name) {
            if ($cfg['session']['path']) {
                session_save_path($cfg['session']['path']);
            }
            session_name($ssn_name);
            session_cache_limiter('');
            $cookie = $cfg['cookie'];
            session_set_cookie_params(
                $cookie['expires'], $cookie['path'], $cookie['domain'],
                $cookie['secure'], $cookie['httponly']
            );
        }
        if (isset($_COOKIE[$ssn_name])) {
            return @session_start();
        } elseif ($always) {
            if (@session_start()) {
                $_COOKIE[$ssn_name] = session_id();
                return true;
            }
        }
        return false;
    }
}
