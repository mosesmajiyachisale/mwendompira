<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Qualification extends Model
{
    
    use HasFactory;

    protected $fillable = [
        'qualification_name',
        'qualification_code',
        'issuing_organization',
        'description',
        'qualification_type_id',
    ];

    public function qualification_type()
    {
        return $this->belongsTo(QualificationType::class);
    }

}
