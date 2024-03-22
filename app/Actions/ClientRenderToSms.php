<?php

namespace App\Actions;

use App\Api\SMS\SendSms;
use App\Http\Controllers\SmsStatusController;
use App\Http\Controllers\SmsStatusSendController;
use App\Models\Message;
use Illuminate\Support\Str;

class ClientRenderToSms
{
    private SendSms $sendSms;

    public function __construct()
    {
        $this->sendSms = new SendSms('');
    }

    public function render($clients, Message $message, $crontab_id = null)
    {

        $sms_phone = '';

        $sms_send_id = Str::uuid();

        foreach ($clients as $client) {

            $sms_phone .= $client->phone . ';';

        }

        $this->sendSms->setUserID($message->user_id);

        $this->sendSms->send_sms($sms_phone, $message->text, 0, 0, $sms_send_id);

        $storeSmsStatus = new SmsStatusController();
        $storeSmsStatus->store($sms_phone, $message,$sms_send_id, $crontab_id);
    }

}
