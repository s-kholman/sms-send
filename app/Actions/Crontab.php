<?php

namespace App\Actions;

class Crontab
{
    /**
     * @return void
     * Запрос по дате и времени задания на выполнения
     * Подгружаются отношения message
     * Группируем по типу отправки
     * Отправляем в парсер
     */

    public function __invoke()
    {
        $run_date = \App\Models\Crontab::query()
            ->whereDate('run_date', date('Y-m-d'))
            ->whereTime('run_date',  date('H:i:00'))
            ->where('status', true)
            ->with('Message')
            ->get()
            ->groupBy('Message.type')
        ;

        if($run_date->isNotEmpty()){
            new MessageParser($run_date);
        }
    }
}
