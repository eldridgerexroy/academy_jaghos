<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class University extends Model
{
    public $timestamps = true;
    protected $table = 'universities';
    protected $guarded = ['id'];
    protected $fillable = ['name', 'city', 'country', 'picture'];

    public function majors() 
    {
        return $this->belongsToMany(Major::class, 'university_major');
    }
}
