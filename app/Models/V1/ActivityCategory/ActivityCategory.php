<?php

namespace App\Models\V1\ActivityCategory;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ActivityCategory extends Model
{
    use HasFactory;

    protected $fillable = [
        'activity_name',
        'description',
        'status',
        'isdeleted'
    ];
}
