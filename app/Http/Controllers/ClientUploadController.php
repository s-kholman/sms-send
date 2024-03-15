<?php

namespace App\Http\Controllers;

use App\Http\Requests\FileMIMERequest;
use App\Jobs\ClientLoadJob;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ClientUploadController extends Controller
{
    public function upload(Request $request)
    {

        if ($request->hasFile('clients')){
                $csv    = file($request->file('clients'));;
                $chunks = array_chunk($csv,1000);
                foreach ($chunks as $chunk) {
                   ClientLoadJob::dispatch($chunk, Auth::user()->id)->delay(now()->addSeconds(2));
                }
        }
       return redirect()->route('clients.index');
    }
}
