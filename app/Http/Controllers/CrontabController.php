<?php

namespace App\Http\Controllers;

use App\Models\Crontab;
use Illuminate\Http\Request;

class CrontabController extends Controller
{
    public function update($crontabs){
        foreach ($crontabs as $crontab){
            Crontab::query()
                ->where('id', $crontab->id)
                ->update(
                    [
                        'status' => false,
                    ]
                );
            Crontab::query()
                ->create(
                    [
                        'run_date' => date('Y-m-d H:i:00', strtotime($crontab->message->crontab)),
                        'status' => true,
                        'message_id' => $crontab->message->id,
                    ]
                );
        }
    }
}
