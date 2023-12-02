<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class GroupRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {

        if( $this->user()->is_admin ) {
            return true;
        }

        //se non si tratta di un admin devo verificare che la richiesta stia venendo fatta dall'admin del gruppo in questione ( se passato )
        //ad eccezzione della query DELETE ( da fare ) che può essere fatta solo da un amministratore
        if( $this->method() == 'DELETE' ) {
            return false;
        }


        $requestPath = $this->decodedPath();
        $requestPath = explode( '/', $requestPath );

        //i primi due elementi sono sempre API e GROUP
        array_shift( $requestPath );
        array_shift( $requestPath );

        if( empty( $requestPath ) || !is_numeric( $requestPath[0] ) ) {
            return false;
        }

        $userRequestId = $this->user()->id;

        if( \App\Http\Controllers\Group::isUserGroupAdmin($userRequestId, $requestPath[0]) ){
            return true;
        }

        return false;

    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            "name" => "required|string|max:64",
            "description" => 'string',
            "user_admin_id" => 'required|integer|exists:App\Models\User,id'
        ];
    }
}
