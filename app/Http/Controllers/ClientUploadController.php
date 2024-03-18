<?php

namespace App\Http\Controllers;

use App\Http\Requests\FileMIMERequest;
use App\Jobs\ClientLoadJob;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ClientUploadController extends Controller
{
    public function upload(FileMIMERequest $request)
    {

        if ($request->hasFile('clients')) {

            /*$file = new \SplFileObject($request->file('clients'));

            $getCsvControl = $file->getCsvControl();
            if (is_array($getCsvControl) && key_exists(0, $getCsvControl)) {
                $csvControl = $getCsvControl[0];
                dd($getCsvControl);
            } else {
                $csvControl = ';';
            }*/

            $csv = file($request->file('clients'));

            foreach ($csv as $value) {
                $utf8 [] = mb_convert_encoding($value, 'utf8', 'CP866');
            }

            $chunks = array_chunk($utf8, 1000);

            foreach ($chunks as $chunk) {
                ClientLoadJob::dispatch($chunk, Auth::user()->id, ';', $request->department)->delay(now()->addSeconds(2));
            }
        }
        return redirect()->route('clients.index');
    }
}
