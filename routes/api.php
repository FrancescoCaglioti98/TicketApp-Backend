<?php

use App\Http\Controllers\Users\UsersTokens;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::post("/createToken", [UsersTokens::class, 'generateToken']);


Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});