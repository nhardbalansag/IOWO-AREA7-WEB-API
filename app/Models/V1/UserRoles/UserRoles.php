<?php

namespace App\Models\V1\UserRoles;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserRoles extends Model
{
    use HasFactory;

    protected $fillable = [
        'role',
        'description',
        'isdeleted'
    ];
}
