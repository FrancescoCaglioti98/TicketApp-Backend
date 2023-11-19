<?php

namespace App\Http\Controllers;

use App\Http\Requests\GroupRequest;
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
            $result = $this->getGroupByID( $groupId );
        } else {
            $result = GroupModel::all();
        }

        if( empty($result) && $groupId != null ) {
            return $this->error(
                data: [],
                message: 'Unknow Group',
                code: 404
            );
        } else if( empty($result) ) {
            return $this->error(
                data: [],
                message: 'No Group',
                code: 404
            );
        }

        return $this->success(
            data: $result->toArray(),
        );

    }

    public function createGroup( GroupRequest $groupInfo ) : JsonResponse
    {

        $group = new GroupModel();

        $group->name = $groupInfo->name;
        $group->description = $groupInfo->description ?? '';
        $group->user_admin_id = $groupInfo->user_admin_id;

        if( $group->save() ) {
            return $this->success(
                data: $group->toArray(),
                message: 'Group Created',
                code: 200
            );
        }

        return $this->error(
            data: [],
            message: "Error in the Group creation",
            code: 500
        );

    }

    public function modifyGroup( int $groupId, Request $groupInfo )
    {

        $group = $this->getGroupByID( $groupId );

        if(empty($group)) {
            return $this->error(
                data: [],
                message: 'Unknow Group',
                code: 404
            );
        }

        if( isset( $groupInfo->name ) && trim( $groupInfo->name ) != '' ) {
            $group->name = $groupInfo->name;
        }

        $group->description = $groupInfo->description ?? $group->description;

        if( $group->save() ) {
            return $this->success(
                data: $group->toArray(),
                message: 'Group Updated',
                code: 200
            );
        }

        return $this->error(
            data: [],
            message: "Error in the group update",
            code: 500
        );

    }




    private function getGroupByID( int $groupId ) : GroupModel
    {
        return GroupModel::where( 'id', $groupId )->first() ;
    }

    public static function isUserGroupAdmin( int $userId, int $groupId ) : bool
    {

        $groupInfo = ( new Group )->getGroupByID( $groupId );

        if( $groupInfo->user_admin_id == $userId ) {
            return true;
        }

        return false;
    }

}
