<?php

class Response {
    static private $codes = [
        100 => 'Continue',
        101 => 'Switching Protocols',
        200 => 'OK',
        201 => 'Created',
        202 => 'Accepted',
        203 => 'Non-Authoritative Information',
        204 => 'No Content',
        205 => 'Reset Content',
        206 => 'Partial Content',
        300 => 'Multiple Choices',
        301 => 'Moved Permanently',
        302 => 'Moved Temporarily',
        303 => 'See Other',
        304 => 'Not Modified',
        305 => 'Use Proxy',
        400 => 'Bad Request',
        401 => 'Unauthorized',
        402 => 'Payment Required',
        403 => 'Forbidden',
        404 => 'Not Found',
        405 => 'Method Not Allowed',
        406 => 'Not Acceptable',
        407 => 'Proxy Authentication Required',
        408 => 'Request Time-out',
        409 => 'Conflict',
        410 => 'Gone',
        411 => 'Length Required',
        412 => 'Precondition Failed',
        413 => 'Request Entity Too Large',
        414 => 'Request-URI Too Large',
        415 => 'Unsupported Media Type',
        416 => 'Range Not Satisfiable',
        417 => 'Expectation Failed',
        418 => 'I\'m a teapot',
        419 => 'Authentication Timeout',
        422 => 'Unprocessable Entity',
        425 => 'Too Early',
        426 => 'Upgrade Required',
        428 => 'Precondition Required',
        429 => 'Too Many Requests',
        431 => 'Request Header Fields Too Large', // поля заголовка запроса слишком большие
        440 => 'Login Timeout',
        449 => 'Retry With', // повторить с
        451 => 'Unavailable For Legal Reasons', // недоступно по юридическим причинам
        499 => 'Client Closed Request', // клиент закрыл соединение
        500 => 'Internal Server Error',
        501 => 'Not Implemented',
        502 => 'Bad Gateway',
        503 => 'Service Unavailable',
        504 => 'Gateway Time-out',
        505 => 'HTTP Version not supported',
        511 => 'Network Authentication Required'
    ];

    public static function send($code = 400, $var = []) {
        http_response_code((int)$code);
        $response = ['code' => $code, 'message' => self::$codes[$code]];
        if(!empty($var)) {
            foreach ($var as $k => $v) {
                $response[$k] = $v;
            }
        }
        echo json_encode($response,JSON_UNESCAPED_UNICODE|JSON_HEX_QUOT|JSON_OBJECT_AS_ARRAY);
        exit;
    }
}
