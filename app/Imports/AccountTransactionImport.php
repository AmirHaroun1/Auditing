<?php

namespace App\Imports;

use App\account_transaction;
use Maatwebsite\Excel\Concerns\ToModel;

class AccountTransactionImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new account_transaction([
            //
        ]);
    }
}
