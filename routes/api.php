<?php

use App\Http\Controllers\User;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Users\UsersTokens;


Route::post("/login", [UsersTokens::class, 'login']);

Route::group(['middleware' => ['auth:sanctum']], function () {

    //Creazione utente
    Route::post( '/user', [User::class, 'createUser']);

    //Modifiche utente
    Route::patch( '/user/{userId}', [User::class, 'modifyUser']);
    Route::post( '/user/{userId}/changeUserStatus', [User::class, 'changeUserStatus']);

});