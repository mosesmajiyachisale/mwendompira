<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Position;

class PositionController extends Controller
{
    public function index() 
    {
        $positions = Position::with('slots')->get();
        return response()->json([
            'success' => true,
            'positions' => $positions,
        ]);
    }
}
