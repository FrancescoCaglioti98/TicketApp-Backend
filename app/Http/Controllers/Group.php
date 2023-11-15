<?php

namespace App\Http\Controllers;

use App\Models\GroupModel;
use App\Traits\HttpResponses;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class Group extends Controller
{
    
    use HttpResponses;

    public function getGroup( ?int $groupId = null ) : JsonResponse
    {

        if( $groupId != null ) {
            $result = $this->getGroupByID( $groupId )->toArray();
        } else {
            $result = GroupModel::all()->toArray();
        }

        return $this->success(
            data: $result,
        );

    }




    private function getGroupByID( int $groupId ) : GroupModel
    {
        return GroupModel::where( 'id', $groupId )->first() ;
    }

}
