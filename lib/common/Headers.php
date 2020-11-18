<?php

class Headers {
    public static function set() {
        if(isset($_SERVER['HTTP_ORIGIN']) && $http_origin = $_SERVER['HTTP_ORIGIN']) {
            if (in_array(strtolower($http_origin), App::$config['allowed_domains'])) {
                header("Access-Control-Allow-Origin: $http_origin");
                header('Access-Control-Allow-Credentials: true');
                header('Access-Control-Max-Age: 3600');
            }
        }
        if ( $_SERVER['REQUEST_METHOD'] == 'OPTIONS' ) {
            header("Access-Control-Allow-Methods: GET,POST,OPTIONS");
            header("Access-Control-Allow-Headers: DNT,User-Agent,X-Custom-Header,If-Modified-Since,Authorization,Origin,X-Requested-With,Accept,Cache-Control,Content-Type,Range,X-PINGOTHER");
            header("Content-Length:0");
            Response::send(204);
        } else {
            header("Access-Control-Allow-Methods: GET,POST,OPTIONS");
            header("Access-Control-Allow-Headers: User-Agent,X-Custom-Header,Authorization,Origin,X-Requested-With,Accept,X-PINGOTHER,Cache-Control,Content-Type");
            header("Access-Control-Expose-Headers: Content-Length,Content-Range");
        }
        header("Accept-Encoding: compress, gzip");
        header("Content-Type: application/json; charset=UTF-8");
    }
}
