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
        $userCreation->is_active = $userInfo->is_active ?? 0;
        if( isset( $userInfo->lang ) ) {
            $userCreation->lang = $userInfo->lang;
        }

        $userCreation->password = $this->generateUserPassword();

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

    public function modifyUser( int $userId, Request $request) : JsonResponse
    {
     
        //Le informazioni di un utente possono essere modificate solo da un admin o da lui stesso

        if( !$request->user()->is_admin && $request->user()->id != $userId ) {
            return $this->error(
                data: [],
                message: 'Unauthorized',
                code: 401
            );
        }
        
        $user = $this->getUserById($userId);

        if( empty( $user ) ) {
            return $this->error(
                data: [],
                message: "Unknow User",
                code: 400
            );
        }

        $user->name = $request->name ?? $user->name;
        $user->last_name = $request->last_name ?? $user->last_name;
        $user->lang = $request->lang ?? $user->lang;

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

    public function changeUserStatus( int $userId, Request $request) : JsonResponse
    {

        if( !$request->user()->is_admin ) {
            return $this->error(
                data:[],
                message:"Unauthorized",
                code: 403
            );
        }

        $user = $this->getUserById($userId);

        if( empty( $user ) ) {
            return $this->error(
                data: [],
                message: "Unknow User",
                code: 400
            );
        }

        $user->is_active = !$user->is_active;

        if( $user->save() ) {
            return $this->success(
                data: [
                    "user" => $user
                ],
                message: 'Changed User Status',
                code: 200
            );          
        }

        return $this->error(
            data: [],
            message: "Error in the update",
            code: 500
        );
        
    }
    
    public function forceNewPassword( int $userId, Request $request ) : JsonResponse
    {

        if( !$request->user()->is_admin ) {
            return $this->error(
                data: [],
                message: 'Unauthorized',
                code: 401
            );
        }

        $newPassword = $this->generateUserPassword();

        $user = $this->getUserById( $userId );

        $user->password = $newPassword;

        if( $user->save() ) {
            return $this->success(
                data: [],
                message: 'New Password Generated',
                code: 200
            );
        }
        
        return $this->error(
            data: [],
            message: "Error in the password generation",
            code: 500
        );

    }


    

    private function generateUserPassword() : string
    {

        /**
         * @todo : Aggiungere sistema di invio automatico delle password generate alla persona interessata
         * @todo : Aggiungere creazione causuale delle password
         */
        $password = "Password01!";

        return $password;
    }

    private function getUserById( int $userId ) : UserModel
    {
        return UserModel::where('id', $userId)->first();
    }

}
