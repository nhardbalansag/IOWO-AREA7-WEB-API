<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\API\V1\UserController;

Route::post('/login', [UserController::class, 'login']);

//AUTH
Route::group(['middleware' => 'auth:api'], function() {
    Route::middleware('ValidateUser:user')->group(function(){

    });
});
