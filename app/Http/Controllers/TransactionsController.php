<?php

namespace App\Http\Controllers;

use App\institution;
use App\reviser;
use App\Transaction;
use Illuminate\Http\Request;

class TransactionsController extends Controller
{
    //
    public function index()
    {
        return view('Secertary.Transactions.index');
    }
    public function create()
    {
        return view('Secertary.Transactions.create');
    }
    public function store(Request $request, $institution_id ,$reviser_id){

        $NewTransaction = Transaction::create($request->all());
        $NewTransaction->institution_id = $institution_id;
        $NewTransaction->reviser_id = $reviser_id;
        $NewTransaction->save();

        return response()->json([$NewTransaction],200);
    }
}
