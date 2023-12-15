<?php

namespace App\Models\V1\UserCategory;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserCategory extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_category_title',
        'user_category_description',
        'status'
    ];
}
