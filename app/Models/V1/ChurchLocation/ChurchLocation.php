<?php

namespace App\Models\V1\ChurchLocation;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChurchLocation extends Model
{
    use HasFactory;

    protected $fillable = [
        'location_name',
        'description',
        'status',
        'isdeleted'
    ];
}
