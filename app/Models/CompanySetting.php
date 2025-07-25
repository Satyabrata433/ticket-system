<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CompanySetting extends Model
{
    protected $fillable = [
        'company_name',
        'company_email',
        'company_phone',
        'date_format',
        'company_address',
        'admin_logo',
        'customer_portal_logo',
    ];

}
