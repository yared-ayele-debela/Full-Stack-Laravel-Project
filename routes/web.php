<?php

use App\Http\Controllers\Auths\LoginController;
use App\Http\Controllers\Auths\LogoutController;
use App\Http\Controllers\Auths\RegisterController;
use App\Http\Controllers\Auth\RegisterController as AuthRegisterController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EmpleadoController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\UserController;
use Cron\HoursField;
use Illuminate\Support\Facades\Auth;

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

Route::get('/', function () {
    return view('auth.login');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::prefix('auth')->group(function(){

    Route::post('/login',action: LoginController::class);
    Route::post('/logout',LogoutController::class);
    Route::post(uri: '/register',action: RegisterController::class);


});
