<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Location;

class LocationController extends Controller
{
    public function index()
    {
        $locations = Location::with([
            'location_type',
            'parent',
            'children',
        ])
        ->orderBy('location_name', 'asc')
        ->get();

        return response()->json([
            'success' => true,
            'locations' => $locations,
        ]);
    }

    public function show($id)
    {
        $location = Location::with([
            'location_type',
            'parent',
            'children',
        ])->findOrFail($id);

        return response()->json([
            'success' => true,
            'selectedLocation' => $location,
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'location_name' => 'required|string|max:100|unique:locations,location_name',
            'location_type_id' => 'required|exists:location_types,id',
            'parent_id' => 'nullable|exists:locations,id',
        ]);

        $location = Location::create($validated);

        return response()->json([
            'success' => true,
            'selectedLocation' => $location,
        ], 201);
    }

    public function update(Request $request, $id)
    {
        $location = Location::findOrFail($id);

        $validated = $request->validate([
            'location_name' =>
                'required|string|max:100|unique:locations,location_name,' . $id,

            'location_type_id' =>
                'required|exists:location_types,id',

            'parent_id' =>
                'nullable|exists:locations,id',
        ]);

        $location->update($validated);

        return response()->json([
            'success' => true,
            'selectedLocation' => $location,
        ]);
    }

    public function destroy($id)
    {
        $location = Location::findOrFail($id);

        $location->delete();

        return response()->json([
            'success' => true,
            'message' => 'Location deleted successfully.',
        ]);
    }
}