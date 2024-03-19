<?php

namespace App\Http\Controllers;

use App\Actions\SmsGetStatusSchedule;
use Illuminate\Http\Request;

class TestController extends Controller
{
    public function test(SmsGetStatusSchedule $getStatusSchedule)
    {
        dd($getStatusSchedule->smsStatusGet());
    }

    public function index()
    {
        return view('test.index');
    }

}
