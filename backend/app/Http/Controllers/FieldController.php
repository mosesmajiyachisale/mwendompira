<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Field;

class FieldController extends Controller
{
    public function index()
    {
        $fields = Field::orderBy('field_name', 'asc')->get();

        return response()->json([
            'success' => true,
            'fields' => $fields,
        ]);
    }


    public function create()
    {
        return response()->json([
            'success' => true,
        ]);
    }


    public function store(Request $request)
    {
        $validated = $request->validate([
            'field_name' => 'required|string|max:100',
            'field_code' => 'required|string|max:30',
            'field_desc' => 'nullable|string',
        ]);

        $field = Field::create($validated);
        return response()->json([
            'success' => true,
            'selectedField' => $field,
        ]);
    }


    public function show($id)
    {
        $field = Field::findOrFail($id);

        return response()->json([
            'success' => true,
            'selectedField' => $field,
        ]);
    }


    public function edit($id)
    {
        $field = Field::findOrFail($id);

        return response()->json([
            'success' => true,
            'selectedField' => $field,
        ]);
    }


    public function update(Request $request, $id)
    {
        $field = Field::findOrFail($id);

        $validated = $request->validate([
            'field_name' => 'required|string|max:100',
            'field_code' => 'required|string|max:30',
            'field_desc' => 'nullable|string',
        ]);
        
        $field->field_name = $request->field_name;
        $field->field_code = $request->field_code;
        $field->field_desc = $request->field_desc;
        $field->save();

        return response()->json([
            'success' => true,
            'selectedField' => $field,
        ]);
    }


    public function destroy($id)
    {
        $field = Field::findOrFail($id);

        $field->delete();

        return response()->json([
            'success' => true,
            'message' =>
                'Field deleted successfully.',
        ]);
    }
}