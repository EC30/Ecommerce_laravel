<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;
use App\Models\Brand;
use App\Models\SubCategory;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
    public function index(Request $request){
        $products=Product::latest();

        if(!empty($request->get('keyword'))){ 
            $products=$products->where('title','like','%'.$request->get('keyword') .'%');
        }
        $products=$products->paginate(10);
        $data['products'] =$products;
        return view('admin.Product.list', compact('products'));

    }
    public function create(){
        $categories=Category::orderBy('name', 'ASC')->get();
        $data['categories']=$categories;
        $brands=Brand::orderBy('name', 'ASC')->get();
        $data2['brands']=$brands;
        return view('admin.Product.create', $data, $data2);
    }
    public function update( $id){
        // Retrieve the Product we want to update from the database
        $product = Product::find($id);
        $categories=Category::orderBy('name', 'ASC')->get();
        $data['categories']=$categories;
        $brands=Brand::orderBy('name', 'ASC')->get();
        $data2['brands']=$brands;
        // Retrieve the category we want to update from the database
        $subcategory = SubCategory::find($id);
        return view('admin.Product.update', compact('product', 'categories', 'brands'));
    
        // Check if the Product exists
        if (!$product) {
            return redirect()->route('products.index')->with('error', 'Product not found');
        }
    
    }
    

    public function edit(Request $request, $id)
    {
        $product = Product::find($id);
        
        // Check if the Product exists
        if (!$product) {
            return redirect()->route('products.index')->with('error', 'Product not found');
        }
    
        $rules = [
            'title' => 'required|unique:products,title,' . $product->id,
            'slug' => 'required',
            'price' => 'required|numeric',
            'status' => 'required|in:1,2',
            'category' => 'required|numeric',
            'sku' => 'required|numeric',
            'track_quantity' => 'required|in:Yes,No',
            'is_featured' => 'required|in:Yes,No',
        ];
    
        if (!empty($request->track_quantity) && $request->track_quantity == 'Yes') {
            $rules['quantity'] = 'required|numeric';
        }
    
        $validator = Validator::make($request->all(), $rules);
    
        if ($validator->fails()) {
            return redirect()->route('products.edit', $id)
                ->withErrors($validator)
                ->withInput();
        }
    
        // Update the product properties based on the request data
        $product->title = $request->input('title');
        $product->slug = $request->input('slug');
        $product->description = $request->input('description');
        $product->price = $request->input('price');
        $product->compare_price = $request->input('compare_price');
        $product->category_id = $request->input('category');
        $product->subcategory_id = $request->input('sub_category');
        $product->brand_id = $request->input('brand');
        $product->is_featured = $request->input('is_featured');
        $product->sku = $request->input('sku');
        $product->barcode = $request->input('barcode');
        $product->track_quantity = $request->input('track_quantity');
        
        // Fetch subcategory data from the request and assign it
        $subcategory = $request->input('subcategory');
        $product->subcategory_id = $subcategory;
    
        if ($request->track_quantity == 'Yes') {
            $product->quantity = $request->input('quantity');
        }
    
        $product->status = $request->input('status');
        $product->save();
    
        return redirect()->route('products.index')->with('message', 'Product updated successfully');
    }


    public function store(Request $request){
        $rules=[
            'title' => 'required|unique:products',
            'slug' => 'required',
            'price' => 'required|numeric',
            'status' => 'required|in:1,2',
            'category'=>'required|numeric',
            'sku'=>'required|numeric',
            'track_quantity'=>'required|in:Yes,No',
            'is_featured'=>'required|in:Yes,No'
        ];
        if(!empty($request->track_quantity && $request->track_quantity=='Yes')){
            $rules['quantity']='required|numeric';

        }
        $validator = Validator::make($request->all(),$rules);
    
        if ($validator->fails()) {
            return redirect()->route('products.create')
                ->withErrors($validator)
                ->withInput();
        }
    
        $Product = new Product();
        $Product->title = $request->input('title');
        $Product->slug = $request->input('slug');
        $Product->description = $request->input('description');
        $Product->price = $request->input('price');
        $Product->compare_price = $request->input('compare_price');
        $Product->category_id = $request->input('category');
        $Product->subcategory_id = $request->input('sub_category'); 
        $Product->brand_id = $request->input('brand');
        $Product->is_featured = $request->input('is_featured');
        $Product->sku = $request->input('sku');
        $Product->barcode = $request->input('barcode');
        $Product->track_quantity = $request->input('track_quantity');
        $Product->quantity = $request->input('quantity');
        $Product->status = $request->input('status');
    
        $Product->save();
        
        return redirect()->route('products.create')->with('message', 'Product created successfully');
    }

    public function destroy($id){
        $Product=Product::find($id);

        // Check if the Product exists
        if (!$Product) {
            return redirect()->route('products.index')->with('error', 'Product not found');
        }

        // // Delete the associated image file from storage (assuming it's stored in the public directory)
        // if ($Product->image) {
        //     Storage::delete('public/images' . $Product->image);
        // }

        // Delete the Product
        $Product->delete();

        return redirect()->route('products.index')->with('message', 'Product deleted successfully');
        
    }
}
