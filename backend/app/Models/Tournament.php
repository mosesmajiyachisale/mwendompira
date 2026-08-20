<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

Use App\Models\TournamentType;

class Tournament extends Model
{
    
    use HasFactory;
    
    protected $fillable = [
        'tournament_name',
        'tournament_code',
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
