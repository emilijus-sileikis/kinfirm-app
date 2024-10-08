<?php

use App\Http\Controllers\ProductController;
use App\Http\Middleware\TokenAccess;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

// Route for all products export
Route::get('/products', [ProductController::class, 'export'])->middleware(TokenAccess::class);
