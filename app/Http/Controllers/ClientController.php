<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Department;
use Illuminate\Support\Facades\Auth;

class ClientController extends Controller
{
    public function index()
    {
        $error = session()->get('error');

        $clients = Client::query()->where('user_id', Auth::user()->id)->paginate(50);

        $departments = Department::query()->where('user_id', Auth::user()->id)->get();

        return view('client.index', ['clients' => $clients, 'departments' => $departments, 'error' => $error]);
    }
}
