<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
Use App\Models\Season;

class SeasonController extends Controller
{    
    public function index(Request $request)
    {
        $currentYear = date('Y');
        $seasons = Season::where('id', '<=', $currentYear)->orderBy('id', 'desc')->get();

        return response()->json([
            'success' => true,
            'seasons' => $seasons,
        ]);
    }
    
    public function edit(Request $request, $id)
    {
        $currentYear = date('Y');
        $seasons = Season::where('id', '<=', $currentYear)->orderBy('id', 'desc')->get();
        $selectedSeason = Season::findOrFail($id);

        return response()->json([
            'success' => true,
            'selectedSeason' => $selectedSeason,
            'seasons' => $seasons,
        ]);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'season_code' => 'required',
            'start_date' => '',
            'end_date' => '',
            'is_active' => 'boolean',
        ]);

        $season = Season::findOrFail($id);
        $season->start_date = $request->start_date;
        $season->end_date = $request->end_date;
        $season->is_active = $request->is_active;
        $season->save();

    }
}
