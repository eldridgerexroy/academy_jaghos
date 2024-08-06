<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WebinarSchedule extends Model
{
    use HasFactory;
    protected $table = 'webinar_schedules';

    protected $fillable = [
        'webinar_id', 'days_of_week', 'start_time', 'end_time', 'timezone'
    ];

    protected $casts = [
        'days_of_week' => 'array',
    ];

    public function webinar()
    {
        return $this->belongsTo(Webinar::class);
    }
}
