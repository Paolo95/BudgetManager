<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\IncomingCategory;
use Illuminate\Http\Request;

class IncomingCategoryController extends Controller
{
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
}
