<?php
/* 
    Php класс для работы с ответами API

*/

namespace Mtansk\Cp\Helpers\Response;

use Mtansk\Cp\Helpers\DB\PDOConnection;

class Response
{
    public int $code = 200;
    public string $message = "";
    public string $error_code = "";
    public array $data = [];

    public function __construct()
    {
    }

    public function send(): never
    {
        $pdo = PDOConnection::getInstance()->getConnection();
        if ($pdo->inTransaction()) {
            $pdo->rollBack();
        }

        $this->data =
            is_array($this->data) && array_is_list($this->data)
            ? $this->data : [$this->data];


        header("Content-Type: application/json");
        http_response_code($this->code);
        $arrayOfThis = [
            "code" => $this->code,
            "message" => $this->message,
            "error_code" => $this->error_code,
            "data" => $this->data
        ];
        echo json_encode($arrayOfThis);
        exit();
    }

    public static function stop(): never
    {
        $response = new Response();
        $response->code = 500;
        $response->error_code = "STOP";
        $response->send();
    }
}

