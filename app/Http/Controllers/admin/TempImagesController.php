<?php

namespace App\Http\Controllers\admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ProductImage;
use App\Models\Product;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Nette\Utils\Image;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class TempImagesController extends Controller
{
    // public function create(Request $request){
    //     $image = $request->image;

    //     if (!empty($image)) {
    //         $ext=$image->getClientOriginalExtension();
    //         $newName=time().'.'.$ext;

    //         $tempImage=new TempImage();
    //         $tempImage->name=$newName;
    //         $tempImage->save();

    //         $image->move(public_path(),'/temp',$newName);


    //           // Create a thumbnail
    //         $SourcePath = public_path().'/temp'.$newName;
    //         $destPath = public_path().'/temp/thumb/'.$newName;
    //         $image = Image::make($SourcePath)->fit(100, 100);
    //         $image->save($destPath);

    //         return response()->json([
    //             'status'=>true,
    //             'image_id'=>$tempImage->id,
    //             'ImagePath'=>asset('/temp/thumb/'.$newName),
    //             'message'=>'Image Uploaded Successfully'
    //         ]);
           
    //     }

    // }

    public function index(Request $request){
        $products_images=ProductImage::latest();

        if(!empty($request->get('keyword'))){ 
            $products_images=$products_images->where('name','like','%'.$request->get('keyword') .'%');
        }
        $products_images=$products_images->paginate(10);
        $data['products_images'] =$products_images;
        return view('admin.ProductImage.list', compact('products_images'));

    }
    public function create(){
        // $products=Product::orderBy('title', 'ASC')->get();
        // $data['products']=$products;
        // return view('admin.ProductImage.create', $data);
        $products = Product::orderBy('title', 'ASC')->pluck('title', 'id'); 
        return view('admin.ProductImage.create', compact('products'));
    }
    public function update( $id){
        $products = Product::orderBy('title', 'ASC')->pluck('title', 'id'); 
        
        // Retrieve the ProductImage we want to update from the database
        $ProductImage = ProductImage::find($id);
        return view('admin.ProductImage.update', compact('ProductImage', 'products'));
    
        // Check if the ProductImage exists
        if (!$ProductImage) {
            return redirect()->route('Productsimages.index')->with('error', 'ProductImage not found');
        }
    
    }
    
    public function edit(Request $request,$id){
        $ProductImage = ProductImage::find($id);
      
        // Check if the ProductImage exists
        if (!$ProductImage) {
            return redirect()->route('Productsimage.index')->with('error', 'ProductImage not found');
        }
    
        $validator = Validator::make($request->all(), [
            'product' => 'required',
            'image-upload' => 'image|mimes:jpeg,png,jpg,gif|max:2048'
            
        ]);
        if ($validator->fails()) {
            return redirect()->route('Productsimage.update', ['id' => $ProductImage->id])
                ->withErrors($validator)
                ->withInput();
        }
    
        // Update ProductImage data

        $ProductImage->product_id = $request->input('product');
        if ($request->hasFile('image-upload')) {
            $image = $request->file('image-upload');
            $imageName = time().'.'.$image->extension();
            $image->move(public_path('temp'), $imageName);
            $ProductImage->image = $imageName;
        }
    
        $ProductImage->save();
    
        return redirect()->route('Productsimage.index')->with('message', 'ProductImage updated successfully');
        
    }


    public function store(Request $request){
        $validator = Validator::make($request->all(), [
            'product' => 'required',
            'image-upload' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);
    
        if ($validator->fails()) {
            return redirect()->route('Productsimage.create')
                ->withErrors($validator)
                ->withInput();
        }
    
        $ProductImage = new ProductImage();
        $ProductImage->product_id = $request->input('product');
    
        // Handle the file upload (assuming 'image-upload' is a file input)
        if ($request->hasFile('image-upload')) {
            $image = $request->file('image-upload');
            $imageName = time().'.'.$image->extension();
            $image->move(public_path('temp'), $imageName);
            $ProductImage->image = $imageName;
        }
        $ProductImage->save();
        
        return redirect()->route('Productsimage.create')->with('message', 'ProductImage created successfully');
    }

    public function destroy($id){
        $ProductImage=ProductImage::find($id);

        // Check if the ProductImage exists
        if (!$ProductImage) {
            return redirect()->route('Productsimage.index')->with('error', 'ProductImage not found');
        }

        // Delete the associated image file from storage (assuming it's stored in the public directory)
        if ($ProductImage->image) {
            Storage::delete('public/temp' . $ProductImage->image);
        }

        // Delete the ProductImage
        $ProductImage->delete();

        return redirect()->route('Productsimage.index')->with('message', 'ProductImage deleted successfully');
        
    }



}
