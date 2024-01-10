<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    use HasFactory;

    protected $table = 'tickets';
    protected $primaryKey = 'id';
    
    public $timestamps = true;

    protected $fillable = [
        "short_description",
        "long_description",
        "category_id",
        "issued_user_id",
        "current_working_user",
        "current_status",
    ];
}
