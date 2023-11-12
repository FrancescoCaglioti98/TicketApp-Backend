<?php

namespace App\Http\Controllers\Users;

use App\Models\User;
use App\Traits\HttpResponses;
use Illuminate\Http\JsonResponse;
use App\Http\Requests\UserRequest;
use App\Http\Controllers\Controller;

class UserCreation extends Controller
{

    use HttpResponses;

    public function createUser(UserRequest $userInfo): JsonResponse
    {

        $userCreation = new User();

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
}
