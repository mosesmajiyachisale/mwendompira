<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Slot extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'slot_name',
        'slot_code',
        'slot_desc',
        'position_id',
        'grid_x',
        'grid_y',
    ];
    
    public function position()
    {
        return $this->belongsTo(Position::class);
    }
    
}
