<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Qualification;

class QualificationController extends Controller
{
    public function index()
    {
        $qualifications = Qualification::with('qualification_type')
                                        ->orderBy('qualification_name','asc')->get();

        return response()->json([
            'success' => true,
            'qualifications' => $qualifications,
        ]);
    }
}
