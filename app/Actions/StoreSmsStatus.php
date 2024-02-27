<?php

namespace App\Actions;

use App\Models\SmsStatusSend;

class StoreSmsStatus
{
    public function __invoke(array $array)
    {
        SmsStatusSend::query()
            ->create([
                'mailing_id' => $array['mailing_id'],
                'sms_send_id' => $array['sms_send_id'],
                'phone_send' => $array['phone_send'],
                'date' => $array['date'],
            ]);
    }

}
