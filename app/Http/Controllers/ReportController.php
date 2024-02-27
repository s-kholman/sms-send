<?php

namespace App\Http\Controllers;

use App\Api\SMS\SmsGetStatus;
use App\Models\SmsStatusSend;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    private SmsGetStatus $smsGetStatus;

    public function __construct()
    {
        $this->smsGetStatus = new SmsGetStatus();
    }

    public function index()
    {
        return view('report.index', ['result' =>  0, 'sum' => 0, 'post' => 0]);
    }

    public function find(Request $request)
    {

        $report = SmsStatusSend::query()
        ->whereDate('date', $request->date)
        ->get();

        if(count($report) > 0){


            foreach ($report as $value){

                $report = $this->smsGetStatus->get_status($value->sms_send_id, $value->phone_send);

                if(array_key_exists(0, $report)){

                    if($report[0] == 1){

                            $result [$value->mailing_id] ['send'] [] = 1;

                    }else{
                            $result [$value->mailing_id] ['failed'] [] = 1;
                        }

                    }
                }
        } else {
            return view('report.index', ['result' =>  [], 'post' => 0]);
        }



        return view('report.index', ['result' =>  $result, 'post' => 1]);
    }
}
