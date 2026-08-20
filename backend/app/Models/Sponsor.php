<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Sponsor extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'sponsor_name',
        'sponsor_code',
        'sponsor_desc',
    ];
}
