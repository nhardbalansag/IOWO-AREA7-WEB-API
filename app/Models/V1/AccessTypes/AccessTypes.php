<?php

namespace App\Models\V1\AccessTypes;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AccessTypes extends Model
{
    use HasFactory;

    protected $fillable = [
        'access',
        'description',
        'isdeleted'
    ];
}



