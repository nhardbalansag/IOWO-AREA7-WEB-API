<?php

namespace App\Models\V1\Activity;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Activity extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'activity_category_id',
        'adult_attendance_count',
        'youth_attendance_count',
        'children_attendance_count',
        'total_tithes',
        'total_offering',
        'gospel_seed',
        'personal_tithes',
        'bible_studies_count',
        'received_jesus_count',
        'water_baptized_count',
        'children_dedication_count',
        'testimonies_miracles_details',
        'activity_date',
        'remarks'
    ];
}
