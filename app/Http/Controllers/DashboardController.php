<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Carbon\Carbon;


class DashboardController extends Controller
{

    public function index() {
        return view('home');
    }

    public function dashboard() {

        $incomingController = new IncomingController();
        $userTotalIncomingsOnLastMount = $incomingController->userTotalIncomingsOnLastMount();

        $expenseController = new ExpenseController();
        $userTotalExpensesOnLastMount = $expenseController->userTotalExpensesOnLastMount();
        $usrExpPrimaryCategoryLastMounthPercLists = $expenseController->usrExpPrimaryCategoryLastMounthPercLists();

        $usrExpSecondaryCategoryLastMounthPercLists = $expenseController->usrExpSecondaryCategoryLastMounthPercLists();

        $usrExpLastMounthCumulative = $expenseController->usrExpLastMounthCumulative();

        $usrTotExpByType = $expenseController->usrTotExpByType();

        $usrTotExpBySubType = $expenseController->usrTotExpBySubType();

        $incomingExpenseController = new IncomingExpenseController();
        $incomingExpenseUnion = $incomingExpenseController->incomingExpenseUnion();

        $userToDoController = new UserToDoController();
        $userToDo = $userToDoController->getUserToDo();
        
        $currentMounth = ucfirst(Carbon::now()->locale('it_IT')->translatedFormat('F'));

        $creditDebitController = new CreditDebitController();
        $userCreditDebitOnLastMonth = $creditDebitController->userCreditDebitOnLastMonth();
     
        return view('pages.dashboard', 
        [
            'userTotalIncomingsOnLastMount'                             => $userTotalIncomingsOnLastMount,
            'userTotalExpensesOnLastMount'                              => $userTotalExpensesOnLastMount,
            'currentMounth'                                             => $currentMounth,
            'incomingExpenseUnion'                                      => $incomingExpenseUnion,
            'userToDo'                                                  => $userToDo,
            'usrExpPrimaryCategoryLastMounthPercLists'                  => $usrExpPrimaryCategoryLastMounthPercLists,
            'usrExpSecondaryCategoryLastMounthPercLists'                => $usrExpSecondaryCategoryLastMounthPercLists,
            'usrExpLastMounthCumulative'                                => $usrExpLastMounthCumulative,
            'usrTotExpByType'                                           => $usrTotExpByType,
            'usrTotExpBySubType'                                        => $usrTotExpBySubType,
            'userCreditDebitOnLastMonth'                                => $userCreditDebitOnLastMonth
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