<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class TournamentType extends Model
{
    
    use HasFactory;
    
    protected $fillable = [
        'tournament__type_name',
        'tournament_type_desc',
    ];
    
    public function tournaments()
    {
        return $this->hasMany(Tournament::class);
    }

    public function stages()
    {
        return $this->hasMany(Stage::class);
    }
}
