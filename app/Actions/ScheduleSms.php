<?php

namespace App\Actions;

use App\Api\SMS\SendSms;

use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Log;


class ScheduleSms
{
    private SendSms $sendSms;

    public function __construct()
    {
        $this->sendSms = new SendSms();
    }

public function __invoke(GetSend $getSend, StoreSmsStatus $storeSmsStatus)
{

    if($getSend() <> false){

        foreach ($getSend()['client'] as $value){

            $return_send = $this->sendSms->send_sms($value->phone, $getSend()['scheduled'][0]->mailing_text);

            $storeSmsStatus([
                'sms_send_id' => $return_send[0],
                'mailing_id' => $getSend()['scheduled'][0]->id,
                'phone_send' => $value->phone,
                'date' => Carbon::now(),
            ]);


        }
    }
    Log::info('invoke');
}

}
