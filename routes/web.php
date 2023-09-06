<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
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

Route::get('/', function () {
    return view('welcome');
});

Route::get('/user-sign',[UserController::class,'register_view'])->name('register_page');
Route::post('user-register',[UserController::class,'register_store'])->name('user-register');

Route::get('/user-login',[UserController::class,'login_view'])->name('login_page');
Route::post('/user-in',[UserController::class,'user_login'])->name('valid_user_login');
Route::get('/logout',[UserController::class,'logout'])->name('U_logout');

Route::group(['middleware'=>'todogurd'],function(){
Route::get('/profile',[UserController::class,'profile'])->name('profile');
Route::get('/todotable',[UserController::class,'todotable'])->name('todotable');


Route::post('/taskadd',[UserController::class,'taskadd'])->name('taskadd');
});


