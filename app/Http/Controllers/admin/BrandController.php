<?php

namespace App\Http\Controllers\admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Brand;
use Illuminate\Support\Facades\Validator;

class BrandController extends Controller
{
    public function index(Request $request){
        $brands=Brand::latest();

        if(!empty($request->get('keyword'))){ 
            $brands=$brands->where('name','like','%'.$request->get('keyword') .'%');
        }
        $brands=$brands->paginate(10);
        $data['brands'] =$brands;
        return view('admin.Brand.list', compact('brands'));

    }
    public function create(){
        return view('admin.Brand.create');
    }
    public function update( $id){
        // Retrieve the Brand we want to update from the database
        $Brand = Brand::find($id);
        return view('admin.Brand.update', compact('Brand'));
    
        // Check if the Brand exists
        if (!$Brand) {
            return redirect()->route('brands.index')->with('error', 'Brand not found');
        }
    
    }
    
    public function edit(Request $request,$id){
        $Brand = Brand::find($id);
      
        // Check if the Brand exists
        if (!$Brand) {
            return redirect()->route('brands.index')->with('error', 'Brand not found');
        }
    
        $validator = Validator::make($request->all(), [
            'name' => 'required|unique:brands,name,' . $Brand->id,
            'slug' => 'required',
            'status' => 'required|in:1,2',
            
            
        ]);
    
        if ($validator->fails()) {
            return redirect()->route('brands.update', ['id' => $Brand->id])
                ->withErrors($validator)
                ->withInput();
        }
    
        // Update Brand data
        $Brand->name = $request->input('name');
        $Brand->slug = $request->input('slug');
        $Brand->status = $request->input('status');
    
        $Brand->save();
    
        return redirect()->route('brands.index')->with('message', 'Brand updated successfully');
        
    }


    public function store(Request $request){
        $validator = Validator::make($request->all(), [
            'name' => 'required|unique:brands',
            'slug' => 'required',
            'status' => 'required|in:1,2',
        ]);
    
        if ($validator->fails()) {
            return redirect()->route('brands.create')
                ->withErrors($validator)
                ->withInput();
        }
    
        $Brand = new Brand();
        $Brand->name = $request->input('name');
        //$Brand->slug = $request->input('slug');
        $Brand->slug = $request->input('slug');
        $Brand->status = $request->input('status');

        $Brand->save();
        
        return redirect()->route('brands.create')->with('message', 'Brand created successfully');
    }

    public function destroy($id){
        $Brand=Brand::find($id);

        // Check if the Brand exists
        if (!$Brand) {
            return redirect()->route('brands.index')->with('error', 'Brand not found');
        }


        // Delete the Brand
        $Brand->delete();

        return redirect()->route('brands.index')->with('message', 'Brand deleted successfully');
        
    }
}
