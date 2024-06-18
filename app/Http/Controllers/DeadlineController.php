<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Deadline;
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

}
