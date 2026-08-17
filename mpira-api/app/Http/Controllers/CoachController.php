<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Models\Person;
use App\Models\Provider;
use App\Models\ProviderType;
use App\Models\Qualification;

class CoachController extends Controller
{
    /**
     * Display a listing of providers.
     */
    public function index()
    {
        $coaches = Provider::with(['person','code','professional_qualification',])
                            ->whereHas('provider_type', function ($sqlQuery){
                                $sqlQuery->where('provider_type_name','Coach');
                            })
                            ->orderBy('updated_at', 'asc')
                            ->get();

        $qualifications = Qualification::whereHas(
                'qualification_type',
                function ($query) {
                    $query->where(
                        'qualification_type_name',
                        'Professional'
                    );
                }
            )
            ->orderBy('qualification_name', 'asc')
            ->get();

        return response()->json([
            'success' => true,
            'providers' => $coaches,
            'qualifications' => $qualifications,
        ]);
    }


    /**
     * Display the specified provider.
     */
    public function show($id)
    {
        $coach = Provider::findOrFail($id);
        $coach->load([
            'person',
            'code',
            'professional_qualification',
        ]);

        $qualifications = Qualification::whereHas(
                'qualification_type',
                function ($query) {
                    $query->where(
                        'qualification_type_name',
                        'Professional'
                    );
                }
            )
            ->orderBy('qualification_name', 'asc')
            ->get();

        return response()->json([
            'success' => true,
            'selectedCoach' => $coach,
            'qualifications' => $qualifications,
        ]);
    }


    /**
     * Store a newly created provider.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'person' => ['required','array',],
            'person.first_name' => ['required','string','max:20',],
            'person.middle_name' => ['nullable','string','max:20',],
            'person.last_name' => ['required','string','max:20',],
            'person.gender' => ['nullable','in:Male,Female',],
            'person.dob' => ['nullable','date',],
            'person.location_id' => ['nullable','exists:locations,id',],

            'provider_code' => ['nullable','exists:codes,id',],
            'preferred_name' => ['nullable','string','max:50',],
            'professional_qualification_id' => ['nullable','exists:qualifications,id',],
            'season_started' => ['nullable','exists:seasons,id',],
            'is_active' => ['sometimes','boolean',],
        ]);

        /*
        |--------------------------------------------------------------------------
        | Create person and provider
        |--------------------------------------------------------------------------
        */

        $coach = DB::transaction(function () use ($validated) {
            $provider_type_id = ProviderType::where('provider_type_name','Coach')->value('id');
            $person = Person::create( $validated['person'] );

            return provider::create([
                'person_id' => $person->id,
                'provider_code' => $validated['provider_code'] ?? null,
                'preferred_name' => $validated['preferred_name'] ?? null,
                'professional_qualification_id' => $validated['professional_qualification_id'] ?? null,
                'provider_type_id' => $provider_type_id,
                'season_started' => $validated['season_started'] ?? null,
                'is_active' => $validated['is_active'] ?? true,
            ]);
        });


        /*
        |--------------------------------------------------------------------------
        | Load relationships
        |--------------------------------------------------------------------------
        */

        // $coach->load([
        //     'person',
        //     'code',
        //     'professional_qualification',
        // ]);


        return response()->json([
            'success' => true,
            'message' => 'provider created successfully',
            // 'selectedCoach' => $coach,
        ]);
    }


    /**
     * Update the specified provider.
     */
    public function update(Request $request, Provider $coach)
    {
        $validated = $request->validate([

            'person' => ['required','array',],
            'person.first_name' => [ 'required','string','max:20',],
            'person.middle_name' => ['nullable','string','max:20',],
            'person.last_name' => ['required','string','max:20',],
            'person.gender' => ['nullable','in:Male,Female',],
            'person.dob' => ['nullable','date',],
            'person.location_id' => ['nullable','exists:locations,id',],
            'provider_code' => ['nullable','exists:codes,id',],
            'preferred_name' => ['nullable','string','max:50',],
            'professional_qualification_id' => ['nullable','exists:qualifications,id',],
            'season_started' => [ 'nullable','exists:seasons,id',],
            'is_active' => ['sometimes','boolean',],
        ]);


        DB::transaction(function () use ($validated, $coach) {

            $coach->person->update($validated['person']);
            $coach->update([    'provider_code' =>
                    $validated['provider_code'] ?? null,    
                    'preferred_name' => $validated['preferred_name'] ?? null,    
                    'professional_qualification_id' => $validated['professional_qualification_id'] ?? null,    
                    'season_started' => $validated['season_started'] ?? null,    
                    'is_active' => $validated['is_active'] ?? $coach->is_active,
            ]);
        });

        $coach->load([ 'person', 'code', 'professional_qualification', 'season_started',]);

        return response()->json([
            'success' => true,
            'message' => 'Coach updated successfully',
            'selectedCoach' => $coach,
        ]);
    }
}