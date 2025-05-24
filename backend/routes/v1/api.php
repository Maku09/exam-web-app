<?php

use App\Http\Controllers\v1\AuthController;
use App\Http\Controllers\v1\ProductController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Models\User;


Route::prefix('/v1')->group(function(){

    /* -------------------------------------------------------------------------- */
    /*                           AUTH - LOGIN | REGISTER                          */
    /* -------------------------------------------------------------------------- */

    Route::post('login', [AuthController::class, 'login']);
    Route::post('register', [AuthController::class, 'register']);


    Route::middleware('jwt')->group(function(){
        

    /* -------------------------------------------------------------------------- */
    /*                        USER - ME | REFRESH | LOGOUT                        */
    /* -------------------------------------------------------------------------- */

        Route::get('user/me', [AuthController::class, 'me']);
        
        Route::post('refresh', [AuthController::class, 'refresh']);
        
        Route::post('logout', [AuthController::class, 'logout']);
        
   /* -------------------------------------------------------------------------- */
   /*             PRODUCTS STORE | LIST | RETRIEVE | UPDATE | DELETE             */
   /* -------------------------------------------------------------------------- */

        Route::prefix('products')->group(function(){

            // List all products
            Route::get('/', [ProductController::class, 'index']);

            //Store a new product
            Route::post('/', [ProductController::class, 'store']);

            //Retrieve a single product
            Route::get('/{id}', [ProductController::class, 'show']);

            //Update a product
            Route::put('/{id}', [ProductController::class, 'update']);

            //Delete a product
            Route::delete('/{id}', [ProductController::class, 'destroy']);
        });

   });
});