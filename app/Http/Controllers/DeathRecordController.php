<?php

namespace App\Http\Controllers;

use App\Models\DeathRecord;
use Illuminate\Http\Request;

class DeathRecordController extends Controller
{
    /**
     * Display a listing of the death records with search functionality.
     */
    public function index(Request $request)
    {
        $search = $request->input('search');

        $deaths = DeathRecord::when($search, function ($query, $search) {
            return $query->where('full_name', 'like', "%{$search}%")
                         ->orWhere('registration_number', 'like', "%{$search}%")
                         ->orWhere('cause_of_death', 'like', "%{$search}%");
        })->latest()->get();

        return view('deaths.index', compact('deaths'));
    }

    /**
     * Show the form for creating a new death record.
     */
    public function create()
    {
        return view('deaths.create');
    }

    /**
     * Store a newly created death record in storage.
     */
    public function store(Request $request)
    {
        // 1. Sync Registration Number Year Prefix
        $year = $request->date_of_registration ? explode('-', $request->date_of_registration)[0] : date('Y');

        // 2. Merge Prefix and Sequence before validation
        $request->merge([
            'registration_number' => $year . '-' . $request->reg_sequence
        ]);

        $validated = $request->validate([
            'book_number'          => 'required|string',
            'page_number'          => 'required|string',
            'registration_number'  => 'required|string|unique:death_records,registration_number',
            'reg_sequence'         => 'required|string',

            // Logic: Registration date must be on or after the date of death
            'date_of_registration' => 'required|date|after_or_equal:date_of_death',

            'full_name'            => 'required|string',
            'date_of_death'        => 'required|date',
            'place_of_death'       => 'required|string',
            'place_of_birth'       => 'required|string', // Fixed: Resolves SQLSTATE[HY000]
            'cause_of_death'       => 'required|string',
            'age'                  => 'required|integer',
            'civil_status'         => 'required|string',
            'occupation'           => 'required|string',
        ], [
            // Custom error messages
            'date_of_registration.after_or_equal' => 'The registration date cannot be earlier than the date of death.',
            'registration_number.unique'          => 'This Registration Number has already been used for the selected year.',
        ]);

        DeathRecord::create($validated);

        return redirect()->route('deaths.index')->with('success', 'Death record for ' . $request->full_name . ' has been saved successfully!');
    }
}
