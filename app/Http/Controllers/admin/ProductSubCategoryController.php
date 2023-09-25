<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SubCategory;

class ProductSubCategoryController extends Controller
{
    public function index(Request $request)
    {
        // Fetch subcategories based on the selected category ID
        if(!empty($request->category_id)){
            $subcategories = Subcategory::where('category_id', $request->category_id)->orderBy('name','ASC')->get();
            return response()->json([
                'status'=>true,
                'subCategories'=>$subcategories
            ]);
                
        }else{
            return response()->json([
                'status'=>true,
                'subCategories'=>[]
            ]);
        }

    }

}
