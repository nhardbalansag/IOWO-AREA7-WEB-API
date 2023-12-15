<?php

namespace App\Models\V1\UserRoleAccess;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserRoleAccess extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'role_id',
        'access_type_id',
        'isdeleted'
    ];
}
