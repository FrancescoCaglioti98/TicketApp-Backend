<?php

namespace App\Http\Controllers\Users;

use Carbon\Carbon;
use App\Models\User;
use Illuminate\Http\Request;
use App\Traits\HttpResponses;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;

class UsersTokens extends Controller
{

    use HttpResponses;

    public function login( Request $userInfo ) : JsonResponse
    {

        $userEmail = $userInfo->email;
        $userPassword = $userInfo->password;

        $user = User::where( "email", $userEmail )->first();

        if( empty( $user ) || !password_verify( $userPassword, $user->password ) ) {
            return $this->error(
                data: [],
                message: "Email or Password does not match",
                code: 400
            );
        }

        //Cancellazione di tutti i TOKEN pregressi
        DB::table('personal_access_tokens')->where( 'tokenable_id', $user->id )->delete();

        //Solo gli utenti attivi possono accedere
        if( $user->is_active ) {
            return $this->error(
                data: [],
                message: "You cannot access, your account is disabled.",
                code: 403
            );
        }

        $response = [
            "user" => $user,
            "token" => $user->createToken(
                $user->name.'_'.Carbon::now(),
                ['*'],
                Carbon::now()->addDays(6)
            )->plainTextToken,
        ];

        return $this->success(
            data: $response,
            message: "Authenticated",
            code: 200
        );

    }
}
