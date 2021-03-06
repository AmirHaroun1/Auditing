<?php

namespace App\Http\Controllers;

use App\employee;
use App\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashBoardController extends Controller
{
    //

    public function index()
    {
        $transactionsStats = Transaction::getQuery()
            ->selectRaw('count(*) as AllTransactions')
            ->selectRaw('count(case when time_status="unacceptable" and status !="rejected" and status !="withdrawn" then 1 end ) as LateTransactions')

            ->selectRaw('count(case when secretary_time < secretary_actualTime then 1 end ) as LateTransactionAtSecretary')
            ->selectRaw('count(case when reviser_time < reviser_actualTime then 1 end ) as LateTransactionAtReviser')
            ->selectRaw('count(case when auditor_time < auditor_actualTime then 1 end ) as LateTransactionAtAuditor')
            ->selectRaw('count(case when revisingManager_time < revisingManager_actualTime then 1 end ) as LateTransactionAtRevisingManager')
            ->selectRaw('count(case when Managing_partner_time < Managing_partner_actualTime then 1 end ) as LateTransactionAtManagingPartner')

            ->selectRaw('count(case when status="under_review" then 1 end ) as TransactionsUnderReview')
            ->selectRaw('count(case when status="reviser" then 1 end ) as TransactionsWithReviser')
            ->selectRaw('count(case when status="auditor" then 1 end ) as TransactionsWithAuditor')
            ->selectRaw('count(case when status="revising_manager" then 1 end ) as TransactionsWithRevisingManager')
            ->selectRaw('count(case when status="managing_partner" then 1 end ) as TransactionsWithManagingPartner')

            ->selectRaw('count(case when status="rejected" then 1 end ) as rejectedTransactions')
            ->selectRaw('count(case when status="withdrawn" then 1 end ) as WithdrawnTransactions')

            ->selectRaw('count(case when auditor_is_changed then 1 end ) as TransactionsAuditorIsChanged')

            ->selectRaw('count(case when YEAR(created_at) = YEAR(CURRENT_TIMESTAMP) then 1 end ) as CurrentYearTransactions')
            ->selectRaw('count(case when YEAR(created_at) = YEAR(CURRENT_TIMESTAMP)-1 then 1 end ) as PastYearTransactions')
            ->selectRaw('AVG(total_value) as TotalValueAVG')
            ->get();
        return view('SuperAdmin.dashboard.index');
    }
}
