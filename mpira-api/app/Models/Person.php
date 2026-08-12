<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Person extends Model
{
    use HasFactory;

    protected $table = 'persons';
    
    protected $fillable = [
        'first_name',
        'middle_name',
        'last_name',
        'gender',
        'dob',
        'location_id',
    ];

    public function location()
    {
        return $this->belongsTo(Location::class);
    }
    
    // One-to-one relationships to subtypes
    public function user()
    {
        return $this->hasOne(User::class);
    }
    
    public function player()
    {
        return $this->hasOne(Player::class);
    }

}
