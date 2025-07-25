<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    protected $fillable = [
        'name',
        'email',
        'mobile_number',
        'address',
        'role_id',
    ];

    public function role()
    {
        return $this->belongsTo(Role::class);
    }
}
