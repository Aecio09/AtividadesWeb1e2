<?php

namespace App\Models;

use \Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    protected $table = 'ticket';

    protected $fillable = [
        'event_id',
        'ticket_name',
    ];

    public function event() {
        return $this->belongsTo(Event::class, 'event_id');
    }
}
