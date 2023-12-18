<?php

namespace App\Models\V1\AssignedChurchLeader;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AssignedChurchLeader extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'church_id',
        'status',
        'isdeleted'
    ];
}
