<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Location extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'location_name',
        'location_type_id',
        'parent_id',
    ];

    /**
     * Get the location_type associated with this location
     */
    public function location_type()
    {
        return $this->belongsTo(LocationType::class);
    }

    /**
     * Get the parent location (self-referencing)
     */
    public function parent()
    {
        return $this->belongsTo(Location::class, 'parent_id');
    }

    /**
     * Get child locations (self-referencing)
     */
    public function children()
    {
        return $this->hasMany(Location::class, 'parent_id');
    }
}
