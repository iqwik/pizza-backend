<?php

class Orders {
    private static $table = 'orders';

    public static function f_list() {
        $response = ['code' => 404, 'text' => ['error' => 'orders not found']];
        $userId = Auth::get_user_id();

        if ($userId) {
            $table = static::$table;
            $query = "SELECT * FROM `{$table}`";
            $params = [];
            $request = Request::prepare();

            $where = " WHERE ";
            $where_array = [];
            if (
                (isset($request['userId']) && ($id = $request['userId']))
                || (isset($_GET['userId']) && ($id = $_GET['userId']))
                || $userId
            ) {
                $where_array[] = "userId = :userId";
                $params['userId'] = (int)(isset($id) ? $id : $userId);
                $query .= $where . implode(" AND ", $where_array);
            }
            $response = Request::exec([
                'query' => $query,
                'where' => $params,
            ]);
        }
        return $response;
    }

    public static function f_create() {
        $request = Request::prepare();
        $response = ['code' => 400, 'text' => ['error' => 'request method']];
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($request)) {
            $table = self::$table;
            $user = $request['order']['customer'];
            $user_id = null;
            if (!isset($request['userId']) && isset($user['email']) && isset($request['password'])) {
                $user['password'] = $request['password'];
                unset($request['password']);
                if (isset($request['order']['address']) && !empty($request['order']['address'])) {
                    $user['address'] = $request['order']['address'];
                }
                $resp = Request::exec([
                    'type' => 'insert',
                    'query' => 'users',
                    'where' => $user,
                    'code_success' => 201,
                ]);
                if ($resp['code'] == 201 && isset($resp['text']['data']['id']) ) {
                    $user_id = (int)$resp['text']['data']['id'];
                    $request['userId'] = $user_id;
                }
            }
            $response = Request::exec([
                'type' => 'insert',
                'query' => $table,
                'where' => $request,
                'code_success' => 201,
            ]);
            if ($response['code'] == 201 && $user_id !== null) {
                $jwt = Token::create_token($user_id);
                $response['text']['token'] = $jwt;
            }
        }
        return $response;
    }
}
