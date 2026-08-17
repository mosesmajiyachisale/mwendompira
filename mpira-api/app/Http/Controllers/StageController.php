<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Stage;
use App\Models\TournamentType;

class StageController extends Controller
{
    public function index()
    {
        $stages = Stage::get();
        $tournament_types = TournamentType::with('stages')->orderBy('tournament_type_name','asc')->get();

        return response()->json([
            'success' => true,
            'stages' => $stages,
            'tournament_types' => $tournament_types,
        ]);
    }
}
