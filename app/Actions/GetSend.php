<?php

namespace App\Actions;

use App\Models\Client;
use App\Models\Mailing;
use Illuminate\Support\Carbon;

class GetSend
{
    public function __invoke()
    {

       $scheduled = $this->scheduled();
        if($scheduled->isNotEmpty()){
            return ['client' => $this->clients($scheduled[0]->mailing_to_day), 'scheduled' => $scheduled];
        } else{
            return false;
        }
    }

    private function scheduled()
    {
        return collect(Mailing::query()
            ->where('mailing_send_time', now()->format('H:i'.':00'))
            ->limit(1)
            ->get());
    }

    private function clients($mailing_frequency = 0)
    {
        $birthDay = Carbon::now()->addDays($mailing_frequency);

        return Client::query()
            ->whereDay('birth',$birthDay->isoFormat('DD'))
            ->whereMonth('birth', $birthDay->isoFormat('MM'))
            ->get();
    }
}
