<?php

namespace App\Actions;

use App\Api\SMS\SendSms;

use Illuminate\Support\Carbon;
use Illuminate\Support\Str;


class ScheduleSms
{
    private SendSms $sendSms;
    private GetSend $getSend;
    private StoreSmsStatus $storeSmsStatus;
    private $sms_phone = '';

    public function __construct()
    {
        $this->sendSms = new SendSms('');
        $this->getSend = new GetSend();
        $this->storeSmsStatus = new StoreSmsStatus();
    }

    public function __invoke()
    {
        $get_send = $this->getSend->get();

        if ($get_send <> false) {

            foreach ($get_send as $value) {
                $this->sms_phone = '';
                $sms_send_id = Str::uuid();
                foreach ($value['client'] as $client) {

                    //Создание строки под отправку
                    $this->sms_phone .= $client->phone . ';';

                }

                $this->sendSms->setUserID($value['scheduled']->user_id);

                $this->sendSms->send_sms($this->sms_phone, $value['scheduled']->mailing_text,0,0,$sms_send_id);

                if ($this->sms_phone <> ''){
                    $this->storeSmsStatus->store([
                        'sms_send_id' => $sms_send_id,
                        'mailing_id' => $value['scheduled']->id,
                        'phone_send' => rtrim($this->sms_phone, ';'),
                        'date' => Carbon::now(),
                        'user_id' => $value['scheduled']->user_id,

                    ]);
                }
            }
        }
    }

}
