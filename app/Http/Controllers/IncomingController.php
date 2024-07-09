<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Incoming;
use App\Models\IncomingCategory;
use Illuminate\Http\Request;
use Carbon\Carbon;

class IncomingController extends Controller
{
    public function userTotalIncomingsOnMount(String $selectedMonth): float
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

        // Query to get the user's total incomings for the specified month
        $userTotalIncomingsOnMount = Incoming::where('user_id', auth()->id())
                                            ->whereMonth('date', $monthNumber)
                                            ->sum('amount');

        return $userTotalIncomingsOnMount;
    }

    public function newIncoming(Request $request)
    {
      
        // Validate the request data
        $validatedData = $request->validate([
            'date' => 'required|date',
            'type' => 'required',
            'subtype' => 'required',
            'title' => 'required|max:255',
            'description' => 'nullable|max:255',
            'amount' => 'required|numeric|min:0',
        ]);
        
        $incomingCategoryController = new IncomingCategoryController();
        $incomingCategoryID = $incomingCategoryController->findIncomingCategoryID($validatedData['type'], $validatedData['subtype']);
    
        // Create a new Expense instance
        $incoming = new Incoming();
        $incoming->date = $validatedData['date'];
        $incoming->incoming_category_id = $incomingCategoryID;
        $incoming->user_id = auth()->id();
        $incoming->title = $validatedData['title'];
        $incoming->description = $validatedData['description'];
        $incoming->amount = $validatedData['amount'];
        
        
       
        // Save the expense
        $incoming->save();

        // Redirect or return a response as needed
        return redirect()->back()->with('message', 'Entrata inserita correttamente!');
    }

    public function searchIncomingByDateRange(Request $request)
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

        $incomings = Incoming::select('incomings.id', 'incomings.date', 'incomings.title', 'incomings.description', 'incomings.amount',
                                        'incoming_categories.type', 'incoming_categories.subtype')
                            ->whereBetween('incomings.date', [$startDate, $endDate])
                            ->join('incoming_categories', 'incomings.incoming_category_id', '=', 'incoming_categories.id')
                            ->orderby('incomings.date', 'DESC')
                            ->get();


        return redirect()->back()->with([
            'incomings'      =>  $incomings,
            'start_date'    =>   $startDate
        ]);

 
    }

    public function loadIncomingData(Request $request, $incomingID)
    {

        $incomingData = Incoming::select('incomings.id', 'incomings.date', 'incomings.title', 'incomings.description', 'incomings.amount',
                                        'incoming_categories.type', 'incoming_categories.subtype')
                                ->join('incoming_categories', 'incomings.incoming_category_id', '=', 'incoming_categories.id')
                                ->where('incomings.id', $incomingID)
                                ->first();
        

        return $incomingData;
    }

    public function editIncoming(Request $request)
    {
        
        // Validate the request data
        $validatedData = $request->validate([
            'id'            => 'required|integer',
            'date'          => 'required|date',
            'type'          => 'required',
            'subtype'       => 'required',
            'title'         => 'required|max:255',
            'description'   => 'nullable|max:255',
            'amount'        => 'required|numeric|min:0',
        ]);
  

        // Parse the date using Carbon
        $date = Carbon::parse($validatedData['date']);

        // Retrieve the expense record by ID
        $incoming = Incoming::findOrFail($validatedData['id']);

        // Update the expense attributes
        $incoming->date = $date;

        $categoryID = IncomingCategory::select('id')
                                        ->where('type',$validatedData['type'])
                                        ->where('subtype', $validatedData['subtype'])
                                        ->first();

        $incoming->incoming_category_id = $categoryID->id;

        $incoming->title        = $validatedData['title'];
        $incoming->description   = $validatedData['description'];
        $incoming->amount        = $validatedData['amount'];

        // Save the updated record to the database
        $incoming->save();

        // You can return a response, such as a redirect or a JSON response
        return redirect()->back()->with('message', 'Entrata modificata correttamente!');
    }

    public function deleteIncoming(Request $request)
    {
        $incomingID = $request->input('id');
    
        // Retrieve the expense record by ID
        $incoming = Incoming::findOrFail($incomingID);
    
        // Delete the expense record
        $incoming->delete();
    
        // Return a response, such as a redirect or a JSON response
        return response()->json(['message' => 'Incoming deleted successfully'], 200);
    }
}
