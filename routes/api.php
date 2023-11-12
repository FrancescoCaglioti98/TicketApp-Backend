<?php

use App\Http\Controllers\Users\UserCreation;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Users\UsersTokens;


Route::post("/login", [UsersTokens::class, 'login']);

Route::group(['middleware' => ['auth:sanctum']], function () {

    Route::get('/user', function(){
       return User::all(); 
    });


    Route::post( '/user', [UserCreation::class, 'createUser']);


});