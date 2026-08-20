<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Sponsorship;
use App\Models\Season;
use App\Models\Tournament;
use App\Models\Sponsor;

class SponsorshipController extends Controller
{
    public function index(Request $request)
    {
        $currentYear = date('Y');
        $sponsorships = Sponsorship::with(['season','tournament','sponsor'])
                                    ->where('season_id', '<=', $currentYear)
                                    ->orderBy('season_id', 'desc')->get();

        return response()->json([
            'success' => true,
            'sponsorships' => $sponsorships,
        ]);
    }

    public function create(Request $request)
    {
        $currentYear = date('Y');
        $seasons = Season::where('id', '<=', $currentYear)->orderBy('id', 'desc')->get();
        $tournaments = Tournament::orderBy('tournament_name','asc')->get();
        $sponsors = Sponsor::orderBy('sponsor_name','asc')->get();
        return response()->json([
            'success' => true,
            'seasons' => $seasons,
            'tournaments' => $tournaments,
            'sponsors' => $sponsors,
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'season_id' => 'required|exists:seasons,id',
            'tournament_id' => 'required|exists:tournaments,id',
            'sponsor_id' => 'required|exists:sponsors,id',
            'amount' => 'nullable',
        ]);

        
        Sponsorship::updateOrCreate(
            [
                'season_id' => $request->season_id,
                'tournament_id' => $request->tournament_id,
                'sponsor_id' => $request->sponsor_id,
            ],
            [
                'amount' => $request->amount,
                'created_at'  => date('Y-m-d H:i:s'),
                'updated_at'    => date('Y-m-d H:i:s'),
            ]
        );

        
        return response()->json([
            'success' => true,
        ]);
    }

    
    public function edit(Request $request, $id)
    {
        $currentYear = date('Y');
        $seasons = Season::where('id', '<=', $currentYear)->orderBy('id', 'desc')->get();
        $tournaments = Tournament::orderBy('tournament_name','asc')->get();
        $sponsors = Sponsor::orderBy('sponsor_name','asc')->get();

        $sponsorship = Sponsorship::with(['season','tournament','sponsor'])->findOrFail($id);

        return response()->json([
            'success' => true,
            'seasons' => $seasons,
            'tournaments' => $tournaments,
            'sponsors' => $sponsors,
            'selectedSponsorship' => $sponsorship,
        ]);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'season_id' => 'required|exists:seasons,id',
            'tournament_id' => 'required|exists:tournaments,id',
            'sponsor_id' => 'required|exists:sponsors,id',
            'amount' => 'nullable',
        ]);

        
        $sponsorship = Sponsorship::with(['season','tournament','sponsor'])->findOrFail($id);
        $sponsorship->tournament_id = $request->tournament_id;
        $sponsorship->sponsor_id = $request->sponsor_id;
        $sponsorship->amount = $request->amount;
        $sponsorship->save();

        
        return response()->json([
            'success' => true,
            'selectedSponsorship' => $sponsorship,
        ]);
    }

}
