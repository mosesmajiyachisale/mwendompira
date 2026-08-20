<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Person;
use App\Models\Player;

class PlayerController extends Controller
{
    public function index(){
        $players = Player::with(['person','code'])
                            ->orderBy('updated_at','asc')
                            ->get();
                            
        return response()->json([
            'success' => true,
            'players' => $players,
        ]);
        
    }
    
    public function show(Player $player)
    {
        $player->load('person');
    
        return response()->json([
            'success' => true,
            'selectedPlayer' =>$player,
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'person' => ['required', 'array'],
            'person.first_name' => ['required','string','max:20'],
            'person.middle_name' => ['nullable','string','max:20'],
            'person.last_name' => ['required','string','max:20',],
            'person.gender' => ['nullable','in:Male,Female',],
            'person.dob' => ['nullable','date',],
            'person.location_id' => ['nullable','exists:locations,id',],
            'player_code' => ['nullable','exists:codes,id',],
            'preferred_name' => ['nullable','string','max:20',],
            'preferred_foot' => ['nullable','in:Both,Left,Right',],
            'height_cm' => ['nullable','integer','min:150','max:220',],
        ]);
    
    
        $player = DB::transaction(function () use ($validated) {
            $person = Person::create($validated['person']);
            return Player::create([
                'person_id' =>$person->id,
                'player_code' =>$validated['player_code'] ?? null,
                'preferred_name' =>$validated['preferred_name'] ?? null,
                'preferred_foot' =>$validated['preferred_foot'],
                'height_cm' =>$validated['height_cm'] ?? null,
            ]);
    
        });
        $player->load('person');
    
        return response()->json([
            'success' => true,
            'message' =>'Player created successfully',
            'selectedPlayer' =>$player,
        ]);
    }

    public function update(Request $request, Player $player)
    {
        $validated = $request->validate([
            'person' => ['required', 'array'],

            'person.first_name' => [
                'required',
                'string',
                'max:20',
            ],

            'person.middle_name' => [
                'nullable',
                'string',
                'max:20',
            ],

            'person.last_name' => [
                'required',
                'string',
                'max:20',
            ],

            'person.gender' => [
                'nullable',
                'in:Male,Female',
            ],

            'person.dob' => [
                'nullable',
                'date',
            ],

            'person.location_id' => [
                'nullable',
                'exists:locations,id',
            ],

            'player_code' => [
                'nullable',
                'exists:codes,id',
            ],

            'preferred_name' => [
                'nullable',
                'string',
                'max:20',
            ],

            'preferred_foot' => [
                'nullable',
                'in:Both,Left,Right',
            ],

            'height_cm' => [
                'nullable',
                'integer',
                'min:150',
                'max:220',
            ],
        ]);


        $player = DB::transaction(function () use (
            $validated,
            $player
        ) {

            /*
            * Update person
            */
            $player->person->update(
                $validated['person']
            );


            /*
            * Update player
            */
            $player->update([
                'player_code' =>
                    $validated['player_code'] ?? null,

                'preferred_name' =>
                    $validated['preferred_name'] ?? null,

                'preferred_foot' =>
                    $validated['preferred_foot'] ?? 'Right',

                'height_cm' =>
                    $validated['height_cm'] ?? null,
            ]);


            return $player;
        });


        $player->load('person');


        return response()->json([
            'success' => true,
            'message' => 'Player updated successfully',
            'selectedPlayer' => $player,
        ]);
    }

}
