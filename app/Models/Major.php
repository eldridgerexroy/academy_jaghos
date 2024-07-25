<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Major extends Model
{
    public $timestamps = true; 
    protected $table = 'majors';
    protected $guarded = ['id'];
    protected $fillable = ['name', 'description'];

    public function universities()
    {
        return $this->belongsToMany(University::class, 'university_major');
    }

    public function departments()
    {
        return $this->belongsToMany(Department::class, 'university_major', 'major_id', 'department_id');
    }
}
