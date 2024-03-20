<?php

namespace App\Actions;

use App\Jobs\SmsGetStatusJob;
use App\Models\SmsStatusSend;

class SmsGetStatusSchedule
{
    public function __invoke()
    {

        $smsStatusCheck = SmsStatusSend::query()
            ->where('sms_status_code', '=', null)
            ->orWhere('sms_status_code', '=', 0)
            ->orWhere('sms_status_code', '=', -3)
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

                $phone .= $item->phone_send . ',';
                $send_id .= $item->sms_send_id . ',';

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
