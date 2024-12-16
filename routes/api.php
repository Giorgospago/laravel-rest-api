<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AppController;


Route::get('/', [AppController::class, 'index']);

// Route::get("/products", [ProductController::class, 'index']);
// Route::post("/products", [ProductController::class, 'create']);
// Route::get("/products/{id}", [ProductController::class, 'show']);
// Route::put("/products/{id}", [ProductController::class, 'update']);
// Route::delete("/products/{id}", [ProductController::class, 'delete']);


// Route::prefix("products")->group(function(){
//     Route::get("", [ProductController::class, 'index']);
//     Route::post("", [ProductController::class, 'create']);

//     Route::prefix("{id}")->group(function(){
//         Route::get("", [ProductController::class, 'show']);
//         Route::put("", [ProductController::class, 'update']);
//         Route::delete("", [ProductController::class, 'delete']);
//     });
// });

Route::prefix("products")->group(base_path("routes/products.php"));