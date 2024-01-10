<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TicketStatustHistoryModel extends Model
{
    use HasFactory;
   
    protected $table = 'ticket_status_history';
    public $timestamps = true;
    
    protected $fillable = [
        "ticket_id",
        "status"
    ];

}
