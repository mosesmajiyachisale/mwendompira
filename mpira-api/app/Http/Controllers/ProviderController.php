<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Models\Person;
use App\Models\ProviderType;
use App\Models\Provider;
use App\Models\Qualification;
use App\Models\Season;

class ProviderController extends Controller
{
    public function index () 
    {
        $providers = Provider::with(['person','provider_type','professional_qualification','season_started'])
                                ->orderBy('updated_at','desc')->get();
                                
        $provider_types = ProviderType::orderBy('provider_type_name','asc')->get();
        $qualifications = Qualification::whereHas('qualification_type', function($query){
                                                $query->where('qualification_type_name','Professional');
                                            })
                                ->orderBy('qualification_name','asc')->get();

        $currentYear = date("Y");
        $seasons = Season::where('id','<=',$currentYear)->orderBy('id','desc')->get();

        return response()->json([
            'success' => true,
            'providers' => $providers,
            'provider_types' => $provider_types,
            'qualifications' => $qualifications,
            'seasons' => $seasons,
        ]);
    }

    public function show(Provider $provider)
    {
        $provider->load('person');
    
        $provider_types = ProviderType::orderBy('provider_type_name','asc')->get();
        $qualifications = Qualification::whereHas('qualification_type', function($query){
                                                $query->where('qualification_type_name','Professional');
                                            })
                                ->orderBy('qualification_name','asc')->get();

        $currentYear = date("Y");
        $seasons = Season::where('id','<=',$currentYear)->orderBy('id','desc')->get();

        return response()->json([
            'success' => true,
            'selectedProvider' =>$provider,
            'provider_types' =>$provider_types,
            'qualifications' =>$qualifications,
            'seasons' =>$seasons,
        ]);
    }

    
    public function store(Request $request)
    {
        $validated = $request->validate([

            'person' => ['required','array',],
            'person.first_name' => [ 'required','string','max:20', ],
            'person.middle_name' => [ 'nullable','string','max:20', ],
            'person.last_name' => [ 'required','string','max:20', ],
            'person.gender' => [ 'nullable','in:Male,Female', ],
            'person.dob' => [ 'nullable','date', ],
            'person.location_id' => [ 'nullable','exists:locations,id', ],

            'provider_code' => ['nullable','exists:codes,id',],
            'preferred_name' => ['nullable','string','max:50',],
            'professional_qualification_id' => ['nullable','exists:qualifications,id',],
            'provider_type_id' => ['required','exists:provider_types,id',],
            'season_started' => ['nullable','exists:seasons,id',],
        ]);


        /*
        |--------------------------------------------------------------------------
        | Create person and provider
        |--------------------------------------------------------------------------
        */

        $provider = DB::transaction(function () use ($validated) {
            $person = Person::create($validated['person']);

            return Provider::create([
                'person_id' => $person->id,
                'provider_code' => $validated['provider_code'] ?? null,
                'preferred_name' => $validated['preferred_name'] ?? null,
                'professional_qualification_id' => $validated['professional_qualification_id'] ?? null,
                'provider_type_id' => $validated['provider_type_id'] ?? null,
                'season_started' => $validated['season_started'] ?? null,
            ]);

        });


        /*
        |--------------------------------------------------------------------------
        | Load relationships
        |--------------------------------------------------------------------------
        */

        // $provider->load([
        //     'person',
        //     'code',
        //     'professional_qualification',
        // ]);


        return response()->json([
            'success' => true,
            'message' => 'provider created successfully',
            'selectedProvider' => null,
        ]);
    }

    
    public function update(Request $request, Provider $provider)
    {
        
        $validated = $request->validate([

            'person' => ['required','array',],
            'person.first_name' => [ 'required','string','max:20', ],
            'person.middle_name' => [ 'nullable','string','max:20', ],
            'person.last_name' => [ 'required','string','max:20', ],
            'person.gender' => [ 'nullable','in:Male,Female', ],
            'person.dob' => [ 'nullable','date', ],
            'person.location_id' => [ 'nullable','exists:locations,id', ],

            'provider_code' => ['nullable','exists:codes,id',],
            'preferred_name' => ['nullable','string','max:50',],
            'professional_qualification_id' => ['nullable','exists:qualifications,id',],
            'provider_type_id' => ['required','exists:provider_types,id',],
            'season_started' => ['nullable','exists:seasons,id',],
        ]);



        $provider = DB::transaction(function () use ($validated,$provider) {

            /*
            * Update person
            */
            $provider->person->update( $validated['person']);

            /*
            * Update $provider
            */
            $provider->update([
                '$provider_code' => $validated['$provider_code'] ?? null,
                'preferred_name' => $validated['preferred_name'] ?? null,
                'professional_qualification_id' => $validated['professional_qualification_id'] ?? null,
                'provider_type_id' => $validated['provider_type_id'] ?? null,
                'season_started' => $validated['season_started'] ?? null,
            ]);


            return $provider;
        });


        $provider->load('person');


        return response()->json([
            'success' => true,
            'message' => '$provider updated successfully',
            'selectedProvider' => $provider,
        ]);
    }

}
