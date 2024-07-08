<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WebinarRecordingRequest extends Model
{
    public $timestamps = true;
    protected $table = 'recording_request';
    protected $guarded = ['id'];
}
