<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    //
    protected $fillable = [
        'name', 
        'view_tickets', 
        'edit_tickets', 
        'delete_tickets', 
        'assign_tickets'
    ];
}
