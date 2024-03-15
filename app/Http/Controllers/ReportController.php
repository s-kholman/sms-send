<?php

namespace App\Http\Controllers;

use App\Api\SMS\SmsGetStatus;
use App\Jobs\GetSmsStatus;
use App\Models\SmsStatusSend;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use Illuminate\Support\Facades\RateLimiter;

class ReportController extends Controller
{



    public function __construct()
    {

    }

    public function index()
    {
        return view('report.index', ['result' => 0, 'sum' => 0, 'post' => 0]);
    }

    public function find(Request $request)
    {

        /**
         * Делаем запрос на статус СМС с сайта
         * Размещаем его в очереди
         * Лимитируем 1 запрос на сайт не чаще 25 секунд (на сайте не более 3х запросов в минуту)
         * Пользователь по факту получает данные из собственной БД
        */

        RateLimiter::attempt('get_status_sms', 1, function () use ($request) {
            dispatch(new GetSmsStatus($request->date, Auth::user()->id));
            return null;
        }, 25);


        $mailing = SmsStatusSend::query()
            ->whereDate('date', $request->date)
            ->where('user_id', Auth::user()->id)
            ->get();

        if ($mailing->isNotEmpty()) {
            foreach ($mailing->groupBy('mailing_id') as $key => $value) {

                $sms_status_code = $value->groupBy('sms_status_code')->toArray();

                if (array_key_exists(1, $sms_status_code)) {

                    $report [$key] = ['all' => $value->count(), 'yes' => count($sms_status_code[1])];

                } else {
                    $report [$key] = ['all' => $value->count(), 'yes' => 0];
                }
            }
        } else {
            return view('report.index', ['result' => [], 'post' => 0]);
        }

        return view('report.index', ['result' => $report, 'post' => 1]);

    }
}

