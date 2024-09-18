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
    public function userTotalExpensesOnMount(String $selectedMonth, int $selectedYear): float
    {
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
        
        $userTotalExpensesOnMount = Expense::where('user_id', auth()->id())
                                            ->whereMonth('date', $monthNumber)
                                            ->whereYear('date', $selectedYear)
                                            ->sum('amount');
        return $userTotalExpensesOnMount;
    }

    public function usrExpPrimaryCategoryMounthPercLists(String $selectedMonth, int $selectedYear)
    {

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
        
        $usrExpPrimaryCategoryMounthPercLists = Expense::select('type', DB::raw('SUM(amount) as total_amount'))
                                                    ->where('user_id', auth()->id())
                                                    ->join('expense_categories', 'expenses.expense_category_id', '=', 'expense_categories.id')
                                                    ->whereMonth('expenses.date', $monthNumber)
                                                    ->whereYear('expenses.date', $selectedYear)
                                                    ->groupBy('type')
                                                    ->orderBy('total_amount', 'desc')
                                                    ->get();
     
        $userTotalExpenses = Expense::select(DB::raw('SUM(amount) as total_amount'))
                                                ->where('user_id', auth()->id())
                                                ->whereMonth('expenses.date', $monthNumber)
                                                ->whereYear('date', $selectedYear)
                                                ->first();

       
        $expansesNames = [];
        $expansesAmounts = [];

      
        foreach ($usrExpPrimaryCategoryMounthPercLists as $expense) {
            $expansesNames[] = $expense->type;
            $expansesAmounts[] = ($expense->total_amount / $userTotalExpenses->total_amount) * 100;
        }

        $result = [
            'labels' => $expansesNames,
            'total_amount' => $expansesAmounts,
        ];


        return $result;
    }

    public function usrExpPrimaryCategoryAnnuallyPercLists(int $selectedYear)
    {

        $usrExpPrimaryCategoryAnnuallyPercLists = Expense::select('expense_categories.type', DB::raw('SUM(expenses.amount) as total_amount'))
                                                    ->where('user_id', auth()->id())
                                                    ->join('expense_categories', 'expenses.expense_category_id', '=', 'expense_categories.id')
                                                    ->whereYear('expenses.date', $selectedYear)
                                                    ->groupBy('expense_categories.type')
                                                    ->orderBy('total_amount', 'desc')
                                                    ->get();
     
        $userTotalExpenses = Expense::select(DB::raw('SUM(amount) as total_amount'))
                                                ->where('user_id', auth()->id())
                                                ->whereYear('expenses.date', $selectedYear)
                                                ->first();

       
        $expansesNames = [];
        $expansesAmounts = [];

      
        foreach ($usrExpPrimaryCategoryAnnuallyPercLists as $expense) {
            $expansesNames[] = $expense->type;
            $expansesAmounts[] = ($expense->total_amount / $userTotalExpenses->total_amount) * 100;
        }

        $result = [
            'labels' => $expansesNames,
            'total_amount' => $expansesAmounts,
        ];

        return $result;
    }

    public function usrExpSecondaryCategoryAnnuallyPercLists(int $selectedYear)
    {

        $usrExpSecondaryCategoryAnnuallyPercLists = Expense::select('expense_categories.subtype', DB::raw('SUM(expenses.amount) as total_amount'))
                                                    ->where('user_id', auth()->id())
                                                    ->join('expense_categories', 'expenses.expense_category_id', '=', 'expense_categories.id')
                                                    ->whereYear('expenses.date', $selectedYear)
                                                    ->groupBy('expense_categories.subtype')
                                                    ->orderBy('total_amount', 'desc')
                                                    ->get();
     
        $userTotalExpenses = Expense::select(DB::raw('SUM(amount) as total_amount'))
                                                ->where('user_id', auth()->id())
                                                ->whereYear('expenses.date', $selectedYear)
                                                ->first();

       
        $expansesNames = [];
        $expansesAmounts = [];

      
        foreach ($usrExpSecondaryCategoryAnnuallyPercLists as $expense) {
            $expansesNames[] = $expense->subtype;
            $expansesAmounts[] = ($expense->total_amount / $userTotalExpenses->total_amount) * 100;
        }

        $result = [
            'labels' => $expansesNames,
            'total_amount' => $expansesAmounts,
        ];

        
        return $result;
    }

    public function usrExpSecondaryCategoryMounthPercLists(String $selectedMonth, int $selectedYear)
    {

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
        
        $userExpensesByCategoryOnLastMonth = Expense::select('subtype', DB::raw('SUM(amount) as total_amount'))
                                                    ->where('user_id', auth()->id())
                                                    ->join('expense_categories', 'expenses.expense_category_id', '=', 'expense_categories.id')
                                                    ->whereMonth('expenses.date', $monthNumber)
                                                    ->whereYear('expenses.date', $selectedYear)
                                                    ->groupBy('subtype')
                                                    ->orderBy('total_amount', 'desc')
                                                    ->get();
       
        $userTotalExpenses = Expense::select(DB::raw('SUM(amount) as total_amount'))
                                                ->where('user_id', auth()->id())
                                                ->whereYear('date', $selectedYear)
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

    public function usrExpMounthCumulative(String $selectedMonth, int $selectedYear)
    {
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

        $userExpenses = Expense::selectRaw('date, SUM(amount) as total_amount')
                                    ->where('user_id', auth()->id())
                                    ->whereYear('date', $selectedYear)
                                    ->whereMonth('date', $monthNumber)
                                    ->groupBy('date')
                                    ->orderBy('date','asc')
                                    ->get();
        
        $cumSum = 0;               
        
        if ($userExpenses->isEmpty()) {
            $expanseDays[] = null;
            $expansesAmountsCumulative[] = $cumSum;
        } else {
            foreach ($userExpenses as $expense) {
                $date = new DateTime($expense->date);
                $expanseDays[] = $date->format('d');
                $cumSum += $expense->total_amount;
                $expansesAmountsCumulative[] = $cumSum;
            }
        }        

        $result = [
            'day' => $expanseDays,
            'cumulative_sum' => $expansesAmountsCumulative,
        ];
      
        return $result;
    }

    public function usrExpMonthSummary(String $selectedYear)
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

        $expansesAmounts = $months;
       

        foreach ($userExpenses as $expense) {
            $expansesAmounts[$expense->month] = $expense->total_amount;
        }

        $monthNames = [];
        foreach (array_keys($months) as $monthNumber) {
            $monthNames[] = $monthMap[$monthNumber];
        }

        $result = [
            'month' => $monthNames,
            'amount' => array_values($expansesAmounts),
        ];

        return $result;
    }

    public function usrTotExpByType(String $selectedMonth, int $selectedYear)
    {
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
        
        $usrTotExpByType = Expense::select('type', DB::raw('SUM(amount) as total_amount'))
                                    ->where('user_id', auth()->id())
                                    ->join('expense_categories', 'expenses.expense_category_id', '=', 'expense_categories.id')
                                    ->whereMonth('expenses.date',  $monthNumber)
                                    ->whereYear('expenses.date', $selectedYear)
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

    public function usrTotExpBySubType(String $selectedMonth, int $selectedYear)
    {
        // Array mapping Italian month names to their corresponding month numbers
 

        // Convert the selected month name to its corresponding month number
        $monthNumber = $monthMap[$selectedMonth] ?? now()->format('m'); // Default to current month if not found
        
        $usrTotExpBySubType = Expense::select('subtype', DB::raw('SUM(amount) as total_amount'))
                                    ->where('user_id', auth()->id())
                                    ->join('expense_categories', 'expenses.expense_category_id', '=', 'expense_categories.id')
                                    ->whereMonth('expenses.date', $monthNumber)
                                    ->whereYear('expenses.date', $selectedYear)
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
            'expenses'      =>   $expenses,
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
