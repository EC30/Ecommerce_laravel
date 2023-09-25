<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use App\Models\SubCategory;

class SubCategoryController extends Controller
{
    public function index(Request $request){
        $subcategory=SubCategory::latest();

        if(!empty($request->get('keyword'))){ 
            $subcategory=$subcategory->where('name','like','%'.$request->get('keyword') .'%');
        }
        $subcategory=$subcategory->paginate(10);
        $data['subcategory'] =$subcategory;
        return view('admin.SubCategory.list', compact('subcategory'));

    }
    public function create(){
        $categories=Category::orderBy('name', 'ASC')->get();
        $data['categories']=$categories;
        return view('admin.SubCategory.create',$data);
    }

    public function store(Request $request){
        $validator = Validator::make($request->all(), [
            'name' => 'required|unique:subcategory',
            'slug' => 'required',
            'status' => 'required|in:1,2',
            'category'=>'required'
        ]);
    
        if ($validator->fails()) {
            return redirect()->route('subcategory.create')
                ->withErrors($validator)
                ->withInput();
        }
    
        $subcategory = new SubCategory();
        $subcategory->name = $request->input('name');
        $subcategory->slug = $request->input('slug');
        $subcategory->status = $request->input('status');
        $subcategory->category_id = $request->input('category');
        $subcategory->show = $request->input('show');
    

        $subcategory->save();
        
        return redirect()->route('subcategory.create')->with('message', 'SubCategory created successfully');
    }

    public function destroy($id){
        $subcategory=SubCategory::find($id);

        // Check if the category exists
        if (!$subcategory) {
            return redirect()->route('subcategory.index')->with('error', 'Category not found');
        }

        // Delete the category
        $subcategory->delete();

        return redirect()->route('subcategory.index')->with('message', 'Sub Category deleted successfully');
        
    }

    public function update( $id){
        $categories=Category::orderBy('name', 'ASC')->get();
        $data['categories']=$categories;
        // Retrieve the category we want to update from the database
        $subcategory = SubCategory::find($id);
        return view('admin.SubCategory.update', compact('subcategory', 'categories'));
    
        // Check if the category exists
        if (!$subcategory) {
            return redirect()->route('subcategory.index')->with('error', 'Sub Category not found');
        }
    
    }
    
    public function edit(Request $request,$id){
        $subcategory = SubCategory::find($id);
      
        // Check if the category exists
        if (!$subcategory) {
            return redirect()->route('subcategory.index')->with('error', 'Sub Category not found');
        }
    
        $validator = Validator::make($request->all(), [
            'name' => 'required|unique:categories,name,' . $subcategory->id,
            'slug' => 'required',
            'status' => 'required|in:1,2',
            'category'=>'required'
            
        ]);
    
        if ($validator->fails()) {
            return redirect()->route('subcategory.update', ['id' => $subcategory->id])
                ->withErrors($validator)
                ->withInput();
        }
    
        // Update category data
        $subcategory->name = $request->input('name');
        $subcategory->slug = $request->input('slug');
        $subcategory->status = $request->input('status');
        $subcategory->category_id = $request->input('category');
        $subcategory->show = $request->input('show');
       
        $subcategory->save();
    
        return redirect()->route('subcategory.index')->with('message', 'Category updated successfully');
        
    }


}
