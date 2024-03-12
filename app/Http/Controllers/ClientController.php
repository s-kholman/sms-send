<?php

namespace App\Http\Controllers;

use App\Actions\ScheduleSms;
use Illuminate\Http\Request;

class ClientController extends Controller
{
    public function index()
    {
        return view('client.index');
    }

    public function test(ScheduleSms $scheduleSms)
    {
        $scheduleSms();
    }

}
