<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Field extends Model
{
    
    use HasFactory;
    
    protected $fillable = [
        'field_name',
        'field_code',
        'field_desc',
    ];

}
