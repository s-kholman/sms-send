<?php

namespace App\Http\Controllers;

use App\Http\Requests\ClientSearchRequest;
use App\Models\Client;
use App\Models\Department;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ClientController extends Controller
{
    public function index()
    {

        $clients = Client::query()->where('user_id', Auth::user()->id)->paginate(50);
        $count = Client::query()->where('user_id', Auth::user()->id)->count();
        return view('client.index', ['clients' => $clients, 'count' => $count]);
    }

    public function sort(Request $request){

        $clients = Client::query()
            ->where('user_id', Auth::user()->id)
            ->orderBy($request->sort)
            ->paginate(50);

        $count = Client::query()->where('user_id', Auth::user()->id)->count();

        return view('client.index', ['clients' => $clients, 'count' => $count]);
    }

    public function load(){
        $error = session()->get('error');
        $departments = Department::query()->where('user_id', Auth::user()->id)->get();
        return view('client.load', ['departments' => $departments, 'error' => $error]);
    }

    public function search(ClientSearchRequest $request){

        $str = implode("* ", explode(" ", $request->search))."* ";

        $clients = Client::query()
            ->where('user_id', Auth::user()->id)
            ->whereRaw(
                "MATCH(clientFullName,phone,email) AGAINST(? IN BOOLEAN MODE)",
                array([$str]))
            ->paginate(50);

        $count = Client::query()
            ->where('user_id', Auth::user()->id)
            ->whereRaw(
                "MATCH(clientFullName,phone,email) AGAINST(? IN BOOLEAN MODE)",
                array([$str]))
            ->count();

        $search = $request->search;

        return view('client.index', ['clients' => $clients, 'count' => $count, 'search' => $search]);

    }
}
