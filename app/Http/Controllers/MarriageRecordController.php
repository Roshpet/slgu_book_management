<?php

namespace App\Http\Controllers;

use App\Models\MarriageRecord;
use Illuminate\Http\Request;

class MarriageRecordController extends Controller
{
    /**
     * Display a listing of the marriage records with search functionality.
     */
    public function index(Request $request)
    {
        // Get the search query from the request
        $search = $request->input('search');

        // Filter marriages based on the search query across multiple fields
        $marriages = MarriageRecord::when($search, function ($query, $search) {
            return $query->where('husband_name', 'like', "%{$search}%")
                         ->orWhere('wife_name', 'like', "%{$search}%")
                         ->orWhere('registration_number', 'like', "%{$search}%")
                         ->orWhere('place_of_marriage', 'like', "%{$search}%");
        })->latest()->get();

        return view('marriages.index', compact('marriages'));
    }

    /**
     * Show the form for creating a new marriage record.
     */
    public function create()
    {
        return view('marriages.create');
    }

    /**
     * Store a newly created marriage record in storage.
     */
    public function store(Request $request)
    {
        // 1. Extract the year from the date of registration
        $year = $request->date_of_registration ? explode('-', $request->date_of_registration)[0] : date('Y');

        // 2. Combine the year prefix with the editable sequence number
        $request->merge([
            'registration_number' => $year . '-' . $request->reg_sequence
        ]);

        $validated = $request->validate([
            'book_number'            => 'required|string',
            'page_number'            => 'required|string',

            // Validate the combined Year-Number string is unique in the database
            'registration_number'    => 'required|string|unique:marriage_records,registration_number',
            'reg_sequence'           => 'required|string',

            // Enforce that registration is on or after the marriage date
            'date_of_registration'   => 'required|date|after_or_equal:date_of_marriage',

            'husband_name'           => 'required|string',
            'wife_name'              => 'required|string',
            'place_of_birth_husband' => 'required|string',
            'place_of_birth_wife'    => 'required|string',
            'dob_husband'            => 'required|date',
            'dob_wife'               => 'required|date',
            'nationality_husband'    => 'required|string',
            'nationality_wife'       => 'required|string',
            'mother_husband'         => 'required|string',
            'father_husband'         => 'required|string',
            'mother_wife'            => 'required|string',
            'father_wife'            => 'required|string',
            'place_of_marriage'      => 'required|string',
            'date_of_marriage'       => 'required|date',
        ], [
            // Custom error messages for the registry logic
            'date_of_registration.after_or_equal' => 'The registration date cannot be earlier than the date of marriage.',
            'registration_number.unique'          => 'This Registration Number has already been used for the selected year.',
        ]);

        MarriageRecord::create($validated);

        return redirect()->route('marriages.index')->with('success', 'Marriage record saved successfully!');
    }
}
