<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Code extends Model
{
    use HasFactory;

    protected $fillable = [
        'season_id',
        'code_name',
        'code_type_id',
        'is_used',
        'is_active',
    ];

    //
    public function player()
    {
        return $this->hasOne(Player::class);
    }
}
