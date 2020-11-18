<?php
$path = App::$config['root'].'/lib/vendor/php-jwt/';
require_once $path.'BeforeValidException.php';
require_once $path.'ExpiredException.php';
require_once $path.'SignatureInvalidException.php';
require_once $path.'JWT.php';
use \Firebase\JWT\JWT;

class Token {

    public static function jwt_encode($payload) {
        $payload['iss'] = App::$config['jwt']['iss'];
        return JWT::encode($payload, App::$config['jwt']['key']);
    }

    public static function jwt_decode($jwt) {
        try {
            JWT::$leeway = App::$config['jwt']['leeway'];
            $decoded = JWT::decode($jwt, App::$config['jwt']['key'], ['HS256']);
            return $decoded->userId;
        } catch (Exception $e) {
            Response::send(500, ['error' => $e->getMessage()]);
        }
    }

    public static function create_token($userId) {
        $jwt = self::jwt_encode(['userId' => $userId]);
        Session::set([App::$config['session']['name'] => $jwt, 'ua' => $_SERVER['HTTP_USER_AGENT']]);
        return $jwt;
    }

    public static function get_from_session() {
        Session::init();
        $token = Session::get(App::$config['session']['name']);
        $ua = Session::get('ua');
        return ($_SERVER['HTTP_USER_AGENT'] === $ua) ? $token : null;
    }
}
