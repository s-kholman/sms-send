<?php

namespace App\Actions;

use App\Models\Client;


class StoreClient
{
    public function __invoke(array $data, int $user_id, int $department_id): void
    {
//dd($department_id);
        Client::query()->updateOrCreate(
            [
                'phone' => $data['phone'],
                'user_id' => $user_id,
            ],
            [
                'clientFullName' => $data['clientFullName'],
                'birth' => $data['birth'],
                'department_id' => $department_id
            ]
        );
    }
}
