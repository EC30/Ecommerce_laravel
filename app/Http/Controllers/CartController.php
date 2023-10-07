<?php

namespace App\Http\Controllers;
use App\Models\Product;
use Gloudemans\Shoppingcart\Facades\Cart;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    public function addToCart(Request $request){
        $product=Product::with('product_image')->find($request->id);
        if(!$product){
            return response()->json([
                'status'=>false,
                'message'=>'Record not found'
            ]);
        }
        if(Cart::count()>0){
            //products already in cart
            $cartContent=Cart::content();
            $productexists=false;
            foreach ($cartContent as $item) {
                if($item->id ==$product->id){
                    $productexists=true;
                    break;

                }
            }
            if($productexists==false){
                Cart::add($product->id, $product->title, 1, $product->price, 
            ['productImage'=>(!empty($product->product_image)) ? $product->product_image->first() : '']);

            return response()->json([
                'status' => true,
                'message' => 'Product added to cart'
            ]);
            }else{
                //return redirect()->route('front.product')->with('message', 'Product already added in cart');
                return response()->json([
                    'status' => false,
                    'message' => 'Product is already in the cart'
                ]);
            }

        }else{
            //echo "cart empty";
            Cart::add($product->id, $product->title, 1, $product->price, 
            ['productImage'=>(!empty($product->product_image)) ? $product->product_image->first() : '']);
           // return redirect()->route('user.cart')->with('message', 'Product added in cart');
           return response()->json([
            'status' => true,
            'message' => 'Product added to cart'
        ]);
        }
     
       
    }

    public function updateCart(Request $request){
        $rowId=$request->rowId;
        $quantity=$request->qty;
        $info=Cart::get($rowId);
        $product=Product::find($info->id);
        if($product->track_quantity=='Yes' ){
            if($quantity <=  $product->quantity){
                Cart::update($rowId,$quantity);
                return response()->json([
                    'status' => true,
                    'message' => 'cart updated successfully'
                ]);
            }else{
                return response()->json([
                    'status' => false,
                    'message' => 'requested quantity not availabke in stock'
                ]);
            }

        }else{
            Cart::update($rowId,$quantity);
            return response()->json([
                'status' => true,
                'message' => 'cart updated successfully'
            ]);
        }
    }

    public function deleteCart(Request $request){
        $rowId=$request->rowId;
        $info=Cart::get($rowId);
        if($info == null){          
            return response()->json([
            'status' => false,
            'message' => 'cart  not found'
        ]);
        }
        Cart::remove($rowId);
        return response()->json([
            'status' => true,
            'message' => 'cart deleted successfully'
        ]);


    }
    public function cart(){
       $cartContent=Cart::content();
       //dd($cartContent);
       $data['cartContent']=$cartContent;
        return view('User.cart',$data);
    }
    
    public function checkout(){
        $cartContent=Cart::content();
        if(Cart::count()==0){
            return redirect()->route('user.cart');
        }
        if(Auth::check()==false){
            if(!session()->has('url.intended')){
                session(['url.intended'=>url()->current()]);
            }
            return redirect()->route('user.login');
        }
        session()->forget('url.intended');
        $data['cartContent']=$cartContent;
        return view('User.checkout', $data);
    }

}
