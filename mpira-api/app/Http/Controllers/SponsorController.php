<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
Use App\Models\Sponsor;

class SponsorController extends Controller
{
    public function index(Request $request)
    {
        $sponsors = Sponsor::orderBy('sponsor_name', 'asc')->get();

        return response()->json([
            'success' => true,
            'sponsors' => $sponsors,
        ]);
    }

    
    public function store(Request $request)
    {        
        $request->validate([
            'sponsor_name' => 'required',
            'sponsor_code' => '',
            'sponsor_desc' => '',
        ]);


        Sponsor::updateOrCreate(
            [
                'sponsor_name' => $request->sponsor_name,
            ],
            [
                'sponsor_code' => $request->sponsor_code,
                'sponsor_desc' => $request->sponsor_desc,
                'created_at'  => date('Y-m-d H:i:s'),
                'updated_at'    => date('Y-m-d H:i:s'),
            ]
        );

        return response()->json([            
            'success' => true,
            'message' => $request->sponsor_name . ' created successfully.',
        ]);
    }

    
    public function edit(Request $request,$id)
    {
        $selectedSponsor = Sponsor::findOrFail($id);
        $sponsors = Sponsor::orderBy('sponsor_name', 'asc')->get();


        return response()->json([
            'selectedSponsor' => $selectedSponsor,
            'sponsors' => $sponsors,
        ]);
    }

    
    public function update(Request $request,$id)
    { 
        $request->validate([
            'sponsor_name' => 'required',
            'sponsor_code' => '',
            'sponsor_desc' => '',
        ]);

        $sponsor = Sponsor::findOrFail($id);
        
        $sponsor->sponsor_name = $request->sponsor_name;
        $sponsor->sponsor_code = $request->sponsor_code;
        $sponsor->sponsor_desc = $request->sponsor_desc;
        $sponsor->save();

        return response()->json([            
            'success' => true,
            'message' => $request->sponsor_name . ' edited successfully.',
        ]);
    }

}
