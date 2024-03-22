<?php

namespace App\Actions;

use App\Models\Client;
use Illuminate\Support\Carbon;

class BirthGetClient
{
    private  $crontabs;
    public function __construct($crontabs)
    {
        $this->crontabs = $crontabs;
        $this->SmsSend();
    }

    private function SmsSend(){
        foreach ($this->crontabs as $crontab){

            $birthDay = Carbon::now()->addDays($crontab->message->birth_to_day);

            $client = Client::query()
                ->whereDay('birth',$birthDay->isoFormat('DD'))
                ->whereMonth('birth', $birthDay->isoFormat('MM'))
                ->where('user_id', $crontab->message->user_id)
                ->get();

            if($client->isNotEmpty()){
                $clientRenderToSms = new ClientRenderToSms();
                $clientRenderToSms->render($client, $crontab->message, $crontab->id);
            }
        }
    }
}
