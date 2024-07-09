<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;

class DashboardController extends Controller
{

    public function index() {
        return view('home');
    }

    public function dashboard(Request $request) {
         
        $selectedMonth = $request->input('dashMonthSelect', ucfirst(Carbon::now()->locale('it_IT')->translatedFormat('F')));
        
        $incomingController = new IncomingController();
        $userTotalIncomingsOnMount = $incomingController->userTotalIncomingsOnMount($selectedMonth);

        $expenseController = new ExpenseController();
        $userTotalExpensesOnMount = $expenseController->userTotalExpensesOnMount($selectedMonth);

        $usrExpPrimaryCategoryMounthPercLists = $expenseController->usrExpPrimaryCategoryMounthPercLists($selectedMonth);

        $usrExpSecondaryCategoryMounthPercLists = $expenseController->usrExpSecondaryCategoryMounthPercLists($selectedMonth);

        $usrExpMounthCumulative = $expenseController->usrExpMounthCumulative($selectedMonth);

        $usrTotExpByType = $expenseController->usrTotExpByType($selectedMonth);

        $usrTotExpBySubType = $expenseController->usrTotExpBySubType($selectedMonth);

        $incomingExpenseController = new IncomingExpenseController();
        $incomingExpenseUnion = $incomingExpenseController->incomingExpenseUnion($selectedMonth);

        $userToDoController = new UserToDoController();
        $userToDo = $userToDoController->getUserToDo($selectedMonth);
        
        $creditDebitController = new CreditDebitController();
        $userCreditDebitOnMonth = $creditDebitController->userCreditDebitOnMonth($selectedMonth);
     
        return view('pages.dashboard')->with([

            'selectedMonth'                                             => $selectedMonth,
            'userTotalIncomingsOnMount'                                 => $userTotalIncomingsOnMount,
            'userTotalExpensesOnMount'                                  => $userTotalExpensesOnMount,
            'incomingExpenseUnion'                                      => $incomingExpenseUnion,
            'userToDo'                                                  => $userToDo,
            'usrExpPrimaryCategoryMounthPercLists'                      => $usrExpPrimaryCategoryMounthPercLists,
            'usrExpSecondaryCategoryMounthPercLists'                    => $usrExpSecondaryCategoryMounthPercLists,
            'usrExpMounthCumulative'                                    => $usrExpMounthCumulative,
            'usrTotExpByType'                                           => $usrTotExpByType,
            'usrTotExpBySubType'                                        => $usrTotExpBySubType,
            'userCreditDebitOnMonth'                                    => $userCreditDebitOnMonth
        ]);
    
    } 

    public function insertExpense() {
        
        return view('pages.new_expense');
    }

    public function editExpense() {
        return view('pages.edit_expense');
    }

    public function insertIncoming() {
        return view('pages.new_incoming');
    }

    public function editIncoming() {
        return view('pages.edit_incoming');
    }

    public function insertDeadline() {
        return view('pages.new_deadline');
    }

    public function editDeadline() {
        return view('pages.edit_deadline');
    }

    public function insertCreditDebits() {
        return view('pages.new_creditDebit');
    }

    public function editCreditDebits() {
        return view('pages.edit_creditDebit');
    }

    public function summary() {
        return view('pages.summary');
    }

}