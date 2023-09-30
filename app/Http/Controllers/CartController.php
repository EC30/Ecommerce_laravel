<?php

namespace App\Http\Controllers;
use App\Models\Product;

use Illuminate\Http\Request;

class CartController extends Controller
{
    public function addToCart(){
        return view('User.product');
    }
    public function cart(){
        return view('User.cart');
    }
    

}
