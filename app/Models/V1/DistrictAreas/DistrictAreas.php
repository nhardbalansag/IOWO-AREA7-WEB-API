<?php

namespace App\Models\V1\DistrictAreas;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DistrictAreas extends Model
{
    use HasFactory;

    protected $fillable = [
        'district_id',
        'area_id',
        'status',
        'isdeleted'
    ];
}
