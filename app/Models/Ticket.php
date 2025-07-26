<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    protected $primaryKey = 'id';
    public $incrementing = false; // since id is string
    protected $keyType = 'string';

    protected $fillable = [
        'id', 'service', 'customer', 'partner', 'date_created', 'status',
    ];

    public function attachments()
    {
        return $this->hasMany(TicketAttachment::class, 'ticket_id', 'id');
    }

    public function notes()
    {
        return $this->hasMany(TicketNote::class, 'ticket_id', 'id');
    }
}
