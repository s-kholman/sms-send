<?php

namespace App\Actions;

use App\Http\Controllers\CrontabController;

class MessageParser
{
    private $crontab;

    public function __construct($crontab)
    {
        $this->crontab = $crontab;
        $this->parser();
    }

    private function parser()
    {
        foreach ($this->crontab as $message_type => $crontab){
            if($message_type == 1){
                new BirthGetClient($crontab);
            }
            $crontabUpdate = new CrontabController();
            $crontabUpdate->update($crontab);
        }
    }
}
