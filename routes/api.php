<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\V1\RealStateController;
use App\Http\Controllers\Api\V1\UserController;
use App\Http\Controllers\Api\V1\CategoryController;
use App\Http\Controllers\Api\V1\RealStatePhotoController;
use App\Http\Controllers\Api\V1\Auth\LoginJWTController;

Route::group(['prefix'=>'auth'],function(){
    Route::put('/login',[LoginJWTController::class,'login']);
});

Route::group(['prefix'=>'real-states'],function(){
   Route::get('/',[RealStateController::class,'index']);
   Route::post('/',[RealStateController::class,'store']);
   Route::get('/{id}',[RealStateController::class,'show']);
   Route::put('/{id}',[RealStateController::class,'update']);
   Route::delete('/{id}',[RealStateController::class,'destroy']);
});

Route::group(['prefix'=>'users'],function(){
   Route::get('/',[UserController::class,'index']);
   Route::post('/',[UserController::class,'store']);
   Route::get('/{id}',[UserController::class,'show']);
   Route::put('/{id}',[UserController::class,'update']);
   Route::delete('/{id}',[UserController::class,'destroy']);
});

Route::group(['prefix'=>'categories'],function(){
   Route::get('/',[CategoryController::class,'index']);
   Route::post('/',[CategoryController::class,'store']);
   Route::get('/{id}/real-states',[CategoryController::class,'realstates']);
   Route::get('/{id}',[CategoryController::class,'show']);
   Route::put('/{id}',[CategoryController::class,'update']);
   Route::delete('/{id}',[CategoryController::class,'destroy']);
});

Route::group(['prefix'=>'photos'],function(){
   Route::put('/set-tumb/{photoId}/{realstateId}',[RealStatePhotoController::class,'setTumb']);
   Route::delete('/remove/{id}',[RealStatePhotoController::class,'remove']);
});


