<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\ToCollection;

class ClientImport implements ToCollection
{
    /**
     * @param Collection $collection
     * @return Collection
     */
    public function collection(Collection $collection)
    {

    }
}
