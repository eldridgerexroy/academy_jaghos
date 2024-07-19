<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Syllabus extends Model
{
    use HasFactory;

    protected $table = 'syllabus';

    protected $fillable = [
        'title',
        'year',
        'course_overview',
        'course_objectives',
        'grading_policy',
        'assignments',
        'required_readings',
        'university_major_id'
    ];

    public function university_major()
    {
        return $this->belongsTo(UniversityMajor::class, 'university_major_id');
    }
}