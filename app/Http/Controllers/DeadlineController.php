<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Deadline;
use Carbon\Carbon;
use Illuminate\Http\Request;

class DeadlineController extends Controller
{
    public function userDeadlines()
    {
        $userDeadlines = Deadline::where('user_id', auth()->id())                                            
                                    ->get();

    
        if ($userDeadlines->isEmpty()) {
            return response()->json(['message' => 'No deadlines found for this user.'], 200);
        }

        return response()->json($userDeadlines, 200);
    }

    public function userDeadlinesSummary()
    {
        $userDeadlines = Deadline::selectRaw('deadlines.date, deadlines.title, deadlines.amount, sum(deadlines.amount)-sum(expenses.amount) as remaining')
                                    ->join('expenses', 'expenses.deadline_id', '=', 'deadlines.id' )
                                    ->where('deadlines.user_id', auth()->id())
                                    ->groupby('deadlines.id', 'deadlines.date', 'deadlines.title', 'deadlines.amount')
                                    ->orderBy('deadlines.amount', 'desc')
                                    ->get();
        
        
        if ($userDeadlines->isEmpty()) {
            return response()->json(['message' => 'No deadlines found for this user.'], 200);
        }

        $result = [];

        foreach ($userDeadlines as $item) {
            $result[] = [
                'date' => $item->date,
                'title' => $item->title,
                'amount' => $item->amount,
                'remaining' => $item->remaining,
            ];
        }

        return $result;
    }

    public function newDeadline(Request $request)
    {
      
        // Validate the request data
        $validatedData = $request->validate([
            'date' => 'required|date',
            'title' => 'required|max:255',
            'description' => 'nullable|max:255',
            'amount' => 'required|numeric|min:0',
        ]);
    
        // Create a new Deadline instance
        $deadline = new Deadline();
        $deadline->date = $validatedData['date'];
        $deadline->user_id = auth()->id();
        $deadline->title = $validatedData['title'];
        $deadline->description = $validatedData['description'];
        $deadline->amount = $validatedData['amount'];
              
        // Save the deadline
        $deadline->save();

        // Redirect or return a response as needed
        return redirect()->back()->with('message', 'Scadenza inserita correttamente!');
    }

    public function searchDeadlineByDateRange(Request $request)
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

        $deadlines = Deadline::select()
                            ->whereBetween('deadlines.date', [$startDate, $endDate])
                            ->orderby('deadlines.date', 'DESC')
                            ->get();


        return redirect()->back()->with([
            'deadlines'      =>  $deadlines,
            'start_date'    =>   $startDate
        ]);

 
    }

    public function loadDeadlineData(Request $request, $deadlineID)
    {

        $deadlineData = Deadline::select()
                                ->where('deadlines.id', $deadlineID)
                                ->first();
        

        return $deadlineData;
    }

    public function editDeadline(Request $request)
    {
        
        // Validate the request data
        $validatedData = $request->validate([
            'id'            => 'required|integer',
            'date'          => 'required|date',
            'title'         => 'required|max:255',
            'description'   => 'nullable|max:255',
            'amount'        => 'required|numeric|min:0',
        ]);

   

        // Parse the date using Carbon
        $date = Carbon::parse($validatedData['date']);

        // Retrieve the expense record by ID
        $deadline = Deadline::findOrFail($validatedData['id']);

        // Update the expense attributes
        $deadline->date = $date;

        $deadline->title        = $validatedData['title'];
        $deadline->description   = $validatedData['description'];
        $deadline->amount        = $validatedData['amount'];

        // Save the updated record to the database
        $deadline->save();

        // You can return a response, such as a redirect or a JSON response
        return redirect()->back()->with('message', 'Scadenza modificata correttamente!');
    }

    public function deleteDeadline(Request $request)
    {
        $deadlineID = $request->input('id');
    
        // Retrieve the expense record by ID
        $deadline = Deadline::findOrFail($deadlineID);
    
        // Delete the expense record
        $deadline->delete();
    
        // Return a response, such as a redirect or a JSON response
        return response()->json(['message' => 'Deadline deleted successfully'], 200);
    }

    

}
