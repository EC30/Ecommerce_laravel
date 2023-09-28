<?php
namespace App\Http\Controllers;

use App\Models\Brand;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Product;
use App\Models\SubCategory;

class FrontController extends Controller
{
    public function index(Request $request, $categoryname = null, $subCategoryname = null)
    {
        $categories = Category::orderBy('name', 'ASC')
            ->where('status', 1)
            ->with('sub_category')
            ->get();

        $brands = Brand::orderBy('name', 'ASC')
            ->where('status', 1)
            ->get();

        $brandsArray = []; // Initialize the $brandsArray variable

        $products = Product::where('status', 1);

        if (!empty($categoryname)) {
            $categories = Category::where('name', $categoryname)->first();
            $products = $products->where('category_id', $categories->id);
        }

        if (!empty($subCategoryname)) {
            $subcategory = SubCategory::where('name', $subCategoryname)->first();
            $products = $products->where('subcategory_id', $subcategory->id);
        }

        if ($request->has('price_min') && $request->has('price_max')) {
            $minPrice = intval($request->get('price_min'));
            $maxPrice = intval($request->get('price_max'));
            //dd($minPrice);
            $products = $products->whereBetween('price', [$minPrice, $maxPrice]);
            //$products = $products->get();
            //dd($products);
        }
        

        if ($request->has('brand')) {
            $brandsArray = explode(',', $request->get('brand'));
            $products = $products->whereIn('brand_id', $brandsArray);
        }

        // Apply sorting based on request parameter
        if ($request->has('sort')) {
            switch ($request->get('sort')) {
                case 'price_low_high':
                    $products = $products->orderBy('price', 'ASC');
                    break;
                case 'price_high_low':
                    $products = $products->orderBy('price', 'DESC');
                    break;
                case 'latest':
                    $products = $products->orderBy('id', 'DESC');
                    break;
                default:
                    $products = $products->orderBy('id', 'DESC');
            }
        } else {
            $products = $products->orderBy('id', 'DESC');
        }

        $products = $products->get();
       // dd($products);

        $data['categories'] = $categories;
        $data['products'] = $products;
        $data['brands'] = $brands;
        $data['brandsArray'] = $brandsArray; // Pass the initialized $brandsArray to the view
        $data['priceMax'] = ($request->has('price_max')) ? intval($request->get('price_max')) : 7000;
        $data['priceMin'] = ($request->has('price_min')) ? intval($request->get('price_min')) : 0;
        $data['sort'] = $request->get('sort');

        return view('User.shop', $data);
    }
}