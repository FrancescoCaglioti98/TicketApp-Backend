<?php

namespace App\Http\Controllers;

use App\Models\GroupModel;
use Illuminate\Http\Request;
use App\Traits\HttpResponses;
use App\Models\GroupToUserModel;
use Illuminate\Http\JsonResponse;
use App\Http\Requests\GroupRequest;
use App\Models\User as UserModel;
use App\Http\Controllers\User;
use Illuminate\Database\Eloquent\Collection;

use function PHPSTORM_META\map;

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

        if( !(new User())->isUserActive( $groupInfo->user_admin_id ) ) {
            return $this->error(
                data: [],
                message: 'User not active',
                code: 400
            );
        }

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

    public function modifyGroup( int $groupId, Request $groupInfo ) : JsonResponse
    {

        //Solo ammministratori e admin del gruppo possono aggiungere/togliere un utente
        if( !$this->canModifyGroup( $groupInfo, $groupId ) ) {
            return $this->error(
                data: [],
                message: 'Can\'t modify group',
                code: 401
            );
        }

        $group = $this->getGroupByID( $groupId );

        if(empty($group)) {
            return $this->error(
                data: [],
                message: 'Unknow Group',
                code: 404
            );
        }
        
        $group->name = $groupInfo->name ?? $group->name;
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

    public function changeGroupAdmin( int $groupId, int $userId ) : JsonResponse
    {

        $group = $this->getGroupByID( $groupId );

        if( !( new User() )->isUserActive( $userId ) ) {
            return $this->error(
                data: [],
                message: 'User is not active',
                code: 400
            );
        }

        $group->user_admin_id = $userId;

        if( $group->save() ) {
            return $this->success(
                data: $group->toArray(),
                message: 'Admin User Changed',
                code: 200
            );
        }

        return $this->error(
            data: [],
            message: "Error in the change",
            code: 500
        );

    }


    //SEZIONE UTENTI

    public function getGroupUsersInfo( int $groupId ) : JsonResponse
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

    public function addUserToGroup( int $groupId, int $userId, Request $request ) : JsonResponse
    {

        //Solo ammministratori e admin del gruppo possono aggiungere/togliere un utente
        if( !$this->canModifyGroup( $request, $groupId ) ) {
            return $this->error(
                data: [],
                message: 'Can\'t modify group',
                code: 401
            );
        }


        $alreadyExist = GroupTouserModel::where( 'group_id', $groupId)->where( 'user_id', $userId )->first();

        if( !empty($alreadyExist) ) {
            return $this->error(
                data:[],
                message:'User already present',
                code: 400
            );
        } else if ( empty( UserModel::where('id', $userId)->first() ) ) {
            return $this->error(
                data:[],
                message:'Unknow User',
                code: 400
            );
        }

        $userGroup = new GroupToUserModel();
        $userGroup->group_id = $groupId;
        $userGroup->user_id = $userId;

        if( $userGroup->save() ){
            return $this->success(
                data: [],
                message: "User added",
                code: 200
            );
        }

        return $this->error(
            data: [],
            message: "Error in the user add",
            code: 500
        );
        
    }

    public function removeUserFromGroup( int $groupId, int $userId, Request $request )
    {

        //Solo ammministratori e admin del gruppo possono aggiungere/togliere un utente
        if( !$this->canModifyGroup( $request, $groupId ) ) {
            return $this->error(
                data: [],
                message: 'Can\'t modify group',
                code: 401
            );
        } else if ( $this->isGroupAdmin( $groupId, $userId ) ) {
            return $this->error(
                data: [],
                message: 'Can\'t remove group admin',
                code: 401
            );
        }

        $result = GroupToUserModel::where( 'group_id', $groupId )->where( 'user_id', $userId )->delete();

        if( $result ) {
            return $this->success(
                data: [],
                message: 'User removed',
                code: 200
            );
        }

        return $this->error(
            data: [],
            message: 'Error in the user remove',
            code: 500
        );

    }



    public function getGroupByID( int $groupId ) : GroupModel
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

    private function canModifyGroup( Request $request, int $groupId )
    {

        if( $request->user()->is_admin ) {
            return true;
        } else if( $this->isGroupAdmin( $groupId, $request->user()->id ) ) {
            return true;
        }

        return false;

    }

    private function isGroupAdmin( int $groupId, int $userId )
    {

        $groupInfo = $this->getGroupByID( $groupId );
        if( $groupInfo->user_admin_id == $userId ) {
            return true;
        }

        return false;

    }

}
