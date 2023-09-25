<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;use Illuminate\Support\Facades\Storage;

class CategoryController extends Controller
{
    public function index(Request $request){
        $categories=Category::latest();

        if(!empty($request->get('keyword'))){ 
            $categories=$categories->where('name','like','%'.$request->get('keyword') .'%');
        }
        $categories=$categories->paginate(10);
        $data['categories'] =$categories;
        return view('admin.Category.list', compact('categories'));

    }
    public function create(){
        return view('admin.Category.create');
    }
    public function update( $id){
        // Retrieve the category we want to update from the database
        $category = Category::find($id);
        return view('admin.Category.update', compact('category'));
    
        // Check if the category exists
        if (!$category) {
            return redirect()->route('categories.index')->with('error', 'Category not found');
        }
    
    }
    
    public function edit(Request $request,$id){
        $category = Category::find($id);
      
        // Check if the category exists
        if (!$category) {
            return redirect()->route('categories.index')->with('error', 'Category not found');
        }
    
        $validator = Validator::make($request->all(), [
            'name' => 'required|unique:categories,name,' . $category->id,
            'slug' => 'required',
            'status' => 'required|in:1,2',
            'image-upload' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048'
            
        ]);
    
        if ($validator->fails()) {
            return redirect()->route('categories.update', ['id' => $category->id])
                ->withErrors($validator)
                ->withInput();
        }
    
        // Update category data
        $category->name = $request->input('name');
        $category->slug = $request->input('slug');
        $category->status = $request->input('status');
        $category->show = $request->input('show');
        if ($request->hasFile('image-upload')) {
            $image = $request->file('image-upload');
            $imageName = time().'.'.$image->extension();
            $image->move(public_path('images'), $imageName);
            $category->image = $imageName;
        }
    
        $category->save();
    
        return redirect()->route('categories.index')->with('message', 'Category updated successfully');
        
    }


    public function store(Request $request){
        $validator = Validator::make($request->all(), [
            'name' => 'required|unique:categories',
            'slug' => 'required',
            'status' => 'required|in:1,2',
            'image-upload' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);
    
        if ($validator->fails()) {
            return redirect()->route('categories.create')
                ->withErrors($validator)
                ->withInput();
        }
    
        $category = new Category();
        $category->name = $request->input('name');
        //$category->slug = $request->input('slug');
        $category->slug = Str::slug($request->input('name'));
        $category->status = $request->input('status');
        $category->show = $request->input('show');
    
        // Handle the file upload (assuming 'image-upload' is a file input)
        if ($request->hasFile('image-upload')) {
            $image = $request->file('image-upload');
            $imageName = time().'.'.$image->extension();
            $image->move(public_path('images'), $imageName);
            $category->image = $imageName;
        }
        $category->save();
        
        return redirect()->route('categories.create')->with('message', 'Category created successfully');
    }

    public function destroy($id){
        $category=Category::find($id);

        // Check if the category exists
        if (!$category) {
            return redirect()->route('categories.index')->with('error', 'Category not found');
        }

        // Delete the associated image file from storage (assuming it's stored in the public directory)
        if ($category->image) {
            Storage::delete('public/images' . $category->image);
        }

        // Delete the category
        $category->delete();

        return redirect()->route('categories.index')->with('message', 'Category deleted successfully');
        
    }
}
