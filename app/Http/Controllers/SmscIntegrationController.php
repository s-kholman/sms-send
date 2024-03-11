<?php

namespace App\Http\Controllers;

use App\Api\SMS\SmscSendCmd;
use App\Http\Requests\SmscInregrationRequest;
use App\Models\SmscIntegration;
use Illuminate\Support\Facades\Auth;

class SmscIntegrationController extends Controller
{
    public function index(SmscSendCmd $smscSendCmd)
    {
        $check = SmscIntegration::query()->where('user_id', Auth::user()->id)->first();

        if(!empty($check)){

            $check = isset($smscSendCmd->_smsc_send_cmd("balance")[1]) ? 'Нет подключения' : 'Подключение активно';

        } else{

            $check = 'Нет подключения';

        }

        return view('smsc.index', ['check' => $check]);
    }

    public function store(SmscInregrationRequest $smscInregrationRequest)
    {

        $balance = new SmscSendCmd();

        $balance->setLogin($smscInregrationRequest->login);

        $balance->setPassword($smscInregrationRequest->api_key);

        $return = $balance->_smsc_send_cmd("balance");

        if(!isset($return[1])){
            SmscIntegration::query()->updateOrCreate([
                'user_id' => Auth::user()->id,
            ],
            [
                'login' => $smscInregrationRequest->login,
                'password' => $smscInregrationRequest->api_key,
            ]);
        }

        return redirect()->route('smsc.index');

    }
}
