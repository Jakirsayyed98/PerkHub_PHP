<?php

namespace App\Exports;

use App\Models\MiniAppData;
use App\Exports\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;

class BulkExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        $miniapp = MiniAppData::all();
        return $miniapp;
    }
}
