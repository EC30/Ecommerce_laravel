<?php

namespace App\Http\Controllers;

use App\Models\CustomerAddress;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\User;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class OrderController extends Controller
{
    public function store(Request $request){
        $validator = Validator::make($request->all(), [

            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required|email',
            'country' => 'required',
            'address' => 'required',
            'city' => 'required',
            'state' => 'required',
            'zip' => 'required|numeric',
            'mobile' => 'required|numeric'

        ]);

        if ($validator->fails()) {
            return redirect()->route('user.checkout')
                ->withErrors($validator)
                ->withInput();
        }

        // foreach (Cart::content() as $item) {
        //     $cartItem = new Order();
        //     $cartItem->name = $item->name;
        //     $cartItem->qty = $item->qty;
        //     $cartItem->price = $item->price * $item->qty; // Calculate the total price for this item
        //     $cartItem->save(); // Save the item to the database
        // }
        //for orders tables


        //for customer_addressess table
        $user=Auth::user();
        CustomerAddress::updateOrCreate(
            ['user_id' =>$user->id],
            [
                'user_id' => $user->id,
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
                'email' => $request->email,
                'country' => $request->country,
                'address' => $request->address,
                'city' => $request->city,
                'apartment' => $request->apartment,
                'state' => $request->state,
                'zip' => $request->zip,
                'mobile_number' => $request->mobile,
                'notes' => $request->order_notes,
            ]
            );

        //     if ($request->payment_method=='cash'){
        //         $shipping=0;
        //         $discount=0;
        //         $subtotal=Cart::subtotal(2,'.','');
        //         $total=$subtotal+$shipping-$discount;

        //         $order = new Order();
        //         $order->user_id=$user->id;
        //         $order->subtotal = $subtotal;
        //         $order->total = $total;
        //         $order->shipping = $shipping;
        //         // $order->coupon_code = $request->input('coupon_code');
        //         // $order->discount = $discount;

        //         if ($order->save()) {
        //             return redirect()->route('front.index')->with('message', 'Order created successfully');
        //         } else {
        //             $errors = $order->errors();
        //            return redirect()->route('user.checkout')->with($errors);
        //         }

        //         // dd($order);

        //     }

        // foreach (Cart::content() as $cartItem) {
        //     $product = Product::where('title', $cartItem->name)->first();

        //     $order_items = new OrderItem();
        //     $order_items->product_name = $cartItem->name;
        //     $order_items->price = $cartItem->price;
        //     $order_items->quantity = $cartItem->qty;
        //     $order_items->quantity = $cartItem->total;
        //     $order_items->order_id = $order->id; 

        //     if ($product) {
        //         $order_items->product_id = $product->id;
        //     }
        //     $order_items->save();
        // }

        // Cart::destroy();

        if ($request->payment_method == 'cash') {
            $shipping = 0;
            $discount = 0;
            $subtotal = Cart::subtotal(2, '.', '');
            $total = $subtotal + $shipping - $discount;
        
            $order = new Order();
            $order->user_id = $user->id;
            $order->subtotal = $subtotal;
            $order->total = $total;
            $order->shipping = $shipping;
        
            if ($order->save()) {
                // Now you can access the order ID using $order->id
                $orderId = $order->id;
                foreach (Cart::content() as $cartItem) {
                    $product = Product::where('title', $cartItem->name)->first();
        
                    $orderItem = new OrderItem();
                    $orderItem->product_name = $cartItem->name;
                    $orderItem->price = $cartItem->price;
                    $orderItem->quantity = $cartItem->qty;
                    $orderItem->total = $cartItem->price*$cartItem->qty;
                    $orderItem->order_id = $orderId;
        
                    if ($product) {
                        $orderItem->product_id = $product->id;
                    }
                    $orderItem->save();
                }
                Cart::destroy();
        
                return redirect()->route('front.index')->with('message', 'Order created successfully');
            } else {
                $errors = $order->errors();
                return redirect()->route('user.checkout')->with($errors);
            }
        }
      
    }
}
