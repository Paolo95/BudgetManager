<?php

use App\Http\Controllers\CreditDebitController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DeadlineController;
use App\Http\Controllers\ExpenseCategoryController;
use App\Http\Controllers\ExpenseController;
use App\Http\Controllers\IncomingCategoryController;
use App\Http\Controllers\IncomingController;
use App\Http\Controllers\UserToDoController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware(['web'])->group (function () {
    
    Route::post('/updateToDo/{id}',                                 [UserToDoController::class, 'updateToDo']);

    Route::get('/expenses/getSubCategories/{categoria}',            [ExpenseCategoryController::class, 'expensesSubTypeListByCategory']);
    
    Route::post('/expenses/newExpense',                             [ExpenseController::class, 'newExpense']);
    Route::get('/expenses/searchExpense',                           [ExpenseController::class, 'searchExpenseByDateRange']);
    Route::get('/expenses/loadExpenseData/{expenseID}',             [ExpenseController::class, 'loadExpenseData']);
    Route::post('/expenses/deleteExpense/{expenseID}',              [ExpenseController::class, 'deleteExpense']);
    Route::post('/expenses/editExpense',                            [ExpenseController::class, 'editExpense']);
  
    
    Route::get('/incomings/getSubCategories/{categoria}',           [IncomingCategoryController::class, 'incomingsSubTypeListByCategory']);
    
    Route::post('/incomings/newIncoming',                           [IncomingController::class, 'newIncoming']);
    Route::get('/incomings/searchIncoming',                         [IncomingController::class, 'searchIncomingByDateRange']);
    Route::get('/incomings/loadIncomingData/{incomingID}',          [IncomingController::class, 'loadIncomingData']);
    Route::post('/incomings/deleteIncoming/{incomingID}',           [IncomingController::class, 'deleteIncoming']);
    Route::post('/incomings/editIncoming',                          [IncomingController::class, 'editIncoming']);

    Route::get('/deadlines/userDeadlines',                          [DeadlineController::class, 'userDeadlines']);
    Route::post('/deadlines/newDeadline',                           [DeadlineController::class, 'newDeadline']);
    Route::get('/deadlines/searchDeadline',                         [DeadlineController::class, 'searchDeadlineByDateRange']);
    Route::post('/deadlines/editDeadline',                          [DeadlineController::class, 'editDeadline']);
    Route::get('/deadlines/loadDeadlineData/{deadlineID}',          [DeadlineController::class, 'loadDeadlineData']);
    Route::post('/deadlines/deleteDeadline/{deadlineID}',           [DeadlineController::class, 'deleteDeadline']);

    Route::post('/creditDebits/newCreditDebit',                      [CreditDebitController::class, 'newCreditDebit']);
    Route::get('/creditDebits/searchCreditDebit',                    [CreditDebitController::class, 'searchCreditDebitByDateRange']);
    Route::get('/creditDebits/loadCreditDebitData/{creditDebitID}',  [CreditDebitController::class, 'loadCreditDebitData']);
    Route::post('/creditDebits/editCreditDebit',                     [CreditDebitController::class, 'editCreditDebit']);
    Route::post('/creditDebits/deleteCreditDebit/{creditDebitID}',   [CreditDebitController::class, 'deleteCreditDebit']);
});




