<?php

namespace App\Models\V1\District;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class District extends Model
{
    use HasFactory;

    protected $fillable = [
        'district_name',
        'description',
        'status',
        'isdeleted'
    ];
}
