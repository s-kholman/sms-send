<?php

namespace App\Actions;

use App\Models\Client;
use App\Models\Mailing;
use Illuminate\Support\Carbon;

class GetSend
{
    private $user_id;

    public function get()
    {

       $scheduled = $this->scheduled();

        if($scheduled->isNotEmpty()){

            foreach ($scheduled as $value){

                $this->user_id = $scheduled[0]->user_id;

                $return [] = ['client' => $this->clients($value->mailing_to_day), 'scheduled' => $value];

            }
            return $return;
        } else{
            return false;
        }
    }

    private function scheduled()
    {
        /**
         * Получаем все задания на рассылку, где сходится время
         */
        return collect(Mailing::query()
            ->where('mailing_send_birth', now()->format('H:i'.':00'))
            ->get());
    }

    private function clients($mailing_to_day = 0)
    {
        $birthDay = Carbon::now()->addDays($mailing_to_day);

        return Client::query()
            ->whereDay('birth',$birthDay->isoFormat('DD'))
            ->whereMonth('birth', $birthDay->isoFormat('MM'))
            ->where('user_id', $this->user_id)
            ->get();
    }
}
