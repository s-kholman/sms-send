<?php

namespace App\Http\Controllers;

use App\Models\SmsStatusSend;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AnalyticalController extends Controller
{
    public function index()
    {
        $maililngs = SmsStatusSend::query()->where('user_id', Auth::user()->id)->get();

        if ($maililngs->isNotEmpty()){

            foreach ($maililngs->groupBy('mailing_id')  as $key => $mailing){

                $sms_status_code = $mailing->groupBy('sms_status_code')->toArray();

                if (array_key_exists(1, $sms_status_code)) {

                    $report [$key] = ['all' => $mailing->count(), 'yes' => count($sms_status_code[1])];

                } else {
                    $report [$key] = ['all' => $mailing->count(), 'yes' => 0];
                }
            }
        } else{
            return view('analytical.index', ['mailing' => []]);
        }

        return view('analytical.index', ['mailing' => $report]);
    }

}
