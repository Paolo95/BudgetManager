<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\CreditDebit;
use Illuminate\Http\Request;

class CreditDebitController extends Controller
{
    public function userCreditDebitOnLastMonth()
    {
        
        $userCreditDebitOnLastMonth = CreditDebit::select('date', 'type', 'description' ,'amount')
                                                    ->where('user_id', auth()->id())
                                                    ->whereMonth('date', (int) now()->format('m'))
                                                    ->orderBy('amount', 'desc')
                                                    ->get();
     
       return $userCreditDebitOnLastMonth;
    }
}
