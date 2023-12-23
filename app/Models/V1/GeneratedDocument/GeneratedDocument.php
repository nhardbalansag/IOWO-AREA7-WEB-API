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
        'is_deleted',
        'file_location',
        'file_name',
        'file_type_category',
        'code'
    ];
}







