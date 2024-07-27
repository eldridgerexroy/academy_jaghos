<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UniversityApplication extends Model
{
    use HasFactory;

    protected $table = 'university_application';

    protected $fillable = [
        'individual_application_quota',
        'individual_application_required_documents',
        'individual_application_quota_transfer',
        'united_distribution_quota_total',
        'united_distribution_quota_total_s1',
        'united_distribution_quota_total_s2',
        'united_distribution_quota_total_s3',
        'united_distribution_quota_total_s4',
        'united_distribution_quota_total_s5',
        'english_program',
        '5_graduate_system_can_apply',
        'university_major_id',
    ];

    public function universityMajor()
    {
        return $this->belongsTo(UniversityMajor::class, 'university_major_id');
    }
}
