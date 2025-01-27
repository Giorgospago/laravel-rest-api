<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AppController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;


Route::get('/', [AppController::class, 'index']);

Route::prefix("auth")->group(function(){
    Route::post("register", [AuthController::class, 'register']);
    Route::post("login", [AuthController::class, 'login']);
});

Route::apiResource('categories', CategoryController::class);
Route::apiResource('products', ProductController::class);

// Route::get("/products", [ProductController::class, 'index']);
// Route::post("/products", [ProductController::class, 'store']);
// Route::get("/products/{id}", [ProductController::class, 'show']);
// Route::put("/products/{id}", [ProductController::class, 'update']);
// Route::delete("/products/{id}", [ProductController::class, 'destroy']);


// Route::prefix("products")->group(function(){
//     Route::get("", [ProductController::class, 'index']);
//     Route::post("", [ProductController::class, 'store']);

//     Route::prefix("{id}")->group(function(){
//         Route::get("", [ProductController::class, 'show']);
//         Route::put("", [ProductController::class, 'update']);
//         Route::delete("", [ProductController::class, 'destroy']);
//     });
// });

// Route::prefix("products")->group(base_path("routes/products.php"));


Route::middleware('auth:sanctum')->group(function() {

    Route::get("auth/logout", [AuthController::class, 'logout']);

    Route::prefix("users")->group(function(){
        Route::get("me", [UserController::class, 'me']);
        Route::get("tokens", [UserController::class, 'tokens']);
        Route::delete("revoke-all-tokens", [UserController::class, 'revokeAllTokens']);
    });
});