<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Season;
use App\Models\Team;
use App\Models\Player;
use App\Models\Position;
use App\Models\TeamPlayer;
use App\Models\Status;
use Illuminate\Database\QueryException;

class TeamPlayerController extends Controller
{
    public function index(Request $request)
    {
        $request->validate([
            'season_id' => 'nullable',
            'team_id' => 'nullable',
        ]);
        $season_id = $request->season_id ?? null;
        $team_id = $request->team_id ?? null;

        $currentYear = date('Y');
        $seasons = Season::where('id', '<=', $currentYear)->orderBy('id', 'desc')->get();
        
        $teamsQuery = Team::with('district')->orderBy('team_name', 'asc');
        
        $teamPlayersQuery = TeamPlayer::with([
                                                'season','team','player.person','position',
                                                'transferStatus','loanStatus'
                                            ]);

        if ($season_id) {
            $teamsQuery->whereIn('id',function ($query) use ($season_id) {
                    $query->select('team_id')
                        ->from('participations')
                        ->where('season_id', $season_id);
                }
            );
            $teamPlayersQuery->where('season_id', $season_id);
        
        } 

        if($team_id) {
            $teamPlayersQuery->where('team_id', $team_id);
        }
        
        $teams = $teamsQuery->get();
        $teamPlayers = $teamPlayersQuery->get();

        $players = Player::with('person')->get();
        $positions = Position::with('slots')->get();

        $statuses = Status::whereHas('status_type', function($query){
            $query->where('status_type_name', 'Transfer/Loan Status' );
        })->get();

        return response()->json([
            'success' => true,
            'seasons' => $seasons,
            'teams' => $teams,
            'players' => $players,
            'positions' => $positions,
            'teamPlayers' => $teamPlayers,
            'transfer_statuses' => $statuses,
            'loan_statuses' => $statuses,
        ]);
    }
 
    public function store(Request $request)
    {
        $validated = $request->validate([
            'season_id' => 'required|exists:seasons,id',
            'team_id' => 'required|exists:teams,id',
            'player_id' => 'required|exists:players,id',
            'position_id' => 'required|exists:positions,id',
            'shirt_number' => 'nullable|integer|min:1|max:65535',
            'transfer_status_id' => 'required|exists:statuses,id',
            'loan_status_id' => 'required|exists:statuses,id',
        ]);

        $teamPlayer = null;

        try {

            $teamPlayer = TeamPlayer::create($validated);

        } catch (QueryException $ex) {

            if ($ex->getCode() !== '23000') {
                throw $ex;
            }

            // Duplicate constraint: ignore
        }

        if ($teamPlayer) {

            $teamPlayer->load([
                'season',
                'team',
                'player.person',
                'position',
                'transferStatus',
                'loanStatus',
            ]);
        }

        return response()->json([
            'success' => true,
            'message' => $teamPlayer
                ? 'Team player created successfully.'
                : 'Team player already exists.',
            'selectedTeamPlayer' => $teamPlayer,
        ], $teamPlayer ? 201 : 200);
    }
    
    public function show(Request $request, $id)
    {
        $selectedTeamPlayer = TeamPlayer::findOrFail($id);
        $request->validate([
            'season_id' => 'nullable',
            'team_id' => 'nullable',
        ]);
        $season_id = $request->season_id ?? null;
        $team_id = $request->team_id ?? null;

        $currentYear = date('Y');
        $seasons = Season::where('id', '<=', $currentYear)->orderBy('id', 'desc')->get();
        
        $teamsQuery = Team::with('district')->orderBy('team_name', 'asc');
        
        $teamPlayersQuery = TeamPlayer::with([
                                                'season','team','player.person','position',
                                                'transferStatus','loanStatus'
                                            ]);

        if ($season_id) {
            $teamsQuery->whereIn('id',function ($query) use ($season_id) {
                    $query->select('team_id')
                        ->from('participations')
                        ->where('season_id', $season_id);
                }
            );
            $teamPlayersQuery->where('season_id', $season_id);
        
        } 

        if($team_id) {
            $teamPlayersQuery->where('team_id', $team_id);
        }
        
        $teams = $teamsQuery->get();
        $teamPlayers = $teamPlayersQuery->get();

        $players = Player::with('person')->get();
        $positions = Position::with('slots')->get();

        $statuses = Status::whereHas('status_type', function($query){
            $query->where('status_type_name', 'Transfer/Loan Status' );
        })->get();

        return response()->json([
            'success' => true,
            'seasons' => $seasons,
            'teams' => $teams,
            'players' => $players,
            'selectedTeamPlayer' => $selectedTeamPlayer,
            'positions' => $positions,
            'teamPlayers' => $teamPlayers,
            'transfer_statuses' => $statuses,
            'loan_statuses' => $statuses,
        ]);
    }

    
    public function update(Request $request, $id)
    {
        $selectedTeamPlayer = TeamPlayer::findOrFail($id);

        $validated = $request->validate([
            'season_id' => 'required|exists:seasons,id',
            'team_id' => 'required|exists:teams,id',
            'player_id' => 'required|exists:players,id',
            'position_id' => 'required|exists:positions,id',
            'shirt_number' => 'nullable|integer|min:1|max:65535',
            'transfer_status_id' => 'required|exists:statuses,id',
            'loan_status_id' => 'required|exists:statuses,id',
        ]);
        
        try {
        
            $selectedTeamPlayer->update($validated);
        
        } catch (QueryException $ex) {
        
            if ($ex->getCode() === '23000') {
                // Ignore duplicate constraint
            } else {
                throw $ex;
            }
        }

        $selectedTeamPlayer->load([
            'season',
            'team',
            'player.person',
            'position',
            'transferStatus',
            'loanStatus',
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Team player edited successfully.',
            // 'selectedTeamPlayer' => $selectedTeamPlayer,
        ]);
    }
}
