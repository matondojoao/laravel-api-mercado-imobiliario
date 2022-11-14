<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\V1\RealStateController;
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

Route::group(['prefix'=>'real-states'],function(){
   Route::get('/',[RealStateController::class,'index']);
   Route::post('/',[RealStateController::class,'store']);
   Route::get('/{id}',[RealStateController::class,'show']);
   Route::put('/{id}',[RealStateController::class,'update']);
   Route::delete('/{id}',[RealStateController::class,'destroy']);
});
