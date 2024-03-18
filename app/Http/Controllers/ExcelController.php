<?php

namespace App\Http\Controllers;

use App\Http\Requests\FileMIMERequest;
use App\Imports\ClientImport;
use App\Jobs\ClientLoadJob;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use PhpOffice\PhpSpreadsheet\Shared\Date;


class ExcelController extends Controller
{
    public function upload(FileMIMERequest $request)
    {
        $error = '';

        if ($request->hasFile('clients')) {

            $collection = Excel::toCollection(new ClientImport(), $request->file('clients'));

            $mimeType = $request->file('clients')->getMimeType();


            if ($mimeType <> 'text/plain') {

                foreach ($collection as $value) {
                    foreach ($value as $item) {

                        if (key_exists(2, $item->toArray()) && $item[2] <> '' && $mimeType <> 'text/csv' && $mimeType <> 'text/plain') {
                            $parse = intval($item[2]);
                            $parse = Date::excelToDateTimeObject($parse)->format('Y-m-d');
                        } elseif (key_exists(2, $item->toArray()) && $item[2] <> '' && $mimeType == 'text/csv' && $mimeType <> 'text/plain') {
                            $parse = $item[2];

                        } else {
                            $parse = null;
                        }

                        $data [] = $item[0] . ';' . $item[1] . ';' . $parse;
                    }
                }

                $chunks = array_chunk($data, 1000);

                foreach ($chunks as $chunk) {
                    ClientLoadJob::dispatch($chunk, Auth::user()->id, ';', $request->department)->delay(now()->addSeconds(2));
                }
            } else{
                $error = 'CSV файл не соответствует кодировке UTF-8';
            }

        }
        return redirect()->route('clients.index')->with(['error' => $error]);

    }

}
