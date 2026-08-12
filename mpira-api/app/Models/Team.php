<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Team extends Model
{
    
    use HasFactory;
    
    protected $fillable = [
        'team_name',
        'team_code',
        'nickname',
        'est',
        'district_id',
        'is_active',
    ];
    
    public function district()
    {
        return $this->belongsTo(Location::class, 'district_id');
    }
}
