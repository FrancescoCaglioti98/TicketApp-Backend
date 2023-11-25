<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CategoryToGroups extends Model
{
    use HasFactory;

    protected $table = 'categories_to_groups';
    public $timestamps = false;

    protected $fillable = [
        "category_id",
        "group_id"
    ];

}
