<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\admin\AdminloginController;
use App\Http\Controllers\admin\HomeController;
use App\Http\Controllers\admin\CategoryController;
use App\Http\Controllers\admin\SubCategoryController;
use App\Http\Controllers\admin\BrandController;
use App\Http\Controllers\admin\ProductController;
use App\Http\Controllers\admin\ProductSubCategoryController;
use App\Http\Controllers\admin\TempImagesController;
use App\Http\Controllers\FrontController;
use App\Http\Controllers\ShopController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\UserloginController;
use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Route::get('/', function () {
//     return view('welcome');
// });
Route::get('/', [FrontController::class, 'index'])->name('front.index');
Route::get('/shop/{categoryname?}/{subCategoryname?}', [ShopController::class, 'index'])->name('front.shop');
Route::get('/shop/{brandname?}', [ShopController::class, 'index'])->name('front.brand');
//Route::get('/product/{title}', [ShopController::class, 'shopCart'])->name('front.product');
Route::get('/products/{title}', [ShopController::class, 'product'])->name('front.product');

Route::post('/addtocart', [CartController::class, 'addToCart'])->name('user.addtocart');
Route::post('/updatecart', [CartController::class, 'updateCart'])->name('user.updatecart');
Route::post('/deletecart', [CartController::class, 'deleteCart'])->name('user.deletecart');
Route::get('/cart', [CartController::class, 'cart'])->name('user.cart');

Route::group(['prefix'=>'user'],function(){
    Route::group(['middleware'=>'guest'],function(){
        Route::get('/register', [UserloginController::class, 'register'])->name('user.register');
        Route::get('/login', [UserloginController::class, 'login'])->name('user.login');
        Route::post('/authenticate', [UserloginController::class, 'authenticate'])->name('user.authenticate');
        Route::post('/create', [UserloginController::class, 'create'])->name('user.create');
    

        });
    Route::group(['middleware'=>'auth'],function(){
        Route::get('/profile', [UserloginController::class, 'profile'])->name('user.profile');
        Route::get('/logout', [UserloginController::class, 'logout'])->name('user.logout');
    });
});


Route::get('/admin/login', [AdminloginController::class, 'index'])->name('admin.login');
Route::group(['prefix'=>'admin'],function(){
    Route::group(['middleware'=>'admin.guest'],function(){
        Route::get('/login', [AdminloginController::class, 'index'])->name('admin.login');
        Route::post('/authenticate', [AdminloginController::class, 'authenticate'])->name('admin.authenticate');
    
    });
    Route::group(['middleware'=>'admin.auth'],function(){
        Route::get('/dashboard', [HomeController::class, 'index'])->name('admin.dashboard');
        Route::get('/logout', [HomeController::class, 'logout'])->name('admin.logout');
        //categories Routes
        Route::get('/categories', [CategoryController::class, 'index'])->name('categories.index');
        Route::get('/categories/create', [CategoryController::class, 'create'])->name('categories.create');
        Route::post('/categories/store', [CategoryController::class, 'store'])->name('categories.store');
        Route::get('/categories/update/{id}', [CategoryController::class, 'update'])->name('categories.update');
        Route::put('/categories/edit/{id}', [CategoryController::class, 'edit'])->name('categories.edit');
        Route::delete('/categories/{id}', [CategoryController::class, 'destroy'])->name('categories.destroy');
        //subcategories route
        Route::get('/subcategory', [SubCategoryController::class, 'index'])->name('subcategory.index');
        Route::get('/subcategory/create', [SubCategoryController::class, 'create'])->name('subcategory.create');
        Route::post('/subcategory/store', [SubCategoryController::class, 'store'])->name('subcategory.store');
        Route::get('/subcategory/update/{id}', [SubCategoryController::class, 'update'])->name('subcategory.update');
        Route::put('/subcategory/edit/{id}', [SubCategoryController::class, 'edit'])->name('subcategory.edit');
        Route::delete('/subcategory/{id}', [SubCategoryController::class, 'destroy'])->name('subcategory.destroy');
        //Brands route
        Route::get('/brands', [BrandController::class, 'index'])->name('brands.index');
        Route::get('/brands/create', [BrandController::class, 'create'])->name('brands.create');
        Route::post('/brands/store', [BrandController::class, 'store'])->name('brands.store');
        Route::get('/brands/update/{id}', [BrandController::class, 'update'])->name('brands.update');
        Route::put('/brands/edit/{id}', [BrandController::class, 'edit'])->name('brands.edit');
        Route::delete('/brands/{id}', [BrandController::class, 'destroy'])->name('brands.destroy');
        //product route
        Route::get('/products', [ProductController::class, 'index'])->name('products.index');
        Route::get('/products/create', [ProductController::class, 'create'])->name('products.create');
        Route::post('/products/store', [ProductController::class, 'store'])->name('products.store');
        Route::get('/products/update/{id}', [ProductController::class, 'update'])->name('products.update');
        Route::put('/products/edit/{id}', [ProductController::class, 'edit'])->name('products.edit');
        Route::delete('/products/{id}', [ProductController::class, 'destroy'])->name('products.destroy');
        Route::get('/productsubcategories', [ProductSubCategoryController::class, 'index'])->name('productsubcategory.index');
        //images
        //Route::post('/upload-temp-images', [TempImagesController::class, 'create'])->name('temp-images.create');
        Route::get('/productsimage', [TempImagesController::class, 'index'])->name('Productsimage.index');
        Route::get('/productsimage/create', [TempImagesController::class, 'create'])->name('Productsimage.create');
        Route::post('/productsimage/store', [TempImagesController::class, 'store'])->name('Productsimage.store');
        Route::get('/productsimage/update/{id}', [TempImagesController::class, 'update'])->name('Productsimage.update');
        Route::put('/productsimage/edit/{id}', [TempImagesController::class, 'edit'])->name('Productsimage.edit');
        Route::delete('/productsimage/{id}', [TempImagesController::class, 'destroy'])->name('Productsimage.destroy');

    });



});


