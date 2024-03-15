<?php

namespace App\Actions;

use App\Api\SMS\SendSms;
use App\Models\Client;
use Illuminate\Support\Str;

class ImmediateDispatch
{
    private SendSms $sendSms;
    //private GetSend $getSend;
    private StoreSmsStatus $storeSmsStatus;
    private $sms_phone = '';

    public function __construct()
    {
        $this->sendSms = new SendSms('');
        //$this->getSend = new GetSend();
        $this->storeSmsStatus = new StoreSmsStatus();
    }

    public function __invoke($mailing)
    {
        $get_send = Client::query()->where('user_id', $mailing->user_id)->get();

        if ($get_send->isNotEmpty()) {
            $this->sms_phone = '';
            $sms_send_id = Str::uuid();
            foreach ($get_send as $value) {


                //Создание строки под отправку
                $this->sms_phone .= $value->phone . ';';

            }

            // $this->sendSms->setUserID($value['scheduled']->user_id);

            $this->sendSms->send_sms($this->sms_phone, $mailing->mailing_text,0,0,$sms_send_id);

            if ($this->sms_phone <> '') {
                $this->storeSmsStatus->store([
                    'sms_send_id' => $sms_send_id,
                    'mailing_id' => $mailing->id,
                    'phone_send' => rtrim($this->sms_phone, ';'),
                    'date' => $mailing->mailing_immediate_dispatch,
                    'user_id' => $mailing->user_id,

                ]);
            }


        }

    }

}
