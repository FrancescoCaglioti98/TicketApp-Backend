<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\Group;
use App\Http\Controllers\User;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Users\UsersTokens;


Route::post("/login", [UsersTokens::class, 'login']);

Route::group(['middleware' => ['auth:sanctum']], function () {


    /**
     * USER
     */

    //Recupero Utenti/Utente
    Route::get( '/user/{userId?}', [User::class, 'getUserInfo'] );
    
    //Creazione utente
    Route::post( '/user', [User::class, 'createUser']);

    //Modifiche utente
    Route::patch( '/user/{userId}', [User::class, 'modifyUser']);
    Route::post( '/user/{userId}/changeUserStatus', [User::class, 'changeUserStatus']);
    Route::post( '/user/{userId}/forceNewPassword', [ User::class, 'forceNewPassword' ] );



    /**
     * GROUP
     */
    Route::get( '/group/{groupId?}', [Group::class, 'getGroup'] );

    Route::post( '/group', [Group::class, 'createGroup'] );
    Route::patch( '/group/{groupId}', [Group::class, 'modifyGroup'] );
    
    //Gestione degli utenti assegnati ad un grupppo
    Route::get( '/group/{groupId}/user', [Group::class, 'getGroupUsersInfo'] );
    Route::post( '/group/{groupId}/user/{userId}', [Group::class, 'addUserToGroup'] );
    Route::delete( '/group/{groupId}/user/{userId}', [Group::class, 'removeUserFromGroup'] );


    /**
     * CATEGORY
     */
    Route::get( '/category/{categoryId?}', [CategoryController::class, 'getCategory'] );
    Route::post( '/category', [CategoryController::class, 'createCategory'] );
    Route::patch( '/category/{categoryId}', [CategoryController::class, 'modifyCategory'] );

    /**
     * Categories to groups
     */
    Route::get( '/category/{categoryId}/group', [CategoryController::class, 'getCategoryGroups'] );
    Route::post( '/category/{categoryId}/group/{groupId}', [CategoryController::class, 'addCategoryGroup'] );
    Route::delete( '/category/{categoryId}/group/{groupId}', [CategoryController::class, 'removeCategoryGroups'] );

});