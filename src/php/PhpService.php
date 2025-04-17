<?php

/* 
    Простенький пхп сервис.

*/

namespace Mtansk\Cp\Services\Company;

use Mtansk\Cp\Routes\Router;
use Mtansk\Cp\Helpers\Other\Crypto;
use Mtansk\Cp\Models\Company\AccrualGroupModel;
use Mtansk\Cp\Repositories\Company\AccrualGroupRepository;

class AccrualGroupService
{
    private AccrualGroupRepository $accrualGroupRepository;

    public function __construct(AccrualGroupRepository $accrualGroupRepository)
    {
        $this->accrualGroupRepository = $accrualGroupRepository;
    }

    public function findAll(): array
    {
        return $this->accrualGroupRepository->findAll();
    }

    public function update(string $rate, string $id): array
    {
        $res = $this->accrualGroupRepository->update($rate, $id);
        return [
            "id" => $id,
            "count" => $res
        ];
    }

    public function createFromJson(): array
    {
        $json = Router::getInstance()->json;
        $group = new AccrualGroupModel($json);
        $user = Router::getInstance()->user;

        $id = Crypto::UUID4();

        $rows = [
            /* ... */
        ];

        $res = $this->accrualGroupRepository->create($rows);

        return [
            [
                "id" => $id,
                "count" => $res
            ]
        ];
    }



}