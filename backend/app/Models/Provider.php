<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Provider extends Model
{
    use HasFactory;

    protected $fillable = [
        'person_id',
        'provider_code',
        'preferred_name',
        'professional_qualification_id',
        'provider_type_id',
        'season_started',
        'is_active',
    ];

    public function person(): BelongsTo
    {
        return $this->belongsTo(Person::class,'person_id');
    }

    public function code(): BelongsTo
    {
        return $this->belongsTo(Code::class,'provider_code');
    }

    public function professional_qualification(): BelongsTo
    {
        return $this->belongsTo(Qualification::class,'professional_qualification_id');
    }
    
    public function provider_type(): BelongsTo
    {
        return $this->belongsTo(ProviderType::class,'provider_type_id');
    }

    public function season_started(): BelongsTo
    {
        return $this->belongsTo(Season::class,'season_started');
    }
}
