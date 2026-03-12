<?php

namespace App\Http\Controllers;

use App\Models\BirthRecord;
use Illuminate\Http\Request;

class BirthRecordController extends Controller
{
    /**
     * Display a listing of the birth records with search functionality.
     */
    public function index(Request $request)
    {
        $search = $request->input('search');

        $births = BirthRecord::when($search, function ($query, $search) {
            return $query->where('full_name', 'like', "%{$search}%")
                         ->orWhere('registration_number', 'like', "%{$search}%");
        })->latest()->get();

        return view('births.index', compact('births'));
    }

    /**
     * Show the form for creating a new birth record.
     */
    public function create()
    {
        return view('births.create');
    }

    /**
     * Store a newly created birth record in storage.
     */
    public function store(Request $request)
    {
        // 1. Manually extract the year from the registration date
        $year = $request->date_of_registration ? explode('-', $request->date_of_registration)[0] : date('Y');

        // 2. Combine with the sequence to ensure the format 'YYYY-XXXX'
        $request->merge([
            'registration_number' => $year . '-' . $request->reg_sequence
        ]);

        $validated = $request->validate([
            'book_number'          => 'required|string',
            'page_number'          => 'required|string',
            // Validating the combined registration number against duplicates
            'registration_number'  => 'required|string|unique:birth_records,registration_number',
            // Validating the sequence part specifically if needed
            'reg_sequence'         => 'required|string',
            'date_of_registration' => 'required|date|after_or_equal:date_of_birth',
            'full_name'            => 'required|string',
            'place_of_birth'       => 'required|string',
            'date_of_birth'        => 'required|date',
            'nationality'          => 'required|string',
            'name_of_mother'       => 'required|string',
            'name_of_father'       => 'required|string',
            'place_of_marriage'    => 'nullable|string',
            'date_of_marriage'     => 'nullable|date',
        ], [
            'date_of_registration.after_or_equal' => 'The registration date cannot be earlier than the date of birth.',
            'registration_number.unique' => 'This Registration Number has already been recorded for this year.',
        ]);

        BirthRecord::create($validated);

        return redirect()->route('births.index')->with('success', 'Birth record for ' . $request->full_name . ' has been saved successfully!');
    }
}
