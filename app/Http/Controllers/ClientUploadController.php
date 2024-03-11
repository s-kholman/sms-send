<?php

namespace App\Http\Controllers;

use App\Actions\StoreClient;
use App\Actions\ValidateClient;
use App\Http\Requests\FileMIMERequest;

class ClientUploadController extends Controller
{
    public function upload(FileMIMERequest $request, ValidateClient $validateClient, StoreClient $storeClient)
    {

        if ($request->hasFile('clients')){

            $file = fopen($request->file('clients'), 'r');

            for($i = 0; $data = fgetcsv($file, 1_000, ';'); $i++){
//dd($data);
                if (count($data) >= 3){
                    $validate = $validateClient(
                        [
                            'phone' => $data[0],
                            'birth' => $data[2],
                            //'clientFullName' => iconv("OEM866", "UTF-8", $data[1])
                            'clientFullName' => $data[1]
                        ]);
                    if($validate <> false){
                        $storeClient($validate);
                    }
                }
            }
            fclose($file);
        }


        return redirect()->route('clients.index');
    }
}
