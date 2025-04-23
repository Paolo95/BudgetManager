<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\UserTodo;
use Illuminate\Http\Request;
use Carbon\Carbon;

class UserToDoController extends Controller
{

    public function searchToDoByDateRange(Request $request)
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

        $todos = UserTodo::select('id', 'date', 'title', 'amount', 'isDone')
                            ->whereBetween('date', [$startDate, $endDate])
                            ->orderby('date', 'DESC')
                            ->get();


        return redirect()->back()->with([
            'todos'         =>   $todos,
            'start_date'    =>   $startDate
        ]);

 
    }

    public function newToDo(Request $request)
    {
        
        $validatedData = $request->validate([
            'title' => 'required|string',
            'amount' => 'required|numeric'
        ]);

        $toDo = new UserTodo();
        $toDo->title = $validatedData['title'];
        $toDo->date = now();
        $toDo->amount = $validatedData['amount'];
        $toDo->isdone = false;
        $toDo->user_id = auth()->id();

        try{
            $toDo->save();
        } catch (\Exception $e) {
            // Return a 500 error response if there is an exception
            return response()->json(['message' => 'ERRORE: Operazione non riuscita!', 'error' => $e->getMessage()], 500);
        }
        

        return redirect()->back()->with(['message' => 'Inserimento eseguito correttamente!']);

    }

    public function loadToDoData(Request $request, $todoID)
    {

        $toDoData = UserTodo::select('id', 'date', 'title', 'amount', 'isDone')
                                ->where('id', $todoID)
                                ->first();
        

        return $toDoData;
    }

    public function editToDo(Request $request)
    {
        
        // Validate the request data
        $validatedData = $request->validate([
            'id'            => 'required|integer',
            'date'          => 'required|date',
            'title'         => 'required|max:255',
            'isDone'        => 'nullable|integer',
            'amount'        => 'required|numeric|min:0',
        ]);   

        // Parse the date using Carbon
        $date = Carbon::parse($validatedData['date']);

        // Retrieve the expense record by ID
        $toDo = UserTodo::findOrFail($validatedData['id']);

        // Update the expense attributes
        $toDo->date         = $date;
        $toDo->title        = $validatedData['title'];
        $toDo->isdone       = $validatedData['isDone'];
        $toDo->amount       = $validatedData['amount'];

        // Save the updated record to the database
        $toDo->save();

        // You can return a response, such as a redirect or a JSON response
        return redirect()->back()->with('message', 'Spesa da fare modificata correttamente!');
    }

    public function deleteToDo(Request $request)
    {
        $toDoID = $request->input('id');
    
        // Retrieve the expense record by ID
        $toDo = UserTodo::findOrFail($toDoID);
    
        // Delete the expense record
        $toDo->delete();
    
        // Return a response, such as a redirect or a JSON response
        return response()->json(['message' => 'To Do deleted successfully'], 200);
    }

    public function getUserToDo(String $selectedMonth, int $selectedYear)
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

        $userToDo = UserTodo::select('id', 'title', 'amount', 'isDone')
                                    ->where('user_id', auth()->id())
                                    ->whereMonth('date', $monthNumber)
                                    ->whereYear('date', $selectedYear)
                                    ->get();

        return $userToDo;
    }

    public function updateToDo(Request $request, $id)
    {
        // Validate the input        
        $request->validate([
            'isDone' => 'required|boolean',
        ]);

        // Find the ToDo item by ID
        $todo = UserTodo::find($id);

        if (!$todo) {
            return response()->json(['message' => 'La spesa non esiste!'], 404);
        }

        try {
            // Update the isDone status
            $todo->isDone = $request->isDone;
            $todo->save();
        } catch (\Exception $e) {
            // Return a 500 error response if there is an exception
            return response()->json(['message' => 'ERRORE: Operazione non riuscita!', 'error' => $e->getMessage()], 500);
        }
    
        // Return a success response
        return response()->json(['message' => 'Operazione eseguita correttamente!']);
    }

    
}
