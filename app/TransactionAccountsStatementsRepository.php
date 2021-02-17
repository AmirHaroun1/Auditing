<?php


namespace App;


class TransactionAccountsRepository
{

    public static function GetAccountStatements($TransactionID,$AccountID,$AccountLevel){

      return  account_transaction::where('transaction_id',$TransactionID)

            ->when($AccountLevel == 1,function($query) use ($AccountID){
                return $query->where('first_level_account_id',$AccountID);
            })
            ->when($AccountLevel == 2,function($query) use ($AccountID){
                return $query->where('second_level_account_id',$AccountID);
            })
            ->when($AccountLevel == 3,function($query) use ($AccountID){
                return $query->where('third_level_account_id',$AccountID);
            })
            ->when($AccountLevel == 4,function($query) use ($AccountID){
                return $query->where('fourth_level_account_id',$AccountID);
            })

            ->where('account_level',$AccountLevel)

            ->WithAccountBranchesSum($TransactionID)

            ->get();

    }

    public static function GetSumOfAccountsStatements($TransactionID){


        return $NestedAccountsWithSum = AccountLVL1::WithTransactionSum($TransactionID)->WithSumOfEachChild($TransactionID);

    }

    public static function StoreNewAccountStatement($request,$transactionID){

        $transaction = Transaction::select(['id','financial_year','end_financial_year','created_at'])->findOrFail($transactionID);

        if($request->account_level == 1){
            return $transaction->StoreNewFirstLvlAccount($request);
        }
        else if($request->account_level == 2){
            return $transaction->StoreNewSecondLvlAccount($request);
        }
        else if($request->account_level == 3){
            return $transaction->StoreNewThirdLvlAccount($request);

        }
        else if ($request->account_level == 4){
            return $transaction ->StoreNewFourthLvlAccount($request);

        }

    }
}
