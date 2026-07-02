<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\productsController;
use App\Http\Controllers\reveiwController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\SignUpController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');
// My Routes
Route::prefix('dashboard')->group( function(){
    Route::get('AllReview', [ReviewController::class, 'AllReviews']);
    Route::get('AllPreviuosMonthReview', [ReviewController::class, 'AllPreviousMonthReviews']);
});
Route::apiResource('Product', productsController::class);
Route::apiResource('Reviews' , reveiwController::class);
Route::apiResource('Auth' , AuthController::class)->only('store');
Route::apiResource('Check_Token' , AuthController::class)->only('show');
Route::apiResource('Sign_Up', SignUpController::class);
// Route::apiResource('Login' , AuthController::class);
// Route::apiResource('Register' , AuthController::class)->only('register');
// Route::middleware('auth:sanctum')->;