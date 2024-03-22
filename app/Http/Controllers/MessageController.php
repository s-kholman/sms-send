<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Crontab;
use App\Models\Department;
use App\Models\Message;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MessageController extends Controller
{
    public function index()
    {

        $count = Client::query()->where('user_id', Auth::user()->id)->count();

        $department = Department::query()
            ->where('user_id', Auth::user()->id)
            ->get();

        return view('message.index', ['count' => $count, 'departments' => $department]);
    }

    public function store(Request $request){

        $message = '';
        $crontab = '';

        if ($request->birth_time < now()->format('H:i')){
            $crontab = "next day $request->birth_time";
        } else{
            $crontab = "today $request->birth_time";
        }

        $message = Message::query()
            ->create(
                [
                    'name' => $request->name,
                    'text' => $request->text,
                    'type' => $request->type,
                    'crontab' => "next day $request->birth_time",
                    'birth_to_day' => $request->birth_to_day,
                    'user_id' => Auth::user()->id,
                ]
            );

        if ($message <> ''){
            Crontab::query()
                ->create(
                    [
                        'run_date' => date('Y-m-d H:i:00', strtotime($crontab)),
                        'status' => true,
                        'message_id' => $message->id,
                    ]
                );
        }
        return redirect()->route('message.index');
    }
}
