<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GroupToUserModel extends Model
{
    
    use HasFactory;

    protected $table = 'groups_to_users';
    public $timestamps = false;
    

    protected $fillable = [
        "user_id",
        "group_id"
    ];

}
