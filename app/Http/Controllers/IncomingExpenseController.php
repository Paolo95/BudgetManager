<?php

namespace App\Http\Controllers;

use App\Models\Expense;
use App\Models\Incoming;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class IncomingExpenseController extends Controller
{
    public function incomingExpenseUnion(String $selectedMonth, int $selectedYear){

        // Array mapping Italian month names to their corresponding month numbers
        $monthMap = [
            "Gennaio" => 1,
            "Febbraio" => 2,
            "Marzo" => 3,
            "Aprile" => 4,
            "Maggio" => 5,
            "Giugno" => 6,
            "Luglio" => 7,
            "Agosto" => 8,
            "Settembre" => 9,
            "Ottobre" => 10,
            "Novembre" => 11,
            "Dicembre" => 12,
        ];

        // Convert the selected month name to its corresponding month number
        $monthNumber = $monthMap[$selectedMonth] ?? now()->format('m'); // Default to current month if not found
    
        $incomingResults = Incoming::where('user_id', auth()->id())
            ->whereMonth('incomings.date', $monthNumber)
            ->whereYear('incomings.date', $selectedYear) 
            ->select('incomings.date as union_date', 'incomings.title', 'incomings.description as description', 'incomings.amount', 'incoming_categories.type as category', 'incoming_categories.subtype as subcategory')
            ->join('incoming_categories', 'incomings.incoming_category_id', '=', 'incoming_categories.id')
            ->addSelect(Incoming::raw("'Entrata' as identifier"));

        $expenseResults = Expense::where('user_id', auth()->id())
            ->whereMonth('expenses.date', $monthNumber) 
            ->whereYear('expenses.date', $selectedYear) 
            ->select('expenses.date as union_date', 'expenses.title', 'expenses.description as description', 'expenses.amount', 'expense_categories.type as category', 'expense_categories.subtype as subcategory')
            ->join('expense_categories', 'expenses.expense_category_id', '=', 'expense_categories.id')
            ->addSelect(Expense::raw("'Uscita' as identifier"));

        $results = $incomingResults->union($expenseResults)->orderBy('union_date', 'desc')->limit(10)->get();

        return $results->all();

    }

    public function availableYears()
    {

        $availableYears = DB::table(function ($query) {
            $query->select(DB::raw('DISTINCT YEAR(date) as year'))
                ->from('expenses')
                ->where('user_id', auth()->id())
                ->union(
                    DB::table('incomings')
                    ->select(DB::raw('DISTINCT YEAR(date) as year'))
                    ->where('user_id', auth()->id())
                );
        }, 'years')
        ->distinct()
        ->pluck('year');
        
        return $availableYears;
    }

    public function availableMonths($selectedYear)
    {
        // Month mapping from number to Italian names
        $monthMap = [
            1 => "Gennaio",
            2 => "Febbraio",
            3 => "Marzo",
            4 => "Aprile",
            5 => "Maggio",
            6 => "Giugno",
            7 => "Luglio",
            8 => "Agosto",
            9 => "Settembre",
            10 => "Ottobre",
            11 => "Novembre",
            12 => "Dicembre",
        ];

        // Get the distinct month numbers from the database
        $availableMonths = DB::table(function ($query) use ($selectedYear) {
            $query->select(DB::raw('DISTINCT MONTH(date) as month'))
                ->from('expenses')
                ->where('user_id', auth()->id())
                ->whereYear('date', $selectedYear)
                ->union(
                    DB::table('incomings')
                    ->select(DB::raw('DISTINCT MONTH(date) as month'))
                    ->where('user_id', auth()->id())
                    ->whereYear('date', $selectedYear)
                );
        }, 'months')
        ->distinct()
        ->pluck('month');

        // Map month numbers to their corresponding Italian names
        $availableMonths = $availableMonths->map(function ($month) use ($monthMap) {
            return $monthMap[$month];
        });

        return $availableMonths;
    }

    public function usrRatioMonthSummary(String $selectedYear)
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
       

        foreach ($userExpenses as $expense) {
            $expansesAmounts[$expense->month] = $expense->total_amount;
        }

        foreach ($userIncomings as $incoming) {
            $incomingsAmounts[$incoming->month] = $incoming->total_amount;
        }

        $monthNames = [];
        foreach (array_keys($months) as $monthNumber) {
            $monthNames[] = $monthMap[$monthNumber];
        }

        foreach (array_keys($months) as $monthNumber) {
            if($incomingsAmounts[$monthNumber] === 0) {
                $expIncRatio[$monthNumber] = 0;
            }else{
                $expIncRatio[$monthNumber] =  $expansesAmounts[$monthNumber]/$incomingsAmounts[$monthNumber];
            }
            
        }

        $result = [
            'month' => $monthNames,
            'amount' => array_values($expIncRatio),
        ];

        return $result;
    }

    public function usrSavings()
    {

                
        $userExpenses = Expense::selectRaw('SUM(amount) as total_amount')
                                    ->where('user_id', auth()->id())
                                    ->first();
        
        $userIncomings = Incoming::selectRaw('SUM(amount) as total_amount')
                                    ->where('user_id', auth()->id())
                                    ->first();

       
        $usrSavings = $userIncomings->total_amount - $userExpenses->total_amount;

        return $usrSavings;
    }
    

}
