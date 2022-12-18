<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\V1\RealStateController;
use App\Http\Controllers\Api\V1\UserController;
use App\Http\Controllers\Api\V1\CategoryController;
use App\Http\Controllers\Api\V1\RealStatePhotoController;
use App\Http\Controllers\Api\V1\Auth\LoginJWTController;
use App\Http\Controllers\Api\V1\RealStateSearchController;

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

Route::group(['prefix'=>'auth'],function(){
    Route::post('/login',[LoginJWTController::class,'login'])->name('auth.login');
    Route::get('/logout',[LoginJWTController::class,'logout'])->name('auth.logout');
    Route::get('/refresh',[LoginJWTController::class,'refresh'])->name('auth.refresh');
});

Route::group(['prefix'=>'real-states'],function(){
   Route::get('/',[RealStateController::class,'index'])->name('real-states.index');
   Route::post('/',[RealStateController::class,'store'])->name('real-states.store')->middleware('jwt.auth');
   Route::get('/{id}',[RealStateController::class,'show'])->name('real-states.show');
   Route::put('/{id}',[RealStateController::class,'update'])->name('real-states.update')->middleware('jwt.auth');
   Route::delete('/{id}',[RealStateController::class,'destroy'])->name('real-states.destroy')->middleware('jwt.auth');
});

Route::group(['prefix'=>'users'],function(){
   Route::get('/',[UserController::class,'index'])->name('users.index');
   Route::post('/',[UserController::class,'store'])->name('users.store');
   Route::get('/{id}',[UserController::class,'show'])->name('users.show');
   Route::put('/{id}',[UserController::class,'update'])->name('users.update');
   Route::delete('/{id}',[UserController::class,'destroy'])->name('users.destroy');
});

Route::group(['prefix'=>'categories'],function(){
   Route::get('/',[CategoryController::class,'index'])->name('categories.index');
   Route::post('/',[CategoryController::class,'store'])->name('categories.store')->middleware('jwt.auth');
   Route::get('/{id}/real-states',[CategoryController::class,'realstates'])->name('categories.show.realstates');
   Route::get('/{id}',[CategoryController::class,'show'])->name('categories.show');
   Route::put('/{id}',[CategoryController::class,'update'])->name('categories.update')->middleware('jwt.auth');
   Route::delete('/{id}',[CategoryController::class,'destroy'])->name('categories.delete')->middleware('jwt.auth');
});

Route::group(['prefix'=>'photos','middleware'=>'jwt.auth'],function(){
   Route::put('/set-tumb/{photoId}/{realstateId}',[RealStatePhotoController::class,'setTumb'])->name('photos.set-tumb');
   Route::delete('/remove/{id}',[RealStatePhotoController::class,'remove'])->name('photos.remove');
});

Route::group(['prefix'=>'search'],function(){
   Route::get('/',[RealStateSearchController::class,'index'])->name('search');
});


