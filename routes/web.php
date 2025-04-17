<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\SummaryController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', [DashboardController::class, 'index']);

Route::get('/login', [UserController::class, 'login'])->name('login')->middleware('guest');

Route::post('/logout', [UserController::class, 'logout'])->middleware('auth');

Route::get('/register', [UserController::class, 'create'])->middleware('guest');

Route::post('/users', [UserController::class, 'store']);

Route::post('/users/authenticate', [UserController::class, 'authenticate']);

Route::get('/dashboard/home', [DashboardController::class, 'dashboard'])->middleware('auth');

Route::get('/dashboard/expenses/new_expense', [DashboardController::class, 'insertExpense'])->middleware('auth');

Route::get('/dashboard/expenses/edit_expense', [DashboardController::class, 'editExpense'])->middleware('auth');

Route::get('/dashboard/incomings/new_incoming', [DashboardController::class, 'insertIncoming'])->middleware('auth');

Route::get('/dashboard/incomings/edit_incoming', [DashboardController::class, 'editIncoming'])->middleware('auth');

Route::get('/dashboard/deadlines/new_deadline', [DashboardController::class, 'insertDeadline'])->middleware('auth');

Route::get('/dashboard/deadlines/edit_deadline', [DashboardController::class, 'editDeadline'])->middleware('auth');

Route::get('/dashboard/creditDebits/new_creditDebit', [DashboardController::class, 'insertCreditDebits'])->middleware('auth');

Route::get('/dashboard/creditDebits/edit_creditDebit', [DashboardController::class, 'editCreditDebits'])->middleware('auth');

Route::get('/dashboard/categories/new_category', [DashboardController::class, 'newCategory'])->middleware('auth');

Route::get('/dashboard/categories/edit_category', [DashboardController::class, 'editCategory'])->middleware('auth');

Route::get('/dashboard/summary', [SummaryController::class, 'summary'])->middleware('auth');

Route::redirect('/dashboard', '/dashboard/home');

