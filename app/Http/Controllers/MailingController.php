<?php

namespace App\Http\Controllers;

use App\Actions\GetSend;
use App\Actions\ImmediateDispatch;
use App\Actions\StoreSmsStatus;
use App\Api\SMS\SendSms;
use App\Http\Requests\MailingRequest;
use App\Models\Client;
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

        $count = Client::query()->where('user_id', Auth::user()->id)->count();

        return view('mailing.index', ['count' => $count]);
    }

    public function store(MailingRequest $request, ImmediateDispatch $immediateDispatch){

        if($request->mailing_type == 1){
            Mailing::query()
                ->create([
                    'mailing_name' => $request->mailing_name,
                    'mailing_text' => $request->mailing_text,
                    'mailing_send_birth' => $request->mailing_send_birth,
                    'mailing_type' => $request->mailing_type,
                    'mailing_to_day' => $request->mailing_to_day,
                    'user_id' => Auth::user()->id,
                ]);
        } elseif ($request->mailing_type == 2){
            $mailing = Mailing::query()
                ->create([
                    'mailing_name' => $request->mailing_name,
                    'mailing_text' => $request->mailing_text,
                    'mailing_immediate_dispatch' => Carbon::now()->addMinutes()->format('Y-m-d H:i:00'),
                    'mailing_type' => $request->mailing_type,
                    'mailing_to_day' => 0,
                    'user_id' => Auth::user()->id,
                ]);
            $immediateDispatch($mailing);
        }


        return redirect()->route('mailing.index');
    }

   /* public function send(GetSend $getSend, StoreSmsStatus $storeSmsStatus)
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
    }*/
}
