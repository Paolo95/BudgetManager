<?php

namespace App\Http\Controllers;

use App\Models\Expense;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\ExpenseCategory;
use Carbon\Carbon;
use Illuminate\Http\Request;
use DateTime;

use function PHPUnit\Framework\isEmpty;

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

    public function searchExpenseByDateRange(Request $request)
    {
     
        // Validate the request data
        $validatedData = $request->validate([
            'start_date' => 'required|date',
            'end_date' => 'required|date'
        ]);
        
    
        $startDate = Carbon::parse($validatedData['start_date']);
        $endDate = Carbon::parse($validatedData['end_date']);
       
        // Check if start date is greater than end date
        if ($startDate->gt($endDate)) {
            // Redirect back with error message
            return redirect()->back()->with('warning', 'La data di inizio deve essere antecedente a quella di fine!');
        }

        $expenses = Expense::select('expenses.id', 'expenses.date', 'expenses.title', 'expenses.description', 'expenses.amount',
                                        'expense_categories.type', 'expense_categories.subtype')
                            ->whereBetween('expenses.date', [$startDate, $endDate])
                            ->join('expense_categories', 'expenses.expense_category_id', '=', 'expense_categories.id')
                            ->orderby('expenses.date', 'DESC')
                            ->get();


        return redirect()->back()->with([
            'expenses'      =>     $expenses,
            'start_date'    =>   $startDate
        ]);

 
    }

    public function loadExpenseData(Request $request, $expenseID)
    {

        $expenseData = Expense::select('expenses.id', 'expenses.date', 'expenses.title', 'expenses.description', 'expenses.amount',
                                        'expense_categories.type', 'expense_categories.subtype')
                                ->join('expense_categories', 'expenses.expense_category_id', '=', 'expense_categories.id')
                                ->where('expenses.id', $expenseID)
                                ->first();
        

        return $expenseData;
    }

    public function editExpense(Request $request)
    {
        
        // Validate the request data
        $validatedData = $request->validate([
            'id'            => 'required|integer',
            'date'          => 'required|date',
            'type'          => 'required',
            'subtype'       => 'required',
            'deadline_id'   => 'nullable|integer',
            'title'         => 'required|max:255',
            'description'   => 'nullable|max:255',
            'amount'        => 'required|numeric|min:0',
        ]);

   

        // Parse the date using Carbon
        $date = Carbon::parse($validatedData['date']);

        // Retrieve the expense record by ID
        $expense = Expense::findOrFail($validatedData['id']);

        // Update the expense attributes
        $expense->date = $date;

        $categoryID = ExpenseCategory::select('id')
                                        ->where('type',$validatedData['type'])
                                        ->where('subtype', $validatedData['subtype'])
                                        ->first();

        $expense->expense_category_id = $categoryID->id;
  
        if(isset($validatedData['deadline_id'])){
            $expense->deadline_id   = $validatedData['deadline_id'];
        }

        $expense->title        = $validatedData['title'];
        $expense->description   = $validatedData['description'];
        $expense->amount        = $validatedData['amount'];

        // Save the updated record to the database
        $expense->save();

        // You can return a response, such as a redirect or a JSON response
        return redirect()->back()->with('message', 'Spesa modificata correttamente!');
    }

    public function deleteExpense(Request $request)
    {
        $expenseID = $request->input('id');
    
        // Retrieve the expense record by ID
        $expense = Expense::findOrFail($expenseID);
    
        // Delete the expense record
        $expense->delete();
    
        // Return a response, such as a redirect or a JSON response
        return response()->json(['message' => 'Expense deleted successfully'], 200);
    }



}
