<?php

namespace App\Http\Controllers;

use App\Http\Requests\AnalyticalRequest;
use App\Models\Crontab;
use App\Models\Message;
use App\Models\SmsStatus;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;

class AnalyticalController extends Controller
{
    public function index(AnalyticalRequest $request)
    {
        if (!empty($request->between)) {
            $between = Carbon::parse($request->between)->format('Y-m-d 00:00:00');
        } else {
            $between = Carbon::now()->format('Y-m-d 00:00:00');
        }

        if (!empty($request->type)) {
            $end_date = Carbon::parse($request->date)->format('Y-m-d 23:59:59');
        } else {
            $end_date = Carbon::now()->format('Y-m-d 23:59:59');
        }

        $crontabs = Crontab::query()
            ->where('status', false)
            ->whereBetween('run_date', [$between, $end_date])
            ->with('Message')
            ->whereHas('Message', function ($query) {
                return $query->where('user_id', Auth::user()->id);
            })
            ->get()
            ->groupBy('message_id');

        foreach ($crontabs as $message_id => $crontab) {

            $count = SmsStatus::query()
                ->whereHas('Crontab', function ($query) use ($between, $message_id, $end_date) {
                    return $query->whereBetween('run_date', [$between, $end_date]);
                })
                ->where('message_id', $message_id)
                ->where('user_id', Auth::user()->id)
                ->count();

            $send = SmsStatus::query()
                ->whereHas('Crontab', function ($query) use ($between, $message_id, $end_date) {
                    return $query->whereBetween('run_date', [$between, $end_date]);
                })
                ->where('message_id', $message_id)
                ->where('status_code', 1)
                ->where('user_id', Auth::user()->id)
                ->count();

            $cron = Crontab::query()
                ->where('message_id', $message_id)
                ->latest('run_date')
                ->first();

            $analytical [$message_id] = [
                'name' => $crontab[0]->Message->name,
                'count' => $count,
                'send' => $send,
                'cron' => $cron,

            ];
        }
        //dd($analytical);
        if (!empty($analytical)) {
            return view('analytical.index', ['analytical' => $analytical, 'end_date' => $end_date, 'between' => $between]);
        } else {
            $message = Message::query()
                ->where('user_id', Auth::user()->id)
                ->get();
            if ($message->isNotEmpty()) {
                foreach ($message as $value) {
                    $cron = Crontab::query()
                        ->where('message_id', $value->id)
                        ->latest('run_date')
                        ->first();
                    $analytical [$value->id] = [
                        'name' => $value->name,
                        'cron' => $cron,
                    ];
                }
                return view('analytical.index', ['analytical' => $analytical, 'end_date' => $end_date, 'between' => $between]);
            } else{
                return view('analytical.index', ['analytical' => [], 'end_date' => $end_date, 'between' => $between]);
            }


        }


    }

}
