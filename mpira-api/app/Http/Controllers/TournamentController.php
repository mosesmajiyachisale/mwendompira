<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

Use App\Models\Tournament;
Use App\Models\TournamentType;

class TournamentController extends Controller
{
    
    public function index(Request $request)
    {
        $tournaments = Tournament::with('tournament_type')
                                ->orderBy('tournament_name', 'asc')->get();
        $tournament_types = TournamentType::orderBy('tournament_type_name','asc')->get();
        
        return response()->json([
            'success' => true,
            'tournaments' => $tournaments,
            'tournament_types' => $tournament_types,
        ]);
    }

    
    public function store(Request $request)
    {        
        $validated = $request->validate([
            'tournament_name' => 'required|string|max:50',
            'tournament_code' => 'nullable|string|max:20',
            'tournament_type_id' => 'nullable|exists:tournament_types,id',
        ]);


        Tournament::updateOrCreate(
            [
                'tournament_name' => $request->tournament_name,
            ],
            [
                'tournament_code' => $request->tournament_code,
                'tournament_type_id' => $request->tournament_type_id,
                'created_at'  => date('Y-m-d H:i:s'),
                'updated_at'    => date('Y-m-d H:i:s'),
            ]
        );

        return response()->json([            
            'success' => true,
            'message' => $request->tournament_name . ' created successfully.',
        ]);
    }

    
    public function edit(Request $request,$id)
    {
        $selectedTournament = Tournament::findOrFail($id);
        $tournaments = Tournament::with('tournament_type')->orderBy('tournament_name', 'asc')->get();
        $tournament_types = TournamentType::orderBy('tournament_type_name','asc')->get();


        return response()->json([
            'selectedTournament' => $selectedTournament,
            'tournaments' => $tournaments,
            'tournament_types' => $tournament_types,
        ]);
    }

    
    public function update(Request $request,$id)
    { 
        $request->validate([
            'tournament_name' => 'required',
            'tournament_code' => '',
            'tournament_type_id' => '',
        ]);

        $tournament = Tournament::findOrFail($id);
        
        $tournament->tournament_name = $request->tournament_name;
        $tournament->tournament_code = $request->tournament_code;
        $tournament->tournament_type_id = $request->tournament_type_id;
        $tournament->save();

        return response()->json([            
            'success' => true,
            'message' => $request->tournament_name . ' edited successfully.',
        ]);
    }


}
