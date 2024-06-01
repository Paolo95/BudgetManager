<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\UserTodo;
use Illuminate\Http\Request;

class UserToDoController extends Controller
{
    public function getUserToDo()
    {

        $userToDo = UserTodo::select('id', 'title', 'amount', 'isDone')
                                    ->where('user_id', auth()->id())
                                    ->whereMonth('date', (int) now()->format('m'))
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
