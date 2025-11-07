<?php

namespace App\Models;

    use \Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use HasFactory;
    
    protected $table = 'events';

    protected $fillable = [
        'name',
        'description',
        'start_time',
        'end_time',
        'event_type',
    ];

    public function tickets() {
        return $this->hasMany(Ticket::class, 'event_id');
    }
}
