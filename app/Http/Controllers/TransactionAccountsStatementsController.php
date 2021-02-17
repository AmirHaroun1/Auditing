<?php

namespace App\Http\Controllers;

use App\account_transaction;
use App\AccountLVL1;
use App\AccountLVL2;
use App\AccountLVL3;
use App\AccountLVL4;
use App\Imports\AccountTransactionImport;
use App\TransactionAccountsRepository;
use Illuminate\Http\Request;
use Maatwebsite\Excel\HeadingRowImport;
use Maatwebsite\Excel\Facades\Excel;
class TransactionAccountsController extends Controller
{
    //

    public function GetExcelHeader(Request $request){

        $headers = (new HeadingRowImport)->toArray($request['AccountExcelFile']);

        $rows = Excel::ToCollection( new AccountTransactionImport,$request['AccountExcelFile']);


        return response()->json(['headers'=>$headers,'rows'=>$rows[0]],200);
    }
    public function index($AccountID,$transactionID,$AccountLevel){


        $AccountStatements = TransactionAccountsRepository::GetTransactionAccounts($transactionID,$AccountID,$AccountLevel);

        return response()->json(['statements'=>$AccountStatements],200);
    }

    public function SumOfAccountsOfTransaction($TransactionsID){

        $NestedAccountsWithSum = TransactionAccountsRepository::GetSumOfTransactionsAccounts($TransactionsID)->get();

        return response()->json(['NestedAccountsWithSum'=>$NestedAccountsWithSum],200);
    }
    public function update(Request $request,$TransactionAccountID){

        account_transaction::findOrFail($TransactionAccountID)->update($request->all());
        return response()->json('');
    }
    public function store(Request $request,$transactionID){
        $AddedAccountID = TransactionAccountsRepository::StoreNewTransactionAccount($request,$transactionID);
        return response()->json($AddedAccountID);

    }
    public function delete($accountTransactionID){
        account_transaction::destroy($accountTransactionID);
        return response()->json('',200);
    }
}
