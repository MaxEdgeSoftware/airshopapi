<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MainController;
use App\Mail\SupportMail;
use Illuminate\Support\Facades\Mail;

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

Route::get('/', [MainController::class, 'index'])->name('homepage');
Route::get('/whatsnew', [MainController::class, 'whatsnew'])->name('whatsnew');
Route::view('/pricing', 'main.pricing');
Route::get('/support', [MainController::class, 'support'])->name('support');


Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
