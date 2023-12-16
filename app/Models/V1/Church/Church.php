<?php

namespace App\Models\V1\Church;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Church extends Model
{
    use HasFactory;

    protected $fillable = [
        'district_area_id',
        'church_location_id',
        'church_name',
        'description',
        'status',
        'isdeleted'
    ];
}
