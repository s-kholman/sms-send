<?php

namespace App\Http\Controllers;

use App\Api\SMS\SmsGetStatus;
use App\Jobs\GetSmsStatus;
use App\Models\SmsStatusSend;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use Illuminate\Support\Facades\RateLimiter;

class ReportController extends Controller
{



    public function __construct()
    {

    }

    public function index(Request $request)
    {
        if(empty($request->date)){
            $date = Carbon::now();
        } else {
            $date = $request->date;
        }

        $mailing = SmsStatusSend::query()
            ->whereDate('date', $date)
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
            return view('report.index', ['result' => [], 'post' => 0, 'date' => $date]);
        }

        return view('report.index', ['result' => $report, 'post' => 1, 'date' => $date]);
    }
}

