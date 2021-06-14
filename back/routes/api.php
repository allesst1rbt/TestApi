<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductsController;
use App\Http\Controllers\AuthController;
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


Route::get('/',[HomeController::class,'index']);
Route::middleware('auth:api')->apiResource('products',ProductsController::class);
Route::post('signUp',[AuthController::class,'signUp']);
Route::post('signIn',[AuthController::class,'signIn']);
Route::get('login',[AuthController::class,'login'])->name('login');
