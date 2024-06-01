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
}
