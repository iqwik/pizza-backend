<?php

class Users {
    private static $table = 'users';

    public static function f_list() {
        $response = ['code' => 400, 'text' => ['error' => 'error request']];
        $userId = Auth::get_user_id();

        // TODO - add admin role and fix rules
        if ($userId) {
            $table = static::$table;
            $query = "SELECT * FROM `{$table}`";
            $params = [];
            $request = Request::prepare();

            $where = " WHERE ";
            $where_array = [];
            if ((isset($request['id']) && ($id = $request['id'])) || (isset($_GET['id']) && ($id = $_GET['id'])) || $userId) {
                $where_array[] = "id = :id";
                $params['id'] = (int)(isset($id) ? $id : $userId);
            }
            if ((isset($request['name']) && ($name = $request['name'])) || (isset($_GET['name']) && ($name = $_GET['name']))) {
                $where_array[] = "name = :name";
                $params['name'] = urldecode($name);
            }
            if ((isset($request['email']) && ($email = $request['email'])) || (isset($_GET['email']) && ($email = $_GET['email']))) {
                $where_array[] = "email = :email";
                $params['email'] = urldecode($email);
            }
            $query .= $where . implode(" AND ", $where_array);

            $response = Request::exec(['query' => $query, 'where' => $params]);
            if ($response['code'] == 200 && !empty($response['text']['data'])) {
                foreach ($response['text']['data'] as $k => $user) {
                    unset($response['text']['data'][$k]['password']);
                }
            }
        }
        return $response;
    }

    public static function f_create() {
        $request = Request::prepare();
        $response = ['code' => 400, 'text' => ['error' => 'request method']];
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($request)) {
            $table = self::$table;
            $response = Request::exec([
                'type' => 'insert',
                'query' => $table,
                'where' => $request,
                'code_success' => 201,
            ]);
            if ($response['code'] == 201) {
                $userId = $response['text']['data']['id'];
                $response['text']['token'] = Token::create_token($userId);
            }
        }
        return $response;
    }
    // not available at this moment - must add roles and rules before
    /*
    public static function f_edit() {
        $userId = Auth::get_user_id();
        $request = Request::prepare();
        $response = ['code' => 400, 'text' => ['error' => 'request method']];
        if ($_SERVER['REQUEST_METHOD'] === 'PUT' && !empty($request) && isset($request['id']) && $userId) {
            $table = self::$table;
            if (($id = (int)$request['id']) && !empty($id)) {
                $params = [];
                foreach ($request as $k => $v) {
                    if ($k != 'id') {
						$params[$k] = $v;
					}
                }
                $response = Request::exec([
                    'type' => 'update',
                    'query' => $table,
                    'where' => $params,
                    'additional' => ['id', $id],
                ]);
            } else {
                $response['text']['error'] = 'the request doesn\'t have ID';
            }
        }
        return $response;
    }

    public static function f_delete() {
        $userId = Auth::get_user_id();
        $request = Request::prepare();
        $response = ['code' => 400, 'text' => ['error' => 'request method']];
        if ($_SERVER['REQUEST_METHOD'] === 'DELETE' && !empty($request) && isset($request['id']) && $userId) {
            $table = self::$table;
            if (($id = (int)$request['id']) && !empty($id)) {
                $query = "DELETE FROM {$table} WHERE id = :id";
                $response = Request::exec([
                    'type' => 'delete',
                    'query' => $query,
                    'where' => ['id', $id],
                ]);
            } else {
                $response['text']['error'] = 'the request doesn\'t have ID';
            }
        }
        return $response;
    }
    */
}
