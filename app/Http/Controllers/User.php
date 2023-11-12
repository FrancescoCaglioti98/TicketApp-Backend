<?php

namespace App\Http\Controllers;

use App\Traits\HttpResponses;
use App\Models\User as UserModel;
use Illuminate\Http\JsonResponse;
use App\Http\Requests\UserRequest;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class User extends Controller
{
    use HttpResponses;

    public function createUser(UserRequest $userInfo): JsonResponse
    {

        $userCreation = new UserModel();

        $userCreation->name = $userInfo->name;
        $userCreation->last_name = $userInfo->last_name;
        $userCreation->email = $userInfo->email;
        $userCreation->is_admin = $userInfo->is_admin ?? 0;

        /**
         * @todo : Aggiungere sistema di invio automatico delle password generate alla persona interessata
         * @todo : Aggiungere creazione causuale delle password
         */
        $userCreation->password = "Password01!";

        if ($userCreation->save()) {
            return $this->success(
                data: [],
                message: "User Created",
                code: 200
            );
        }

        return $this->error(
            data: [],
            message: "Error in the user creation",
            code: 500
        );
    }

    public function modifyUser($userId, Request $request) : JsonResponse
    {
     
        //Le informazioni di un utente possono essere modificate solo da un admin o da lui stesso

        if( !$request->user()->is_admin && $request->user()->id != $userId ) {
            return $this->error(
                data: [],
                message: 'Unauthorized',
                code: 401
            );
        }
        
        $user = UserModel::where('id', $userId)->first();

        $user->name = $request->name ?? $user->name;
        $user->last_name = $request->last_name ?? $user->last_name;

        if( $user->save() ) {
            return $this->success(
                data: [],
                message: 'User updated',
                code: 200
            );
        }
        
        return $this->error(
            data: [],
            message: "Error in the user update",
            code: 500
        );

    }

}
