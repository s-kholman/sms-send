<?php

namespace App\Actions;

use App\Jobs\SmsGetStatusJob;
use App\Models\SmsStatus;
use App\Models\SmsStatusSend;

class SmsGetStatus
{
    public function __invoke()
    {

        $smsStatusCheck = SmsStatus::query()
            ->where('status_code', '=', null)
            ->orWhere('status_code', '=', 0)
            ->orWhere('status_code', '=', -3)
            ->with('smscIntegration')
            ->get()
            ->groupBy('user_id');


        foreach ($smsStatusCheck as $value) {
            $phone = '';
            $send_id = '';
            foreach ($value as $key => $item) {
                if ($item->smscIntegration === null) {
                    break;
                }

                $phone .= $item->phone . ',';
                $send_id .= $item->sms_uuid . ',';

                if ($key === array_key_last($value->toArray())) {
                    $getStatus = [
                        'phone' => $phone,
                        'sms_send_id' => $send_id,
                        'login' => $item->smscIntegration->login,
                        'password' => $item->smscIntegration->password,
                    ];
                    //dump($getStatus);
                    dispatch(new SmsGetStatusJob($getStatus));
                }

            }
        }
    }
}
