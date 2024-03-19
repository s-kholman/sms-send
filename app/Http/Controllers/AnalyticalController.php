<?php

namespace App\Http\Controllers;

use App\Jobs\GetSmsStatus;
use App\Models\Mailing;
use App\Models\SmsStatusSend;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;

class AnalyticalController extends Controller
{
    public function index(Request $request)
    {
        if (!empty($request->between)) {
            $between = $request->between;
        } else {
            $between = Carbon::now()->subDays(1)->format('Y-m-d');
        }


        $maililngs = SmsStatusSend::query()
            ->where('user_id', Auth::user()->id)
            ->whereBetween('date', [$between, Carbon::now()->format('Y-m-d')])
            ->with('Mailing')
            ->get()
        ;

        if ($maililngs->isNotEmpty()) {

            foreach ($maililngs->groupBy('Mailing.id') as $key => $mailing) {

                $sms_status_code = $mailing->groupBy('sms_status_code')->toArray();

                if (array_key_exists(1, $sms_status_code)) {

                    $report [$key] = ['all' => $mailing->count(), 'yes' => count($sms_status_code[1])];

                } else {
                    $report [$key] = ['all' => $mailing->count(), 'yes' => 0];
                }
            }
        } else {
            return view('analytical.index', ['mailing' => []]);
        }

        return view('analytical.index', ['mailing' => $report]);
    }

}
