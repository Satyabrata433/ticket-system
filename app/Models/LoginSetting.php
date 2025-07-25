<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LoginSetting extends Model
{
    protected $fillable = [
        'partner_login',
        'customer_login',
        'employee_login',
        'admin_login',
        'password_reset',
    ];
}
