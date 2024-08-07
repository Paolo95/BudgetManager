<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ExpenseCategory;
use App\Http\Controllers\Controller;

class ExpenseCategoryController extends Controller
{
    function list(){
        return ExpenseCategory::all();
    }

    public function expensesSubTypeListByCategory($categoria)
    {
        $expensesSubTypeListByCategory = ExpenseCategory::select('id', 'subtype')
                                        ->where('type', $categoria)
                                        ->orderBy('type', 'desc')
                                        ->get();
        
        return response()->json($expensesSubTypeListByCategory);
    }

    public function findExpenseCategoryID($type, $subtype) : int
    {
        $expenseCategoryID = ExpenseCategory::select('id')
                                        ->where('type', $type)
                                        ->where('subtype', $subtype)
                                        ->first();
        
        return $expenseCategoryID->id;
    }
}
