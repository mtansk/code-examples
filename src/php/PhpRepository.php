<?php

/* 
    Обычный пхп репозиторий для работы с транзакциями.
    SQL-выражения убраны.

*/

namespace Mtansk\Cp\Repositories\Transaction;

use Mtansk\Cp\Routes\Router;
use Mtansk\Cp\Helpers\DB\GETQueryNew;
use Mtansk\Cp\Helpers\DB\POSTQueryNew;

class TransactionRepository
{
    public function __construct()
    {
    }

    public function findPending(): array
    {
        $user = Router::getInstance()->user;
        $sql = "SQL...";

        $bindings = [
            ":company_id" => $user["company_id"],
        ];

        $get = new GETQueryNew($sql, $bindings);
        $data = $get->execute();

        return $data;
    }

    public function find(string $transactionId): array|null
    {
        $user = Router::getInstance()->user;
        $sql = "SQL...";

        $bindings = [
            ":transaction_id" => $transactionId,
            ":company_id" => $user["company_id"],
        ];

        $get = new GETQueryNew($sql, $bindings);
        $data = $get->execute();

        return $data[0] ?? null;
    }

    public function store(array $rows): int
    {
        $sql = "SQL...";

        $post = new POSTQueryNew($sql);
        $res = $post->executeWithRows($rows);
        return $res;
    }
}