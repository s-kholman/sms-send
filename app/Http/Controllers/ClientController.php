<?php

namespace App\Http\Controllers;

use App\Actions\ScheduleSms;
use App\Models\Client;
use Illuminate\Http\Request;

class ClientController extends Controller
{
    public function index()
    {
        $clients = Client::query()->paginate(50);




        return view('client.index', ['clients' => $clients]);
    }
}
