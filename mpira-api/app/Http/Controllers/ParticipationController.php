<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Participation;
use App\Models\Season;
use App\Models\Tournament;
use App\Models\Team;
use App\Models\Sponsor;
use App\Models\Location;

class ParticipationController extends Controller
{
    public function index()
    {
        $participations = Participation::with(['season','tournament','team','sponsor','stadium'])
                                        ->get();

        return response()->json([
            'success' => true,
            'participations' => $participations
        ]);
    }

    public function create(Request $request)
    {
        $currentYear = date('Y');
        $seasons = Season::where('id', '<=', $currentYear)->orderBy('id', 'desc')->get();
        $tournaments = Tournament::orderBy('tournament_name','asc')->get();
        $teams = Team::orderBy('team_name','asc')->get();
        $sponsors = Sponsor::orderBy('sponsor_name','asc')->get();
        $stadiums = Location::with('parent')
                                ->whereHas('location_type', function ($query) {
                                    $query->where('location_type_name', 'Stadium');
                                })
                                ->orderBy('location_name')
                                ->get();

        return response()->json([
            'success' => true,
            'seasons' => $seasons,
            'tournaments' => $tournaments,
            'teams' => $teams,
            'sponsors' => $sponsors,
            'stadiums' => $stadiums,
        ]);
    }
 
    public function store(Request $request)
    {
        $request->validate([
            'season_id'=>'required|exists:seasons,id',
            'tournament_id'=>'required|exists:tournaments,id',
            'team_id'=>'required|exists:teams,id',
            'sponsor_id'=>'nullable|exists:sponsors,id',
            'stadium_id'=>'nullable|exists:locations,id'
        ]);

        $participation=Participation::updateOrCreate(
            [
                'season_id'=>$request->season_id,
                'tournament_id'=>$request->tournament_id,
                'team_id'=>$request->team_id
            ],
            [
                'sponsor_id'=>$request->sponsor_id,
                'stadium_id'=>$request->stadium_id
            ]
        );

        $participation->load(['season','tournament','team','sponsor','stadium']);
        return response()->json([
            'success'=>true,
            'selectedParticipation'=>$participation,
        ]);
    }
    
    public function edit(Request $request, $id)
    {
        $currentYear = date('Y');
        $seasons = Season::where('id', '<=', $currentYear)->orderBy('id', 'desc')->get();
        $tournaments = Tournament::orderBy('tournament_name','asc')->get();
        $teams = Team::orderBy('team_name','asc')->get();
        $sponsors = Sponsor::orderBy('sponsor_name','asc')->get();
        $stadiums = Location::with('parent')
                                ->whereHas('location_type', function ($query) {
                                    $query->where('location_type_name', 'Stadium');
                                })
                                ->orderBy('location_name')
                                ->get();

        $participation = Participation::findOrFail($id);
        $participation->load(['season','tournament','team','sponsor','stadium']);
        return response()->json([
            'success' => true,
            'seasons' => $seasons,
            'tournaments' => $tournaments,
            'teams' => $teams,
            'sponsors' => $sponsors,
            'stadiums' => $stadiums,
            'selectedParticipation' => $participation,
        ]);
    }
    
    public function update(Request $request, $id)
    {
        $request->validate([
            'season_id'=>'required|exists:seasons,id',
            'tournament_id'=>'required|exists:tournaments,id',
            'team_id'=>'required|exists:teams,id',
            'sponsor_id'=>'nullable|exists:sponsors,id',
            'stadium_id'=>'nullable|exists:locations,id'
        ]);
        
        $participation = Participation::findOrFail($id);
        
        $participation->tournament_id = $request->tournament_id;
        $participation->team_id = $request->team_id;
        $participation->sponsor_id = $request->sponsor_id;
        $participation->stadium_id = $request->stadium_id;
        $participation->save();
        $participation->load(['season','tournament','team','sponsor','stadium']);
        

        return response()->json([
            'success'=>true,
            'selectedParticipation'=>$participation,
        ]);
    }
    

}
