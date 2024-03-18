<?php

namespace App\Imports;

use App\Models\Client;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\ToModel;

class ClientsImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new Client([
            'phone' => $row[0],
            'clientFullName' => $row[1],
            'birth' => $row[2],
            'user_id' => Auth::user()->id,
        ]);
    }
}
