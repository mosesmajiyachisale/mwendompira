<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class TeamPlayer extends Model
{
    use HasFactory;
    protected $table = 'team_players';
    protected $fillable = [
        'season_id',
        'team_id',
        'player_id',
        'position_id',
        'shirt_number',
        'transfer_status_id',
        'loan_status_id',
    ];

    /**
     * Team player belongs to a season.
     */
    public function season(): BelongsTo
    {
        return $this->belongsTo(Season::class);
    }

    /**
     * Team player belongs to a team.
     */
    public function team(): BelongsTo
    {
        return $this->belongsTo(Team::class);
    }

    /**
     * Team player belongs to a player.
     */
    public function player(): BelongsTo
    {
        return $this->belongsTo(Player::class);
    }

    /**
     * Team player belongs to a position.
     */
    public function position(): BelongsTo
    {
        return $this->belongsTo(Position::class);
    }

    public function transferStatus(): BelongsTo
    {
        return $this->belongsTo(Status::class, 'transfer_status_id');
    }

    public function loanStatus(): BelongsTo
    {
        return $this->belongsTo(Status::class, 'loan_status_id');
    }
}