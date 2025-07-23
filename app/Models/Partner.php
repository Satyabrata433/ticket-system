<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Partner extends Model
{
    //
    use HasFactory;

    protected $fillable = [
        'business_name',
        'email',
        'address',
        'city',
        'state',
        'status',
        'contact_person_name',
        'contact_person_mobile',
    ];
}
