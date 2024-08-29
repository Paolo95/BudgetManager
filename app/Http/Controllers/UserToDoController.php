<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\UserTodo;
use Illuminate\Http\Request;

class UserToDoController extends Controller
{
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
