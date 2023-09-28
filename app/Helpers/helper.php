<?php

use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use App\Models\SubCategory;

    function getCategories(){
        return Category::OrderBy('name', 'ASC')->with('sub_category')->where('show','Yes')->where('status', 1)->get();
        
    }
    function getAllCategories(){
        return Category::OrderBy('name', 'ASC')->with('sub_category')->get();
        
    }
    function getProduct(){
        return Product::OrderBy('title', 'ASC')->with('product_image')->where('is_featured','Yes')->get();
    }
    function getAllProduct(){
        return Product::OrderBy('title', 'ASC')->with('product_image')->get();
    }
    function getBrands(){
        return Brand::OrderBy('name', 'ASC')->where('status', 1)->get();
        
    }
?>