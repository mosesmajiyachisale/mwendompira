<?php

namespace App\Http\Controllers;

use App\Models\Player;
use App\Services\PlayerService;
use Illuminate\Http\Request;

class PlayerController extends Controller
{
    public function __construct(protected PlayerService $playerService) 
    {

    }

    public function index()
    {
        $players = $this->playerService->index();

        return response()->json([
            'success' => true,
            'players' => $players,
        ]);
    }

    public function show(Player $player)
    {
        $player = $this->playerService->show($player);

        return response()->json([
            'success' => true,
            'selectedPlayer' => $player,
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'person' => ['required', 'array'],
            'person.first_name' => ['required','string','max:20',],
            'person.middle_name' => ['nullable','string','max:20',],
            'person.last_name' => ['required','string','max:20',],
            'person.gender' => ['nullable','in:Male,Female',],
            'person.dob' => ['nullable','date',],
            'person.location_id' => ['nullable','exists:locations,id',],
            
            'player_code' => ['nullable','exists:codes,id',],
            'preferred_name' => ['nullable','string','max:20',],
            'preferred_foot' => ['nullable','in:Both,Left,Right',],
            'height_cm' => ['nullable','integer','min:150','max:220',],
        ]);

        $player = $this->playerService->store($validated);

        return response()->json([
            'success' => true,
            'message' => 'Player created successfully',
            'selectedPlayer' => $player,
        ]);
    }

    public function update(Request $request, Player $player)
    {
        $validated = $request->validate([
            'person' => ['required', 'array'],
            'person.first_name' => ['required','string','max:20',],
            'person.middle_name' => ['nullable','string','max:20',],
            'person.last_name' => ['required','string','max:20',],
            'person.gender' => ['nullable','in:Male,Female',],
            'person.dob' => ['nullable','date',],
            'person.location_id' => ['nullable','exists:locations,id',],

            'player_code' => ['nullable','exists:codes,id',],
            'preferred_name' => ['nullable','string','max:20',],
            'preferred_foot' => ['nullable','in:Both,Left,Right',],
            'height_cm' => ['nullable','integer','min:150','max:220',],
        ]);

        $player = $this->playerService->update(
            $player,
            $validated
        );

        return response()->json([
            'success' => true,
            'message' => 'Player updated successfully',
            'selectedPlayer' => $player,
        ]);
    }
}