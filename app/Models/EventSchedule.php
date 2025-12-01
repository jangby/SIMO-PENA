<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EventSchedule extends Model
{
    use HasFactory;
    protected $fillable = ['event_id', 'start_time', 'end_time', 'activity', 'pic'];

    protected $casts = [
    'start_time' => 'datetime',
    'end_time' => 'datetime',
];

    // Relasi balik ke event
    public function event() {
        return $this->belongsTo(Event::class);
    }
}