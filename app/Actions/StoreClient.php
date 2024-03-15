<?php

namespace App\Actions;

use App\Models\Client;


class StoreClient
{
    public function __invoke(array $data, int $user_id): void
    {

        Client::query()->updateOrCreate(
            [
                'phone' => $data['phone'],
                'user_id' => $user_id,
            ],
            [
                'clientFullName' => $data['clientFullName'],
                'birth' => $data['birth'],
            ]
        );
    }
}
