<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Formation;
use App\Models\Slot;

class FormationController extends Controller
{
    public function index()
    {
        $formations = Formation::with('slots')
                                    ->orderBy('formation_rank', 'asc')
                                    ->orderBy('formation_name', 'asc')
                                    ->get();
        $slots = Slot::orderBy('position_id','asc')->orderBy('slot_code','asc')->get();
        return response()->json([
            'success' => true,
            'formations' => $formations,
            'slots' => $slots,
        ]);
    }

}
