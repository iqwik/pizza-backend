<?php

class Auth {
    public static function get_user_id() {
        if (isset($_SERVER['HTTP_BEARER'])) {
            $userId = Token::jwt_decode($_SERVER['HTTP_BEARER']);
        } else {
            Session::init();
            $token = Session::get(App::$config['session']['name']);
            $ua = Session::get('ua');
            $userId = ($_SERVER['HTTP_USER_AGENT'] === $ua) ? Token::jwt_decode($token) : null;
        }
        return $userId;
    }

    public static function f_login() {
        $request = Request::prepare();
        $response = ['code' => 400, 'text' => ['error' => 'request method']];
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($request)) {
            $email = htmlspecialchars(strip_tags($request['email']));
            $password = htmlspecialchars(strip_tags($request['password']));
            $response = Request::exec([
                'query' => "SELECT * FROM users WHERE email = :email LIMIT 1",
                'where' => ['email' => $email],
            ]);
            if ($response['code'] == 200 && (
                    ($user = $response['text']['data'][0])
                    && isset($user['password']) && password_verify($password, $user['password'])
                )) {
                $jwt = Token::create_token($user['id']);
                unset($response['text']['data']);
                $response['text']['token'] = $jwt;
            }
        }
        return $response;
    }

    public static function f_logout() {
        return [
            'code' => Session::end() ? 200 : 401,
            'text' => null
        ];
    }

    public static function f_check() {
        return ($token = Token::get_from_session())
            ? ['code' => 200, 'text' => ["message" => "Authorized", "token" => $token]]
            : ['code' => 200 , 'text' => ["message" => "Unauthorized"]];
    }
}
