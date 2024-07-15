<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    use HasFactory;

    public $timestamps = true;
    protected $table = 'departments';
    protected $guarded = ['id'];
    protected $fillable = ['name', 'description'];

    public function majors()
    {
        return $this->belongsToMany(Major::class, 'university_major', 'department_id', 'major_id');
    }
}
