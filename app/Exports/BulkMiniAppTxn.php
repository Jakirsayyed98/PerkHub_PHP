<?php

namespace App\Exports;

use App\Models\affiliate_transaction;
use App\Exports\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;

class BulkMiniAppTxn implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        $txn = affiliate_transaction::all();
        return $txn;
    }
}
