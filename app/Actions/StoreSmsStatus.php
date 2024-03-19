<?php

namespace App\Actions;

use App\Jobs\GetSmsStatus;
use App\Models\SmsStatusSend;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;

class StoreSmsStatus
{
    public function store(array $array)
    {

        $phone_send = explode(';', $array['phone_send']);
       // $sms_send_id = explode(',', $array['sms_send_id']);

        for ($i = 0; count($phone_send) > $i; $i++){

            SmsStatusSend::query()
                ->create([
                    'mailing_id' => $array['mailing_id'],
                    'sms_send_id' => $array['sms_send_id'],
                    'phone_send' => $phone_send[$i],
                    'date' => $array['date'],
                    'user_id' => $array['user_id'],
                ]);
        }
    }

}
