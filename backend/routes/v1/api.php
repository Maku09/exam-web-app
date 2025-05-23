<?php

use App\Http\Controllers\v1\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Models\User;


Route::prefix('/v1')->group(function(){

    /* -------------------------------------------------------------------------- */
    /*                           AUTH - LOGIN | REGISTER                          */
    /* -------------------------------------------------------------------------- */

    Route::post('login', [AuthController::class, 'login']);

    Route::get('test', function (Request $request) {
        return 'Hello, World';
    });


    /* -------------------------------------------------------------------------- */
    /*                        USER - ME | REFRESH | LOGOUT                        */
    /* -------------------------------------------------------------------------- */

    Route::middleware('jwt')->group(function(){

        Route::post('logout', [AuthController::class, 'logout']);

        Route::get('user/me', [AuthController::class, 'me']);
        
        Route::post('refresh', [AuthController::class, 'refresh']);

        Route::get('users', function (Request $request) {
            return User::all();
        });
   });
});