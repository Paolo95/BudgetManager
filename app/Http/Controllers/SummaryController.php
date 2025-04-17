<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;

class SummaryController extends Controller
{
    public function summary(Request $request) {

        $selectedYear = (int) $request->input('summaryYearSelect', Carbon::now()->year);

        $expenseController = new ExpenseController();

        $incomingController = new IncomingController();

        $incomingExpenseController = new IncomingExpenseController();

        $savingsController = new SavingController();

        $deadlinesController = new DeadlineController();

        $creditDebitController = new CreditDebitController();

        $targetController = new TargetController();


        $usrExpPrimaryCategoryAnnuallyPercLists = $expenseController->usrExpPrimaryCategoryAnnuallyPercLists($selectedYear);
        $usrExpSecondaryCategoryAnnuallyPercLists = $expenseController->usrExpSecondaryCategoryAnnuallyPercLists($selectedYear);

        $usrExpMonthSummary = $expenseController->usrExpMonthSummary($selectedYear);
        $usrIncMonthSummary = $incomingController->usrIncMonthSummary($selectedYear);

        $availableYears = $incomingExpenseController->availableYears();

        $usrRatioMonthSummary = $incomingExpenseController->usrRatioMonthSummary($selectedYear);

        $usrSavMonthSummary = $savingsController->usrSavMonthSummary($selectedYear);

        
        $userCreditDebitOnYear = $creditDebitController->userCreditDebitOnYear($selectedYear);
    
        $userDeadlinesSummary = $deadlinesController->userDeadlinesSummary();

        $userTarget = $targetController->getTarget();

        $userSavings = $incomingExpenseController->usrSavings($selectedYear);

        return view('pages.summary')->with([
            'usrExpPrimaryCategoryAnnuallyPercLists'    =>  $usrExpPrimaryCategoryAnnuallyPercLists,
            'usrExpSecondaryCategoryAnnuallyPercLists'  =>  $usrExpSecondaryCategoryAnnuallyPercLists,
            'usrExpMonthSummary'                        =>  $usrExpMonthSummary,
            'usrIncMonthSummary'                        =>  $usrIncMonthSummary,
            'availableYears'                            =>  $availableYears,
            'selectedYear'                              =>  $selectedYear,
            'userCreditDebitOnYear'                     =>  $userCreditDebitOnYear,
            'usrSavMonthSummary'                        =>  $usrSavMonthSummary,
            'usrRatioMonthSummary'                      =>  $usrRatioMonthSummary,
            'userDeadlinesSummary'                      =>  $userDeadlinesSummary,
            'userTarget'                                =>  $userTarget,
            'userSavings'                               =>  $userSavings
        ]);

    }
}
