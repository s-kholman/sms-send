<?php

namespace App\Actions;

use App\Models\Client;

class StoreClient
{
    public function __invoke(array $data): void
    {
        Client::query()->create(
            [
                'clientFullName' => $data['clientFullName'],
                'phone' => $data['phone'],
                'birth' => date('Y-m-d', strtotime($data['birth']))
            ]
        );
    }
}
