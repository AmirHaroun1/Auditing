<?php

namespace App\Http\Controllers;

use App\account_transaction;
use Illuminate\Http\Request;

class AccountsInKindController extends Controller
{
    //

    public function index(){

        if(\request()->expectsJson()) {
            account_transaction::whereNotNull('fourth_level_account_id');
        }
    }
}
