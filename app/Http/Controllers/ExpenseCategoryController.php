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

    public function newExpenseSubCategory(Request $request)
    {
        // Validate the request data
        $validatedData = $request->validate([
            'type' => 'required',
            'subtype' => 'required',
            'description' => 'nullable|max:255',
        ]);
    
        $expenseCategory = new ExpenseCategory();    

        $expenseCategory->type = $validatedData['type'];
        $expenseCategory->subtype = $validatedData['subtype'];
        $expenseCategory->description = $validatedData['description'];   
    
        // Save the expense
        $expenseCategory->save();

        // Redirect or return a response as needed
        return redirect()->back()->with('message', 'Categoria inserita correttamente!');
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

    public function expenseCategoryList()
    {
        $expenseCategoryList = ExpenseCategory::all();

        return redirect()->back()->with([
            'expenseCategories'       =>   $expenseCategoryList,
            'selectedValue'           =>   'Spese'
        ]);
        
    }

    public function expenseCategoryDetails($id)
    {
        $expenseCategoryDetails = ExpenseCategory::select()
                                ->where('id', $id)
                                ->first();

        return $expenseCategoryDetails;
    }

    public function editExpenseCategory(Request $request)
    {
        
        // Validate the request data
        $validatedData = $request->validate([
            'id'            => 'required|integer',
            'type'          => 'required',
            'subtype'       => 'required',
            'description'   => 'nullable|max:255'
        ]); 


        // Retrieve the expense record by ID
        $expenseCategory = ExpenseCategory::findOrFail($validatedData['id']);

        $expenseCategory->id                 = $validatedData['id'];
        $expenseCategory->type               = $validatedData['type'];
        $expenseCategory->subtype            = $validatedData['subtype'];
        $expenseCategory->description        = $validatedData['description'];

        // Save the updated record to the database
        $expenseCategory->save();

        // You can return a response, such as a redirect or a JSON response
        return redirect()->back()->with('message', 'Categoria modificata correttamente!');
    }

    public function deleteExpenseCategory(Request $request)
    {
        $categoryID = $request->input('id');
    
        // Retrieve the expense record by ID
        $category = ExpenseCategory::findOrFail($categoryID);
    
        // Delete the expense record
        $category->delete();
    
        // Return a response, such as a redirect or a JSON response
        return response()->json(['message' => 'Category deleted successfully'], 200);
    }
}
