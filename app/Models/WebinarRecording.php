<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WebinarRecording extends Model
{
    public $timestamps = true;
    protected $table = 'webinar_recording';
    protected $guarded = ['id'];
}
