<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\UserController;
use App\Models\Category;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\BusinessController;
use App\Models\BusinessProfile;
use App\Http\Controllers\PublicController;
use App\Http\Controllers\CustommerController;

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

// Public Website Routes
Route::get('/',[PublicController::class,'index'])->name('index');
Route::post('/find-product',[PublicController::class, 'find_product'])->name('find_product');
Route::post('/subscriber',[PublicController::class, 'subscriber_add'])->name('subscriber.add');
Route::get('/about-us',[PublicController::class,'about_us'])->name('public.about_us');
Route::get('/contact-us',[PublicController::class,'contact_us'])->name('public.contact_us');
Route::post('/customer/message',[PublicController::class,'customer_message_add'])->name('customer.message');
Route::post('/search-product',[PublicController::class, 'search_product']); // This Route For Only Ajax Request.
Route::get('/category/browse/{category_name}',[PublicController::class, 'browse_category'])->name('browse.category');


Auth::routes();

Route::get('/admin-panel', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

// User
Route::get('user/profile/{user_identity}',[UserController::class,'index'])->name('user.profile');
Route::put('user/update-password/{user_identity}',[UserController::class, 'update_password'])->name('user.update_Password');
Route::put('user/update-info/{user_identity}',[UserController::class,'update_info'])->name('user.update_info');
Route::put('user/update-info/profile_image/{user_identity}',[UserController::class,'update_profile_image'])->name('profile_image.add');


// Product
Route::get('product/product-list',[ProductController::class,'index'])->name('product.list');
Route::get('product/add-form',[ProductController::class,'create'])->name('product.add_from');
Route::post('product/add',[ProductController::class,'store'])->name('product.add');
Route::get('product/details/{product_code}',[ProductController::class,'show'])->name('product.details');
Route::get('product/status-update/{product_code}',[ProductController::class,'productStatusUpdate'])->name('product_status.update');
Route::get('product/delete/{product_id}',[ProductController::class,'productDelete'])->name('product.delete');
Route::get('product/edit-form/{product_code}',[ProductController::class,'edit'])->name('product.edit_form');
Route::post('product/edit/{product_code}',[ProductController::class,'update'])->name('product.edit');
Route::get('product/inventory',[ProductController::class,'show_inventory_list'])->name('inventory.list');
Route::get('product/stock-list',[ProductController::class,'show_stock_list'])->name('stock.list');

// Category
Route::get('category/add-form',[CategoryController::class,'create'])->name('category.add_form');
Route::post('category/add',[CategoryController::class,'store'])->name('category.add');
Route::get('category/category-list',[CategoryController::class,'index'])->name('category.list');
Route::get('category/edit-form/{slug}',[CategoryController::class,'edit'])->name('category.edit_form');
Route::post('category/edit/{slug}',[CategoryController::class,'update'])->name('category.edit');
Route::get('category/delete/{encrypt_id}',[CategoryController::class,'delete'])->name('category.delete');


// Home Page Routes
Route::get('slider/contents', [HomeController::class, 'show_slider_contents'])->name('slider.contents');
Route::post('slider/add', [HomeController::class, 'slider_add'])->name('slider.add');
Route::get('slider/delete/{encrypt_id}', [HomeController::class, 'slider_delete'])->name('slider.delete');
Route::get('promotional/banners',[HomeController::class, 'promotional_banners'])->name('promotional.banners');
Route::post('promotional/banner/add',[HomeController::class, 'promotional_banner_add'])->name('promotional_banner.add');
Route::get('promotional/banner/delete/{encrypt_id}',[HomeController::class, 'promotional_banner_delete'])->name('promotional_banner.delete');

// Business Routes
Route::get('business/profile',[BusinessController::class,'business_profile'])->name('business.profile');
Route::put('business/profile/add',[BusinessController::class,'business_profile_add'])->name('business_profile.add');
Route::post('business/logo/add',[BusinessController::class , 'logo_add'])->name('logo.add');
Route::get('business/brands',[BusinessController::class , 'business_brands'])->name('business.brands');

// Brand Routes
Route::post('brand/add',[BusinessController::class , 'brand_add'])->name('brand.add');
Route::get('brand/delete/{encrypt_id}',[BusinessController::class , 'brand_delete'])->name('brand.delete');

// About US Page Routes
Route::get('/about_us',[BusinessController::class , 'show_about_us'])->name('about_us');
Route::post('/about_us/add',[BusinessController::class , 'add_about_us'])->name('about_us.add');
Route::get('/about_us/delete/{encrypt_id}',[BusinessController::class , 'delete_about_us'])->name('delete.about_us');
Route::get('/about_us/gallery',[BusinessController::class , 'about_us_gallery'])->name('about_us.gallery');
Route::post('/about_us/gallery/add',[BusinessController::class , 'about_us_gallery_add'])->name('about_us_gallery.add');
Route::get('/about_us/gallery/delete/{encrypt_id}',[BusinessController::class , 'about_us_gallery_delete'])->name('about_us_gallery.delete');

// Customer Routes
Route::get('/subscribers',[CustommerController::class,'index'])->name('subscribers.list');
Route::get('/subscriber/delete/{id}',[CustommerController::class, 'subscriber_delete'])->name('subscriber.delete');
Route::get('/customer-messages',[CustommerController::class, 'customer_message'])->name('customer_message');
Route::get('/customer-messages/delete/{id}',[CustommerController::class, 'customer_message_delete'])->name('custommer_message.delete');


// Public Site Routes
Route::get('/product-details/{product_code}',[CustommerController::class, 'public_product_details'])->name('public.product_details');





Route::fallback(function(){
    return 'Oi mia ki khojo';
});