<?php

namespace App\Http\Controllers;

use App\Models\SmsStatus;
use Illuminate\Http\Request;

class SmsStatusController extends Controller
{
    public function store($client, $message, $uuid, $crontab_id = null)
    {

        if ($client <> '') {
            $phones = explode(';', rtrim($client, ';'));
            foreach ($phones as $phone) {
                SmsStatus::query()
                    ->create(
                        [
                            'message_id' => $message->id,
                            'sms_uuid' => $uuid,
                            'phone' => $phone,
                            'date' => now(),
                            'user_id' => $message->user_id,
                            'status_code' => null,
                            'crontab_id' => $crontab_id
                        ]
                    );
            }
        }
    }
}
