<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TeamPlayer extends Model
{
    protected $table = 'team_players';

    protected $fillable = [
        'season_id',
        'team_id',
        'player_id',
        'position_id',
        'shirt_number',
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
}