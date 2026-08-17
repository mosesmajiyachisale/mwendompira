<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Phase;
use App\Models\Stage;

class PhaseController extends Controller
{
    public function index()
    {
        $phases = Phase::get();

        return response()->json([
            'success' => true,
            'phases' => $phases,
        ]);
    }
}
