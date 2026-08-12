<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

Use App\Models\Location;
Use App\Models\LocationType;

class StadiumController extends Controller
{
    public function index(Request $request)
    {
        
        $stadiums = Location::with('parent')
                                ->whereHas('location_type', function ($query) {
                                    $query->where('location_type_name', 'Stadium');
                                })
                                ->orderBy('location_name')
                                ->get();
                                
        $districts = Location::whereHas('location_type', function ($query) {
                                    $query->where('location_type_name', 'District');
                                })
                                ->orderBy('location_name')
                                ->get();

        return response()->json([
            'districts' => $districts,
            'stadiums' => $stadiums,
        ]);
    }

    
    public function store(Request $request)
    {

        $request->validate([
            'location_name' => 'required',
            'parent_id'    => 'required|integer',
        ]);

        $location_type = LocationType::where('location_type_name', 'Stadium')->firstOrFail();

        $location_type_id = $location_type->id;

        Location::updateOrCreate(
            [
                'location_name' => $request->location_name,
                'parent_id'    => $request->parent_id,
            ],
            [
                'location_type_id' => $location_type_id,
                'create_at'  => date('Y-m-d H:i:s'),
                'updated_at'    => date('Y-m-d H:i:s'),
            ]
        );

        return response()->json([            
            'success' => true,
            'message' => $location_name . ' created successfully.',
        ]);
    }

    public function edit(Request $request,$id)
    {
        $stadiums = Location::with('parent')
                                ->whereHas('location_type', function ($query) {
                                    $query->where('location_type_name', 'Stadium');
                                })
                                ->orderBy('location_name')
                                ->get();
                                
        $districts = Location::whereHas('location_type', function ($query) {
                                    $query->where('location_type_name', 'District');
                                })
                                ->orderBy('location_name')
                                ->get();

        $selectedStadium = Location::with(['parent'])->findOrFail($id);

        return response()->json([
            'selectedStadium' => $selectedStadium,
            'districts' => $districts,
            'stadiums' => $stadiums,
        ]);
    }

    public function update(Request $request,$id)
    {
        $request->validate([
            'location_name' => 'required',
            'parent_id'    => 'required|integer',
        ]);

        $location_type = LocationType::where('location_type_name', 'Stadium')->firstOrFail();

        $location_type_id = $location_type->id;

        // $stadium = Location::with(['parent'])->findOrFail($id);
        $selectedStadium = Location::with(['parent'])->findOrFail($id);
        
        $selectedStadium->location_name = $request->location_name;
        $selectedStadium->parent_id = $request->parent_id;
        $selectedStadium->location_type_id = $location_type_id;
        $selectedStadium->save();
        
        $stadiums = Location::with('parent')
                                ->whereHas('location_type', function ($query) {
                                    $query->where('location_type_name', 'Stadium');
                                })
                                ->orderBy('location_name')
                                ->get();
                                
        $districts = Location::whereHas('location_type', function ($query) {
                                    $query->where('location_type_name', 'District');
                                })
                                ->orderBy('location_name')
                                ->get();

        $selectedStadium = Location::with(['parent'])->findOrFail($id);

        return response()->json([
            'selectedStadium' => $selectedStadium,
            'districts' => $districts,
            'stadiums' => $stadiums,
        ]);
    }
}
