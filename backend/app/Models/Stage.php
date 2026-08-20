<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Stage extends Model
{
    
    use HasFactory;
    
    protected $fillable = [
        'stage_name',
        'stage_code',
        'stage_desc',
        'tournament_type_id',
    ];

    /**
     * Get the Tournament_type associated with this Tournament
     */
    public function tournament_type()
    {
        return $this->belongsTo(TournamentType::class);
    }
}
