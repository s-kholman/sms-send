<?php

namespace App\Http\Controllers;

use App\Actions\Crontab;
use App\Actions\SmsGetStatusSchedule;
use App\Models\Client;
use Illuminate\Http\Request;

class TestController extends Controller
{
    public function test(Crontab $crontab)
    {
        $crontab();


       /* $posts = Client::query()
            ->where('user_id',1)
            ->whereRaw(
            "MATCH(clientFullName,phone,email) AGAINST(? IN BOOLEAN MODE)",
            array(['Надежда* 79026223673'])
        )->get();
        dd($posts);*/
        //IN NATURAL LANGUAGE MODE
        //IN BOOLEAN MODE
       // dd($getStatusSchedule->smsStatusGet());
    }

    public function index()
    {

        return view('test.index');
    }

}
