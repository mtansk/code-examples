<?php

/* 
    Реализация PDO-синглтона для работы с БД.

*/

namespace Mtansk\Cp\Helpers\DB;

use PDO;
use Mtansk\Cp\Helpers\Response\Response;

class PDOConnection
{
    private static PDOConnection|null $instance = null;
    private PDO $pdo;

    public function __construct()
    {
        $this->pdo = self::connect();
    }

    public static function getInstance(): PDOConnection
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    public function getConnection(): PDO
    {
        return $this->pdo;
    }

    public static function rollback(): void
    {
        $conn = self::getInstance()->getConnection();
        $conn->rollBack();
    }

    public static function commit(): void
    {
        $pdo = self::getInstance()->getConnection();
        if (!$pdo->inTransaction()) {
            return;
        }
        $res = $pdo->commit();

        if (!$res) {
            $pdo->rollBack();
            $response = new Response();
            $response->code = 500;
            $response->error_code = "DB-TRANSACTION-COMMIT";
            $response->send();
        }
    }

    public static function beginTransaction(): void
    {
        $pdo = self::getInstance()->getConnection();
        if ($pdo->inTransaction()) {
            return;
        }
        $pdo->beginTransaction();
    }

    public static function connect(): PDO
    {
        $dbhost = dbhost;
        $dbport = dbport;
        $dbname = dbname;
        $dbusername = dbusername;
        $dbpassword = dbpassword;

        $conn = new PDO(
            "mysql:host=$dbhost;dbname=$dbname;port=$dbport",
            $dbusername,
            $dbpassword
        );
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        return $conn;
    }
}
