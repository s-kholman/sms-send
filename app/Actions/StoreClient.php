<?php

namespace App\Actions;

use App\Models\Client;
use Illuminate\Support\Facades\Auth;

class StoreClient
{
    public function __invoke(array $data): void
    {
        Client::query()->updateOrCreate(
            [
                'phone' => $data['phone'],
                'user_id' => Auth::user()->id,
            ],
            [
                'clientFullName' => $data['clientFullName'],
                'birth' => $data['birth'],
            ]
        );
    }
}
