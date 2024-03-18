<?php

namespace App\Http\Controllers;

use App\Imports\ClientImport;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;


class ExcelController extends Controller
{
    public function upload(Request $request)
    {


        if ($request->hasFile('clients')) {


            $collection =  Excel::toCollection(new ClientImport(), $request->file('clients'));
           // dump($collection);
            foreach ($collection as $value){
                foreach ($value as $item){
                    dump($item);
                }

            }
            dd('d');
           // dd($data);

        }
    }
}
