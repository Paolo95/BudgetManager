<?php

namespace App\Http\Controllers;

use App\Models\Listing;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class BudgetController extends Controller
{

    public function index() {
        return view('home');
    }

    public function dashboard() {
        return view('dashboard.dashbaord');
    }
}