<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Syllabus extends Model
{
    use HasFactory;

    protected $table = 'syllabus';

    protected $fillable = ['major_id','university_id','title','description','year',];

    public function major()
    {
        return $this->belongsTo(Major::class, 'major_id');
    }

    public function university()
    {
        return $this->belongsTo(University::class, 'university_id');
    }
}
