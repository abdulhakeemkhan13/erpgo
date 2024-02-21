<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AwardType extends Model
{
    protected $fillable = [
        'name',
        'owned_by',
        'created_by',
    ];
}
