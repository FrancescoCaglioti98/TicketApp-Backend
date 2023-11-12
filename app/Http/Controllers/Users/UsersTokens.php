<?php

namespace App\Http\Controllers\Users;

use Carbon\Carbon;
use App\Models\User;
use Illuminate\Http\Request;
use App\Traits\HttpResponses;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class UsersTokens extends Controller
{

    use HttpResponses;

    public function generateToken( Request $userInfo )
    {

        $userEmail = $userInfo->email;
        $userPassword = $userInfo->password;

        $user = User::where( "email", $userEmail )->first();

        if( empty( $user ) ) {
            return $this->error(
                data: [],
                message: "Email or Password does not match",
                code: 400
            );
        } else if ( !password_verify( $userPassword, $user->password ) ) {
            return $this->error(
                data: [],
                message: "Email or Password does not match",
                code: 400
            );
        } 

        //Cancellazione di tutti i TOKEN pregressi
        DB::table('personal_access_tokens')->where( 'tokenable_id', $user->id )->delete();

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
