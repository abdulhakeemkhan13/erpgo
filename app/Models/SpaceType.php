<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SpaceType extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'owned_by',
        'created_by',
    ];
}
