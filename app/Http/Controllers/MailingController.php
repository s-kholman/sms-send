<?php

namespace App\Http\Controllers;

use App\Actions\GetSend;
use App\Actions\StoreSmsStatus;
use App\Api\SMS\SendSms;
use App\Http\Requests\MailingRequest;
use App\Models\Mailing;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class MailingController extends Controller
{
    private SendSms $sendSms;

    public function __construct()
    {

        $this->sendSms = new SendSms();

    }

    public function index()
    {
        return view('mailing.index');
    }

    public function store(MailingRequest $request){

        Mailing::query()
            ->create([
                'mailing_name' => $request->mailing_name,
                'mailing_text' => $request->mailing_text,
                'mailing_send_time' => $request->mailing_send_time,
                'mailing_frequency' => $request->mailing_frequency,
                'mailing_to_day' => $request->mailing_to_day,
                'user_id' => Auth::user()->id,
            ]);

        return redirect()->route('mailing.index');
    }

    public function send(GetSend $getSend, StoreSmsStatus $storeSmsStatus)
    {
        $phones = '';

        if($getSend() <> false){

            foreach ($getSend()['client'] as $value){

                $sms_send_id = Str::uuid();

                $return_send = $this->sendSms->send_sms($value->phones, $getSend()['scheduled'][0]->mailing_text, 0, 0, $sms_send_id);

                $storeSmsStatus([
                    'sms_send_id' => $sms_send_id,
                    'mailing_id' => $getSend()['scheduled'][0]->id,
                    'phone_send' => $phones,
                    'date' => Carbon::now(),
                    'user_id' => Auth::user()->id,
                ]);

            }

        }
        return redirect()->route('mailing.index');
    }
}
