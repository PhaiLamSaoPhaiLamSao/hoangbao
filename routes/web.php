<?php

use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductCategoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\UserController;
use App\Mail\OrderMail;
use App\Models\Product;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Route::get('/', function () {
//     return view('welcome');
// });


Route::prefix('admin')->group(function(){
    Route::get('', function(){
        return view('admin.layout');
    });
    Route::get('post', function(){
        return view('admin.post.list');
    });
    Route::get('user', [UserController::class, 'getUser']);

    //Product
    Route::post('product/get_slug', [ProductController::class, 'getSlug'])->name('product.get_slug');
    Route::get('product', [ProductController::class, 'getProduct'])->name('product.list');
    Route::get('product/add',[ProductController::class, 'getViewAddProduct'])->name('product.add');
    Route::post('product/save', [ProductController::class, 'addProduct'])->name('product.save');
    Route::post('product/delete/{id}', [ProductController::class, 'deleteProduct'])->name('product.delete');
    Route::get('product/edit/{id}', [ProductController::class, 'getProductDetail'])->name('product.detail');
    Route::post('product/edit/{id}', [ProductController::class, 'editProduct'])->name('product.edit');


    //Product Category
    Route::get('product_category',[ProductCategoryController::class, 'getCategories'])->name('product_category.list');
    Route::get('product_category/add', [ProductCategoryController::class, 'getViewAddCategory'])->name('product_category.add');
    Route::post('product_category/save', [ProductCategoryController::class, 'addProductCategory'])->name('product_category.save');
    Route::post('product_category/delete/{id}', [ProductCategoryController::class, 'deleteCategories'])->name('product_category.delete');

});



Route::get('/', [HomeController::class, 'getProduct'])->name('home');
Route::get('product/{slug}', [ProductController::class, 'getProductBySlug'])->name('product.detail.slug');

//Cart
Route::get('add-to-cart/{id}/{qty?}', [CartController::class, 'addProductToCart'])->name('add.product.to.cart');
Route::get('shopping-cart', [CartController::class,'shoppingCart'])->name('shopping.cart');
Route::get('delete-cart', [CartController::class, 'deleteCart'])->name('delete.cart');
Route::get('delete-item-cart/{id}', [CartController::class, 'deleteItemCart'])->name('delete.item.cart');
Route::post('update-cart', [CartController::class,'updateCart'])->name('update.cart');
Route::get('product-list',[HomeController::class,'shopProductList'])->name('shop.product.list');

//Checkout
Route::get('checkout',[CartController::class, 'getCheckout'])->name('checkout')->middleware('auth');
Route::post('place-order', [CheckoutController::class, 'saveOrder'])->name('place.order')->middleware(('auth'));

Auth::routes();

//Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

// Route::get('send-mail',function(){
//     $data = [
//         'name' => 'Bao',
//         'age' => 26
//     ];
//     Mail::to("hoangbaobk01@gmail.com")->send(new OrderMail($data));
// });
