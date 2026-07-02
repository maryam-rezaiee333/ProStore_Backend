<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\productController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\SignUpController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');
Route::prefix('dashboard')->group(function(){
    Route::get('/all-reviews',[ReviewController::class,'allReviews']);
    Route::get('/prev-month-reviews',[ReviewController::class,'getPreviouseMonthReview']);
    Route::get('/report-of-current-customers',[UserController::class,'getPrevMonthUser']);
    Route::get('/report-of-prev-month-customers',[UserController::class,'getCurrentMonthUser']);
    });
Route::apiResource("products",productController::class);
Route::apiResource('login',AuthController::class)->only('store');
Route::apiResource('check-token',AuthController::class)->only('show');
Route::apiResource('signup',SignUpController::class)->only('store');     
Route::apiResource('/reviews',ReviewController::class);