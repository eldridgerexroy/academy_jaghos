<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SyllabusTopic extends Model
{
    use HasFactory;

    protected $table = 'syllabus_topic';

    protected $fillable = [
        'title',
        'description',
        'syllabus_id'
    ];

    public function syllabus()
    {
        return $this->belongsTo(Syllabus::class, 'syllabus_id');
    }
}
