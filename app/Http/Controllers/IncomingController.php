<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Incoming;
use Illuminate\Http\Request;

class IncomingController extends Controller
{
    public function userTotalIncomingsOnLastMount(): float
    {
        $userTotalIncomingsOnLastMount = Incoming::where('user_id', auth()->id())
                                            ->whereMonth('date', (int) now()->format('m'))
                                            ->sum('amount');
        
        return $userTotalIncomingsOnLastMount;
    }
}
