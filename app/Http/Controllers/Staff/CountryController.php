<?php

namespace App\Http\Controllers\Staff;

use App\Models\Country;
use App\Models\CountryLang;
use App\Models\Language;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Lang;

class CountryController
{
    protected $country;
    protected $countryLang;

    public function __construct()
    {
        $this->country = new Country();
        $this->countryLang = new CountryLang;
    }


    // Controller methods would go here

    public function index()
    {
        $countries = Country::with(['countryLanguages', 'currencies']) // eager loading
            ->latest()
            ->paginate(20); // استخدام paginate بدل get لو عندك بيانات كبيرة

        // Display All Countries 
        return view("staff.countries.index", compact("countries"));
    }



    public function create(Request $request)
    {
        return view("staff.countries.create");
    }

    public function store(Request $request)
    {
        try {
            $languages = Language::get();

            // Validate and Store New Country
            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'code' => 'required|string|max:10|unique:country,code',
            ]);
            // Create Country 
            $country = $this->country->create(['code' => $validated['code']]);

            // Create Country Language 
            foreach ($languages as $language) {
                $country->countryLanguages()->create([
                    'country_id' => $country->id, // Default name as code, can be updated later
                    'lang' => $language->code,
                    'name' => $validated['name'], // Default name as code, can be updated later
                ]);
            }
        } catch (\Throwable $th) {
            return response()->json(['error' => 'Failed to create country: ' . $th->getMessage()], 500);
        }
        // Redirect with Success Message
        return response()->json(['message' => 'Country created successfully']);
    }
}
