<?php

class Db {
    private static $_instance = null;
    private $db;

    public static function instance() {
        return self::$_instance = self::$_instance == null ? self::$_instance = new Db() : self::$_instance;
    }

    private function __construct() {
        global $config;
        $db = $config['db'];
        $this->Connect($db['username'], $db['password'], $db['name'], $db['host']);
    }

    private function __clone() {}
    private function __wakeup() {}

    public function Connect($username, $password, $base, $host) {
        $this->db = new PDO(
            'mysql:host='.$host.';port=3306;dbname='.$base.';charset=utf8;', $username, $password,
            [PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC, PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
        );
    }

    public function Query($query, $params = []) {
        $res = $this->db->prepare($query);
        $res->execute($params);
        return $res;
    }
    public function Insert($table, $params = []) {
        $data = $this->prepare_keys_values($params);
        $stmt = $this->db->prepare("INSERT INTO `{$table}` SET {$data['keys']}");
        return $stmt->execute($data['values']) ? $this->db->lastInsertId() : $stmt->error;
    }
    public function Select($query, $params = []) {
        return ($result = $this->Query($query, $params)) ? $result->fetchAll() : false;
    }
    public function Update($table, $params = [], $where = ['id', null]) {
        $data = $this->prepare_keys_values($params);
        list($key, $val) = $where;
        $data['values'][$key] = $val;
        $stmt = $this->db->prepare("UPDATE `{$table}` SET {$data['keys']} WHERE `{$key}` = :{$val}");
//        foreach ($data['values'] as $k => &$v) {
//            $stmt->bindParam(":$k", $v);
//        }
//        $stmt->bindParam(":{$where[0]}", $where[1]);
        return $stmt->execute($data['values']) ? true : false;
    }
    public function SelectRow($query, $params = []) {
        return ($result = $this->Query($query, $params)) ? $result->fetchColumn() : false;
    }

    private function prepare_keys_values($array) {
        $fields = [];
        $values = [];
        foreach ($array as $key => $value) {
            $fields[] = "`$key` = :$key";
            $v = is_array($value)
                ? json_encode($value, JSON_UNESCAPED_UNICODE|JSON_UNESCAPED_SLASHES|JSON_HEX_QUOT)
                : htmlspecialchars(strip_tags($value));
            $values[$key] = $key == 'password' ? password_hash($v, PASSWORD_BCRYPT) : $v;
        }
        $keys = join(", ", $fields);
        return ['keys' => $keys, 'values' => $values];
    }
}
