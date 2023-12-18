<?php

namespace App\Models\V1\GeneratedDocument;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GeneratedDocument extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'date_generated',
        'is_recognized',
        'file_location',
        'file_name',
        'code'
    ];
}







