<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IsVisiter extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'date_time',
        'user_id',
        'company_id',
        'created_by',
        'created_by',
    ];
}
