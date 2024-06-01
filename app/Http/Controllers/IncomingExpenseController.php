<?php

namespace App\Http\Controllers;

use App\Models\Expense;
use App\Models\Incoming;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class IncomingExpenseController extends Controller
{
    public function incomingExpenseUnion(){
        $currentMonth = now()->format('m');

        $incomingResults = Incoming::where('user_id', auth()->id())
            ->whereMonth('incomings.date', $currentMonth) 
            ->select('incomings.date as union_date', 'incomings.title', 'incomings.description as description', 'incomings.amount', 'incoming_categories.type as category', 'incoming_categories.subtype as subcategory')
            ->join('incoming_categories', 'incomings.incoming_category_id', '=', 'incoming_categories.id')
            ->addSelect(Incoming::raw("'Entrata' as identifier"));

        $expenseResults = Expense::where('user_id', auth()->id())
            ->whereMonth('expenses.date', $currentMonth) 
            ->select('expenses.date as union_date', 'expenses.title', 'expenses.description as description', 'expenses.amount', 'expense_categories.type as category', 'expense_categories.subtype as subcategory')
            ->join('expense_categories', 'expenses.expense_category_id', '=', 'expense_categories.id')
            ->addSelect(Expense::raw("'Uscita' as identifier"));

        $results = $incomingResults->union($expenseResults)->orderBy('union_date', 'desc')->limit(10)->get();

        return $results->all();

    }
}
