<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Expense;
use App\Models\Incoming;
use Illuminate\Http\Request;

class SavingController extends Controller
{
    public function usrSavMonthSummary(String $selectedYear)
    {

         $monthMap = [
            1   => "Gennaio",
            2   => "Febbraio",
            3   => "Marzo",
            4   => "Aprile",
            5   => "Maggio",
            6   => "Giugno",
            7   => "Luglio",
            8   => "Agosto",
            9   => "Settembre",
            10  => "Ottobre",
            11  => "Novembre",
            12  => "Dicembre",
        ];

        $monthsNumbers = [1,2,3,4,5,6,7,8,9,10,11,12];
        $months = array_fill(1, 12, 0);
                
        $userExpenses = Expense::selectRaw('MONTH(date) as month, SUM(amount) as total_amount')
                                    ->where('user_id', auth()->id())
                                    ->whereYear('date', $selectedYear)
                                    ->groupByRaw('MONTH(date)')
                                    ->orderByRaw('MONTH(date) asc')
                                    ->get();
        
        $userIncomings = Incoming::selectRaw('MONTH(date) as month, SUM(amount) as total_amount')
                                    ->where('user_id', auth()->id())
                                    ->whereYear('incomings.date', $selectedYear)
                                    ->groupByRaw('MONTH(date)')
                                    ->orderByRaw('MONTH(date) asc')
                                    ->get();

        $expansesAmounts = $months;
        $incomingsAmounts = $months;
        $savingsAmounts = $months;
       

        foreach ($userExpenses as $expense) {
            $expansesAmounts[$expense->month] = $expense->total_amount;
        }

        foreach ($userIncomings as $incoming) {
            $incomingsAmounts[$incoming->month] = $incoming->total_amount;
        }

        foreach ($monthsNumbers as $monthNumber) {
            $savingsAmounts[$monthNumber] = $incomingsAmounts[$monthNumber] - $expansesAmounts[$monthNumber];
        }

        $monthNames = [];
        foreach (array_keys($months) as $monthNumber) {
            $monthNames[] = $monthMap[$monthNumber];
        }

        $result = [
            'month' => $monthNames,
            'amount' => array_values($savingsAmounts),
        ];

        return $result;
    }
}
