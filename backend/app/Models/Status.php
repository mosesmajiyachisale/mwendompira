<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Status extends Model
{
    
    use HasFactory;

    protected $fillable = [
        'status_name',
        'status_code',
        'status_desc',
        'status_type_id',
    ];

    public function status_type()
    {
        return $this->belongsTo(StatusType::class);
    }
}
