<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class University extends Model
{
    public $timestamps = true;
    protected $table = 'universities';
    protected $guarded = ['id'];
}
