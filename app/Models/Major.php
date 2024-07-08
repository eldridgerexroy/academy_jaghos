<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Major extends Model
{
    public $timestamps = true;
    protected $table = 'majors';
    protected $guarded = ['id'];
}
