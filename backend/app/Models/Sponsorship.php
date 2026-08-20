<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Sponsorship extends Model
{
    
    use HasFactory;
    
    protected $fillable = [
        'season_id',
        'tournament_id',
        'sponsor_id',
        'amount',
        'is_active'
    ];
    
    public function season()
    {
        return $this->belongsTo(Season::class);
    }

    public function tournament()
    {
        return $this->belongsTo(Tournament::class);
    }

    public function sponsor()
    {
        return $this->belongsTo(Sponsor::class);
    }
    
}
