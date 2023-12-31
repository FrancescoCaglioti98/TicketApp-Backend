<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GroupModel extends Model
{
    use HasFactory;

    protected $table = 'groups';
    protected $primaryKey = 'id';
    public $timestamps = true;
    

    protected $fillable = [
        "name",
        "description"
    ];

}
