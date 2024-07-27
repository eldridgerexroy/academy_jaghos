<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class University extends Model
{
    public $timestamps = true;
    protected $table = 'universities';
    protected $guarded = ['id'];
    protected $fillable = [
        'name',
        'country_id',
        'city_id',
        'picture',
        'created_at',
        'updated_at'
    ];

    public function majors() 
    {
        return $this->belongsToMany(Major::class, 'university_major');
    }

    public function city() 
    {
        return $this->belongsTo(City::class, 'city_id');
    }

    public function country() 
    {
        return $this->belongsTo(Country::class, 'country_id');
    }
}
