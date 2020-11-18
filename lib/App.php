<?php

class App {
    public static $config;

    public static function run() {
        self::set_config();
        Headers::set();
        self::api_dispatcher();
    }

    private static function set_config() {
        global $config;
        self::$config = $config;
    }

    private static function api_dispatcher() {
        $r = isset($_GET['r']) && !empty($_GET['r']) ? urldecode($_GET['r']) : '';
        self::call_api_method($r);
    }

    private static function call_api_method($api) {
        if (empty($api)) {
            Response::send(404, [ 'API' => 'Unknown' ]);
        }

        if (strpos($_GET['r'], '.')) {
            list($api, $method) = explode('.', $_GET['r'], 2);
        }

        $api = ucfirst(strtolower($api));
        $method = !empty($method) ? "f_{$method}" : "Empty";

        $result = method_exists($api, $method)
            ? $api::$method()
            : [
            	'code' => 405,
				'text' => ['method' => str_replace('f_','',$method)]
			];

        Response::send($result['code'], $result['text']);
    }
}
