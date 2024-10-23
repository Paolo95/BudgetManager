<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Target;
use Illuminate\Http\Request;

class TargetController extends Controller
{
    public function getTarget()
    {
    
        $usrTarget = Target::select()
                            ->where('user_id', auth()->id())
                            ->first();

        if (!$usrTarget) {
            return response()->json(['message' => 'Il target non esiste!'], 404);
        }

        // Return a success response
        return $usrTarget->amount;
    }

    public function updateTarget(Request $request)
    {
       
        // Validate the request data
        $validatedData = $request->validate([
            'userTarget' => 'required|integer'
        ]);

    
        $usrTarget = Target::select()
                            ->where('user_id', auth()->id())
                            ->first();

        if (!$usrTarget) {
            return response()->json(['message' => 'Il target non esiste!'], 404);
        }

        try {
            // Update the isDone status
            $usrTarget->amount = $validatedData['userTarget'];
            $usrTarget->save();
        } catch (\Exception $e) {
            // Return a 500 error response if there is an exception
            return response()->json(['message' => 'ERRORE: Operazione non riuscita!', 'error' => $e->getMessage()], 500);
        }
    
        // Return a success response
        return redirect()->back()->with('message', 'Target modificato correttamente!');   
    }
}
