<?php

namespace App\Http\Controllers;

use App\Models\GroupModel;
use Illuminate\Http\Request;
use App\Traits\HttpResponses;
use App\Models\GroupToUserModel;
use Illuminate\Http\JsonResponse;
use App\Http\Requests\GroupRequest;
use Illuminate\Database\Eloquent\Collection;


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


    //SEZIONE UTENTI

    public function getGroupUsersInfo( int $groupId )
    {

        $users = $this->getGroupUsers( $groupId );

        $return = [];
        foreach ($users as $key => $user) {
            $return[] = (new User())->getUserById( $user->user_id )->toArray();
        }

        return $this->success(
            data: $return,
            message: "User List",
            code: 200
        );
    }

    



    private function getGroupByID( int $groupId ) : GroupModel
    {
        return GroupModel::where( 'id', $groupId )->first() ;
    }

    private function getGroupUsers( int $groupId ) : Collection
    {
        return GroupToUserModel::where( 'group_id', $groupId )->get();
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
