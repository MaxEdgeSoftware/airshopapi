<?php

use App\Http\Controllers\Admin\AdminsController;
use App\Http\Controllers\Admin\MailsController;
use App\Http\Controllers\Admin\StoresController;
use App\Http\Controllers\Admin\VendorsController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\PlanController;
use App\Http\Controllers\Api\AccountController;
use App\Http\Controllers\Api\CartController;
use App\Http\Controllers\Api\MaillerController;
use App\Http\Controllers\Api\OrderController;
use App\Http\Controllers\Api\PasswordController;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\StoreController;
use App\Http\Controllers\Api\StoreTypeControllers;
use App\Models\Product;
use App\Models\StoreType;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/


Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


// Route::middleware(['cors'])->group(function () {
//     Route::post('login', [AccountController::class, 'login']);
// });


Route::post('login', [AccountController::class, 'login']);
Route::post('register', [AccountController::class, 'register']);
Route::post('user/resetpassword/{key}', [AccountController::class, 'resetPassword']);
Route::get('confirmpasswordresettoken/{token}', [PasswordController::class, 'show']);
Route::post('changePassword', [PasswordController::class, 'update']);
Route::get('/sendVerify/{key}', [AccountController::class, 'verify']);
Route::get('/checkVerify/{key}', [AccountController::class, 'check']);
Route::post('/verified', [AccountController::class, 'verified']);



// Plans
Route::get('getplans/{currency}', [PlanController::class, 'getplans']);



// Shops
Route::get('fetchStore/{key}', [StoreController::class, 'fetchStore']);
Route::get('fetchStore2/{api}/{key}', [StoreController::class, 'fetchStore2']);
Route::post('add-store', [StoreController::class, 'addStore']);
Route::post('uploadLogo', [StoreController::class, 'addLogo']);
Route::post('uploadBanner', [StoreController::class, 'addBanner']);
Route::post('contactInfo', [StoreController::class, 'addContact']);
Route::post('description', [StoreController::class, 'addDescription']);
Route::post('updateStore', [StoreController::class, 'updateStore']);


// products
Route::get('fetchProducts/{key}', [ProductController::class, 'fetchProducts']);
Route::post('add-product/', [ProductController::class, 'addProduct']);
Route::post('add-product/slideshow/', [ProductController::class, 'addProductSlideShow']);

Route::get('fetchProduct/{key}/{product}', [ProductController::class, 'fetchProduct']);
Route::post('updateDesc/{product}', [ProductController::class, 'updateDesc']);
Route::post('updateImage/{product}', [ProductController::class, 'updateImage']);
Route::post('deleteProduct/{product}', [ProductController::class, 'deleteProduct']);

// from visit
Route::get('fetchStoreVisit/{slug}', [StoreController::class, 'fetchStoreVisit']);
Route::post('addtocart', [CartController::class, 'store']);
Route::post('deletecart', [CartController::class, 'deletecart']);
Route::get('getCart/{user}/{store}', [CartController::class, 'getCart']);
Route::post('cartquantity', [CartController::class, 'cartquantity']);
Route::post('commitOrder', [OrderController::class, 'store']);
Route::post('commitOrderShowroom', [OrderController::class, 'OrderShowroom']);
Route::post('commitOrderorderpage', [OrderController::class, 'OrderPage']);

// mailer
Route::post('support', [MaillerController::class, 'support']);
Route::post('resetPassword', [PasswordController::class, 'store']);
Route::any('get-shop-types', [StoreTypeControllers::class, 'index']);
Route::post('change-type', [StoreTypeControllers::class, 'store']);




// near me
Route::get('getProducts/{country}', [ProductController::class, 'getProducts']);
Route::get('getProduct/{getProduct}', [ProductController::class, 'getProduct']);







// ++++++++++++++++++++++++++++++ ADMIN ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++

// admin
Route::post("admin/login", [AdminsController::class, 'login']);
Route::get("admin/getAllEmails", [AdminsController::class, 'getEmails']);

// VENDORS
Route::get("admin/vendors/", [VendorsController::class, 'index']);

// PRODUCTS


// STORES
Route::get("admin/stores/", [StoresController::class, 'index']);



// mail
Route::get("admin/mail/{key}", [MailsController::class, 'index']);
Route::get("admin/mail/sent/{key}", [MailsController::class, 'getSent']);
Route::get("admin/getmail/{key}/{apikey}", [MailsController::class, 'getMail']);
Route::post("admin/mail/send", [MailsController::class, 'store']);
Route::post("admin/mail/reply/{mailid}", [MailsController::class, 'store2']);
