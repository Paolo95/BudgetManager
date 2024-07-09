<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\CreditDebit;
use Carbon\Carbon;
use Illuminate\Http\Request;

class CreditDebitController extends Controller
{
    public function userCreditDebitOnMonth(String $selectedMonth)
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

        $userCreditDebitOnLastMonth = CreditDebit::select('date', 'type', 'description' ,'amount')
                                                    ->where('user_id', auth()->id())
                                                    ->whereMonth('date', $monthNumber)
                                                    ->orderBy('amount', 'desc')
                                                    ->get();
     
       return $userCreditDebitOnLastMonth;
    }

    public function newCreditDebit(Request $request)
    {
      
        // Validate the request data
        $validatedData = $request->validate([
            'date' => 'required|date',
            'type' => 'required',
            'description' => 'required|max:255',
            'amount' => 'required|numeric|min:0',
        ]);
        
    
        // Create a new Expense instance
        $creditDebit = new CreditDebit();
        $creditDebit->date = $validatedData['date'];
        $creditDebit->user_id = auth()->id();
        $creditDebit->type = $validatedData['type'];
        $creditDebit->description = $validatedData['description'];
        $creditDebit->amount = $validatedData['amount'];        
       
        // Save the expense
        $creditDebit->save();

        // Redirect or return a response as needed
        return redirect()->back()->with('message', 'Credito/Debito inserito correttamente!');
    }

    public function searchCreditDebitByDateRange(Request $request)
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

        $creditDebits = CreditDebit::select()
                            ->whereBetween('credit_Debits.date', [$startDate, $endDate])
                            ->orderby('credit_Debits.date', 'DESC')
                            ->get();


        return redirect()->back()->with([
            'creditDebits'  =>  $creditDebits,
            'start_date'    =>   $startDate
        ]);

 
    }

    public function loadCreditDebitData(Request $request, $creditDebitID)
    {

        $creditDebitData = CreditDebit::select()
                                ->where('credit_debits.id', $creditDebitID)
                                ->first();
        

        return $creditDebitData;
    }

    public function editCreditDebit(Request $request)
    {
        
        // Validate the request data
        $validatedData = $request->validate([
            'id'            => 'required|integer',
            'date'          => 'required|date',
            'type'          => 'required',
            'description'   => 'required|max:255',
            'amount'        => 'required|numeric|min:0',
        ]);

   

        // Parse the date using Carbon
        $date = Carbon::parse($validatedData['date']);

        // Retrieve the expense record by ID
        $creditDebit = CreditDebit::findOrFail($validatedData['id']);

        // Update the expense attributes
        $creditDebit->date          = $date;
        $creditDebit->type          = $validatedData['type'];
        $creditDebit->description   = $validatedData['description'];
        $creditDebit->amount        = $validatedData['amount'];

        // Save the updated record to the database
        $creditDebit->save();

        // You can return a response, such as a redirect or a JSON response
        return redirect()->back()->with('message', 'Credo/Debito modificato correttamente!');
    }

    public function deleteCreditDebit(Request $request)
    {
        $creditDebitID = $request->input('id');
    
        // Retrieve the expense record by ID
        $creditDebit = CreditDebit::findOrFail($creditDebitID);
    
        // Delete the expense record
        $creditDebit->delete();
    
        // Return a response, such as a redirect or a JSON response
        return response()->json(['message' => 'Credit/Debit deleted successfully'], 200);
    }

}
