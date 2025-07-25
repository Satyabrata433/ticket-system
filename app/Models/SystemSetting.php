<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SystemSetting extends Model
{
    protected $fillable = [
        'id_prefix',
        'ticket_status',
        'allow_customer',
        'internal_notes',
        'close_days',
        'attachment_size',
        'attachment_types',
    ];
}
