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

        $selectedYear = (int) $request->input('dashYearSelect', Carbon::now()->year);
        
        $incomingController = new IncomingController();
        $userTotalIncomingsOnMount = $incomingController->userTotalIncomingsOnMount($selectedMonth, $selectedYear);

        $expenseController = new ExpenseController();
        $userTotalExpensesOnMount = $expenseController->userTotalExpensesOnMount($selectedMonth, $selectedYear);

        $usrExpPrimaryCategoryMounthPercLists = $expenseController->usrExpPrimaryCategoryMounthPercLists($selectedMonth, $selectedYear);

        $usrExpSecondaryCategoryMounthPercLists = $expenseController->usrExpSecondaryCategoryMounthPercLists($selectedMonth, $selectedYear);

        $usrExpMounthCumulative = $expenseController->usrExpMounthCumulative($selectedMonth, $selectedYear);

        $usrTotExpByType = $expenseController->usrTotExpByType($selectedMonth, $selectedYear);

        $usrTotExpBySubType = $expenseController->usrTotExpBySubType($selectedMonth, $selectedYear);

        $incomingExpenseController = new IncomingExpenseController();
        $incomingExpenseUnion = $incomingExpenseController->incomingExpenseUnion($selectedMonth, $selectedYear);

        $availableYears  = $incomingExpenseController->availableYears();
        $availableMonths = $incomingExpenseController->availableMonths($selectedYear);

        $userToDoController = new UserToDoController();
        $userToDo = $userToDoController->getUserToDo($selectedMonth, $selectedYear);
        
        $creditDebitController = new CreditDebitController();
        $userCreditDebitOnMonth = $creditDebitController->userCreditDebitOnMonth($selectedMonth, $selectedYear);
     
        return view('pages.dashboard')->with([

            'selectedMonth'                                             => $selectedMonth,
            'selectedYear'                                              => $selectedYear,
            'availableYears'                                            => $availableYears,
            'availableMonths'                                           => $availableMonths,
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

    public function newCategory() {
        return view('pages.new_category');
    }

    public function editCategory() {
        return view('pages.edit_category');
    }

    public function newToDo() {
        return view('pages.new_todo');
    }

    public function editToDo() {
        return view('pages.edit_todo');
    }

    

}