<?php

namespace App\Http\Controllers;

use App\Actions\ScheduleSms;
use App\Models\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ClientController extends Controller
{
    public function index()
    {
        $clients = Client::query()->where('user_id', Auth::user()->id)->paginate(50);




        return view('client.index', ['clients' => $clients]);
    }
}
