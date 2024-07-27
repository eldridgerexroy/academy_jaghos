<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UniversityMajor extends Model
{
    use HasFactory;
    
    public $timestamps = true;
    protected $table = 'university_major';
    protected $guarded = ['id'];
    protected $fillable = ['university_id', 'major_id', 'department_id'];

    public function department() 
    {
        return $this->belongsTo(Department::class, 'department_id');
    }

    public function major() 
    {
        return $this->belongsTo(Major::class, 'major_id');
    }

    public function university() 
    {
        return $this->belongsTo(University::class, 'university_id');
    }

    public function universityApplications()
    {
        return $this->hasMany(UniversityApplication::class, 'university_major_id');
    }
}
