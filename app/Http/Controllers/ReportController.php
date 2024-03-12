<?php

namespace App\Http\Controllers;

use App\Api\SMS\SmsGetStatus;
use App\Models\Mailing;
use App\Models\SmsStatusSend;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReportController extends Controller
{
    private SmsGetStatus $smsGetStatus;


    public function __construct()
    {
        $this->smsGetStatus = new SmsGetStatus();
    }

    public function index()
    {
        return view('report.index', ['result' => 0, 'sum' => 0, 'post' => 0]);
    }

    public function find(Request $request)
    {
        $return = '';
        /**
         * 1. Запрос, где поле sms_status_code равно null
         * 2. Затем из обновленной базы берем значения и показываем пользователю
         */
        $get_status_sms = SmsStatusSend::query()
            ->whereDate('date', $request->date)
            ->where('user_id', Auth::user()->id)
            ->where('sms_status_code', null)
            ->orWhere('sms_status_code', 0)
            ->latest('created_at')
            ->get();

        if (count($get_status_sms) > 0) {

            foreach ($get_status_sms as $value) {

                $get_status = $this->smsGetStatus->get_status($value->sms_send_id, $value->phone_send);

                if (array_key_exists(0, $get_status)) {
                    SmsStatusSend::query()
                        ->where('phone_send', $value->phone_send)
                        ->where('sms_send_id', $value->sms_send_id)
                        ->update(['sms_status_code' => $get_status[0]]);
                }
                // return view('report.index', ['result' =>  $result, 'post' => 1]);
            }
        }

        //Собираем ответ
        //Получаем группировкой по рассылкам
        $mailing = SmsStatusSend::query()
            ->whereDate('date', $request->date)
            ->where('user_id', Auth::user()->id)
            ->get();

        if ($mailing->isNotEmpty()) {
            foreach ($mailing->groupBy('mailing_id') as $key => $value) {

                //dump('Всего ' . $value->count());

               //$mailing_name = Mailing::query()->find($key)->value('mailing_name');
                //dd($mailing_name);
                $sms_status_code = $value->groupBy('sms_status_code')->toArray();

                if (array_key_exists(1, $sms_status_code)) {

                    $report [$key] = ['all' => $value->count(), 'yes' => count($sms_status_code[1])];

                } else {
                    $report [$key] = ['all' => $value->count(), 'yes' => 0];
                }
            }
        } else{
            return view('report.index', ['result' =>  [], 'post' => 0]);
        }

        return view('report.index', ['result' =>  $report, 'post' => 1]);
       // dd($report);

        //$all = count($status_sms);

        //dd($status_sms);

    }
}
/* if($report[0] == 1){

         //$result [$value->mailing_id] ['send'] [] = 1;

 }else{
         //$result [$value->mailing_id] ['failed'] [] = 1;
     }

 }



else {

                    // return view('report.index', ['result' =>  [], 'post' => 0]);

                }

}*/
