<?php

class Request {
    public static function prepare() {
        return json_decode(file_get_contents('php://input'), true);
    }

    public static function exec($q = ['query' => null]) {
        $query = $q['query'];
        $where = isset($q['where']) ? $q['where'] : [];
        $code_success = isset($q['code_success']) ? $q['code_success'] : 200;
        $code_error = isset($q['code_error']) ? $q['code_error'] : 400;
        try {
            if (isset($q['type'])) {
                $type = $q['type'];
                if ($type == 'insert') {
                    $insertedId = Db::instance()->Insert($query, $where);
                    $res = ['id' => $insertedId];
                } elseif ($type == 'update' && isset($q['additional'])) {
                    $res = Db::instance()->Update($query, $where, $q['additional']);
                } elseif ($type == 'delete') {
                    $res = Db::instance()->Query($query, $where);
                }
            } else {
                $res = Db::instance()->Select($query, $where);
            }
            $response = [
                'code' => $code_success,
                'text' => ['data' => $res]
            ];
            if (isset($q['data'])) {
                $response['text']['data'] = $q['data'];
            }
        } catch (Exception $e) {
            $response = [
                'code' => $code_error,
                'text' => ['error' => $e->getMessage()]
            ];
        }
        return $response;
    }
}
