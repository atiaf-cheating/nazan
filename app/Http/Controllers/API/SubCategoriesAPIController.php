<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\SubCategory;
use Illuminate\Http\Request;

class SubCategoriesAPIController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $allSubCategories = SubCategory::where('active',1)->where('deleted_at',null)->paginate(8);
        if(!$allSubCategories){
            return response()->json(['message' => ' SUB CATEGORIES NOT FOUND'], 400);
        }
        return response()->json([
            'subCategories'=>$allSubCategories
        ],200);

    }
}
