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

        $incomingExpenseController = new IncomingExpenseController();
        $incomingExpenseUnion = $incomingExpenseController->incomingExpenseUnion();

        $userToDoController = new UserToDoController();
        $userToDo = $userToDoController->getUserToDo();
        
        $currentMounth = ucfirst(Carbon::now()->locale('it_IT')->translatedFormat('F'));
     
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
            'usrTotExpByType'                                           => $usrTotExpByType
        ]);
    }

    public function insertExpense() {

        return view('pages.new_expense');
    }

    public function insertIncoming() {
        return view('pages.new_incoming');
    }
}