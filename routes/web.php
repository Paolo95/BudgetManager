<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ExpenseController;
use App\Http\Controllers\UserToDoController;

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

Route::get('/dashboard/new_expense', [DashboardController::class, 'insertExpense'])->middleware('auth');

Route::get('/dashboard/new_incoming', [DashboardController::class, 'insertIncoming'])->middleware('auth');

Route::post('/new_expense', [ExpenseController::class, 'createExpense'])->middleware('auth');
