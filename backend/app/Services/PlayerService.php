<?php

namespace App\Services;

use App\Models\Person;
use App\Models\Player;
use Illuminate\Support\Facades\DB;

class PlayerService
{
    /**
     * Get all players.
     */
    public function index()
    {
        return Player::with(['person', 'code'])
            ->orderBy('updated_at', 'asc')
            ->get();
    }

    /**
     * Get a single player.
     */
    public function show(Player $player)
    {
        return $player->load('person');
    }

    /**
     * Create a player.
     */
    public function store(array $data)
    {
        return DB::transaction(function () use ($data) {
            /*
             * Create person
             */
            $person = Person::create($data['person']);

            /*
             * Create player
             */
            $player = Player::create([
                'person_id' => $person->id,
                'player_code' => $data['player_code'] ?? null,
                'preferred_name' => $data['preferred_name'] ?? null,
                'preferred_foot' => $data['preferred_foot'] ?? 'Right',
                'height_cm' => $data['height_cm'] ?? null,
            ]);

            return $player->load('person');
        });
    }

    /**
     * Update a player.
     */
    public function update(Player $player, array $data)
    {
        return DB::transaction(function () use ($player, $data) {

            /*
             * Update person
             */
            $player->person->update($data['person']);

            /*
             * Update player
             */
            $player->update([
                'player_code' => $data['player_code'] ?? null,
                'preferred_name' => $data['preferred_name'] ?? null,
                'preferred_foot' => $data['preferred_foot'] ?? 'Right',
                'height_cm' => $data['height_cm'] ?? null,
            ]);

            return $player->load('person');
        });
    }
}