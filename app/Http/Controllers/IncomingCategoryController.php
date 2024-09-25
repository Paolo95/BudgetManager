<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\IncomingCategory;
use Illuminate\Http\Request;

class IncomingCategoryController extends Controller
{
    public function newIncomingSubCategory(Request $request)
    {
        // Validate the request data
        $validatedData = $request->validate([
            'type' => 'required',
            'subtype' => 'required',
            'description' => 'nullable|max:255',
        ]);
    
        $incomingCategory = new IncomingCategory();    

        $incomingCategory->type = $validatedData['type'];
        $incomingCategory->subtype = $validatedData['subtype'];
        $incomingCategory->description = $validatedData['description'];   
    
        // Save the expense
        $incomingCategory->save();

        // Redirect or return a response as needed
        return redirect()->back()->with('message', 'Categoria inserita correttamente!');
    }

    public function incomingsSubTypeListByCategory($categoria)
    {
        $incomingsSubTypeListByCategory = IncomingCategory::select('id', 'subtype')
                                        ->where('type', $categoria)
                                        ->orderBy('type', 'desc')
                                        ->get();
        
        return response()->json($incomingsSubTypeListByCategory);
    }

    public function findIncomingCategoryID($type, $subtype) : int
    {
        $incomingCategoryID = IncomingCategory::select('id')
                                        ->where('type', $type)
                                        ->where('subtype', $subtype)
                                        ->first();
        
        return $incomingCategoryID->id;
    }

    public function incomingCategoryList()
    {
        $incomingCategoryList = IncomingCategory::all();

        return redirect()->back()->with([
            'incomingCategories'       =>   $incomingCategoryList,
            'selectedValue'           =>   'Entrate'
        ]);
        
    }

    public function incomingCategoryDetails($id)
    {
        $incomingCategoryDetails = IncomingCategory::select()
                                ->where('id', $id)
                                ->first();

        return $incomingCategoryDetails;
    }

    public function editIncomingCategory(Request $request)
    {
            
        // Validate the request data
        $validatedData = $request->validate([
            'id'            => 'required|integer',
            'type'          => 'required',
            'subtype'       => 'required',
            'description'   => 'nullable|max:255'
        ]); 


        // Retrieve the incoming record by ID
        $incomingCategory = IncomingCategory::findOrFail($validatedData['id']);

        $incomingCategory->id                 = $validatedData['id'];
        $incomingCategory->type               = $validatedData['type'];
        $incomingCategory->subtype            = $validatedData['subtype'];
        $incomingCategory->description        = $validatedData['description'];

        // Save the updated record to the database
        $incomingCategory->save();

        // You can return a response, such as a redirect or a JSON response
        return redirect()->back()->with('message', 'Categoria modificata correttamente!');    
    }

    public function deleteIncomingCategory(Request $request)
    {
        $categoryID = $request->input('id');
    
        // Retrieve the expense record by ID
        $category = IncomingCategory::findOrFail($categoryID);
    
        // Delete the expense record
        $category->delete();
    
        // Return a response, such as a redirect or a JSON response
        return response()->json(['message' => 'Category deleted successfully'], 200);
    }
}
