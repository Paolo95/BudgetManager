<?php

namespace App\Http\Controllers;

use App\Models\Expense;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DateTime;

class ExpenseController extends Controller
{
    public function userTotalExpensesOnLastMount(): float
    {
        $userTotalExpensesOnLastMount = Expense::where('user_id', auth()->id())
                                            ->whereMonth('date', (int) now()->format('m'))
                                            ->sum('amount');
        return $userTotalExpensesOnLastMount;
    }

    public function usrExpPrimaryCategoryLastMounthPercLists()
    {
        
        $userExpensesByCategoryOnLastMonth = Expense::select('type', DB::raw('SUM(amount) as total_amount'))
                                                    ->where('user_id', auth()->id())
                                                    ->join('expense_categories', 'expenses.expense_category_id', '=', 'expense_categories.id')
                                                    ->whereMonth('expenses.date', (int) now()->format('m'))
                                                    ->groupBy('type')
                                                    ->orderBy('total_amount', 'desc')
                                                    ->get();
     
        $userTotalExpenses = Expense::select(DB::raw('SUM(amount) as total_amount'))
                                                ->where('user_id', auth()->id())
                                                ->first();

       
        $expansesNames = [];
        $expansesAmounts = [];

      
        foreach ($userExpensesByCategoryOnLastMonth as $expense) {
            $expansesNames[] = $expense->type;
            $expansesAmounts[] = ($expense->total_amount / $userTotalExpenses->total_amount) * 100;
        }

        $result = [
            'labels' => $expansesNames,
            'total_amount' => $expansesAmounts,
        ];


        return $result;
    }

    public function usrExpSecondaryCategoryLastMounthPercLists()
    {
        
        $userExpensesByCategoryOnLastMonth = Expense::select('subtype', DB::raw('SUM(amount) as total_amount'))
                                                    ->where('user_id', auth()->id())
                                                    ->join('expense_categories', 'expenses.expense_category_id', '=', 'expense_categories.id')
                                                    ->whereMonth('expenses.date', (int) now()->format('m'))
                                                    ->groupBy('subtype')
                                                    ->orderBy('total_amount', 'desc')
                                                    ->get();
       
        $userTotalExpenses = Expense::select(DB::raw('SUM(amount) as total_amount'))
                                                ->where('user_id', auth()->id())
                                                ->first();

       
        $expansesNames = [];
        $expansesAmounts = [];

      
        foreach ($userExpensesByCategoryOnLastMonth as $expense) {
            $expansesNames[] = $expense->subtype;
            $expansesAmounts[] = ($expense->total_amount / $userTotalExpenses->total_amount) * 100;
        }

        $result = [
            'labels' => $expansesNames,
            'total_amount' => $expansesAmounts,
        ];

 
      
        return $result;
    }

    public function usrExpLastMounthCumulative()
    {
        
        $userExpenses = Expense::select('date','amount')
                                    ->where('user_id', auth()->id())
                                    ->whereMonth('expenses.date', (int) now()->format('m'))
                                    ->orderBy('expenses.date', 'asc')
                                    ->get();
        
        $cumSum = 0;               
        
        if ($userExpenses->isEmpty()) {
            $expanseDays[] = null;
            $expansesAmountsCumulative[] = $cumSum;
        } else {
            foreach ($userExpenses as $expense) {
                $date = new DateTime($expense->date);
                $expanseDays[] = $date->format('d');
                $cumSum += $expense->amount;
                $expansesAmountsCumulative[] = $cumSum;
            }
        }        

        $result = [
            'day' => $expanseDays,
            'cumulative_sum' => $expansesAmountsCumulative,
        ];
      
        return $result;
    }

    public function usrTotExpByType()
    {
        
        $usrTotExpByType = Expense::select('type', DB::raw('SUM(amount) as total_amount'))
                                    ->where('user_id', auth()->id())
                                    ->join('expense_categories', 'expenses.expense_category_id', '=', 'expense_categories.id')
                                    ->whereMonth('expenses.date', (int) now()->format('m'))
                                    ->groupBy('type')
                                    ->orderBy('total_amount', 'desc')
                                    ->get();
     
       
        $expanseTypes = [];
        $expansesAmounts = [];

     
        foreach ($usrTotExpByType as $item) {
            $expanseTypes[] = $item->type;
            $expansesAmounts[] = $item->total_amount;
        }

        $desiredTypes = ["Desideri", "Risparmio", "Necessità"];
        foreach ($desiredTypes as $type) {
            if (!in_array($type, $expanseTypes)) {
                $expanseTypes[] = $type; 
                $expansesAmounts[] = 0; 
            }
        }

        $result = [
            'type' => $expanseTypes,
            'total_amount' => $expansesAmounts,
        ];

        return $result;
    }

    public function usrTotExpBySubType()
    {
        
        $usrTotExpBySubType = Expense::select('subtype', DB::raw('SUM(amount) as total_amount'))
                                    ->where('user_id', auth()->id())
                                    ->join('expense_categories', 'expenses.expense_category_id', '=', 'expense_categories.id')
                                    ->whereMonth('expenses.date', (int) now()->format('m'))
                                    ->groupBy('subtype')
                                    ->orderBy('total_amount', 'desc')
                                    ->get();
     
       
        $expanseSubTypes = [];
        $expansesAmounts = [];

     
        foreach ($usrTotExpBySubType as $item) {
            $expanseSubTypes[] = $item->subtype;
            $expansesAmounts[] = $item->total_amount;
        }

        $result = [
            'subtype' => $expanseSubTypes,
            'total_amount' => $expansesAmounts,
        ];

 
        return $result;
    }

    public function newExpense(Request $request)
    {
      
        // Validate the request data
        $validatedData = $request->validate([
            'date' => 'required|date',
            'type' => 'required',
            'subtype' => 'required',
            'deadline_id' => 'nullable|integer',
            'title' => 'required|max:255',
            'description' => 'nullable|max:255',
            'amount' => 'required|numeric|min:0',
        ]);
        
        $expenseCategoryController = new ExpenseCategoryController();
        $expenseCategoryID = $expenseCategoryController->findExpenseCategoryID($validatedData['type'], $validatedData['subtype']);
    
        // Create a new Expense instance
        $expense = new Expense();
        $expense->date = $validatedData['date'];
        $expense->expense_category_id = $expenseCategoryID;
        $expense->user_id = auth()->id();
        $expense->deadline_id = $validatedData['deadline_id'];
        $expense->title = $validatedData['title'];
        $expense->description = $validatedData['description'];
        $expense->amount = $validatedData['amount'];
        
        
       
        // Save the expense
        $expense->save();

        // Redirect or return a response as needed
        return redirect()->back()->with('message', 'Spesa inserita correttamente!');
    }


}
