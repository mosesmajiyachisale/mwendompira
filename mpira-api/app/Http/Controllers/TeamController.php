<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Team;
use App\Models\Location;

class TeamController extends Controller
{

    public function index(Request $request)
    {
        $teams = Team::with('district')
            ->orderBy('team_name', 'asc')
            ->get();


        return response()->json([
            'success' => true,
            'teams' => $teams,
            'districts' => $this->districts(),
        ]);
    }


    public function store(Request $request)
    {
        $request->validate([
            'team_name' => 'required',
            'team_code' => 'nullable',
            'nickname' => 'nullable',
            'est' => 'nullable',
            'district_id' => 'nullable|exists:locations,id',
        ]);


        Team::updateOrCreate(
            [
                'team_name' => $request->team_name,
            ],
            [
                'team_code' => $request->team_code,
                'nickname' => $request->nickname,
                'est' => $request->est,
                'district_id' => $request->district_id,
            ]
        );


        return response()->json([
            'success' => true,
            'message' => $request->team_name . ' created successfully.',
        ]);
    }


    public function edit(Request $request, $id)
    {
        $selectedTeam = Team::with('district')
            ->findOrFail($id);


        $teams = Team::with('district')
            ->orderBy('team_name', 'asc')
            ->get();


        return response()->json([
            'success' => true,
            'selectedTeam' => $selectedTeam,
            'teams' => $teams,
            'districts' => $this->districts(),
        ]);
    }


    public function update(Request $request, $id)
    {
        $request->validate([
            'team_name' => 'required',
            'team_code' => 'nullable',
            'nickname' => 'nullable',
            'est' => 'nullable',
            'district_id' => 'nullable|exists:locations,id',
        ]);


        $team = Team::findOrFail($id);


        $team->update([
            'team_name' => $request->team_name,
            'team_code' => $request->team_code,
            'nickname' => $request->nickname,
            'est' => $request->est,
            'district_id' => $request->district_id,
        ]);


        return response()->json([
            'success' => true,
            'message' => $request->team_name . ' edited successfully.',
        ]);
    }


    private function districts()
    {
        return Location::whereHas('location_type', function ($query) {
                $query->where('location_type_name', 'District');
            })
            ->orderBy('location_name')
            ->select(
                'id',
                'location_name as district_name'
            )
            ->get();
    }

}