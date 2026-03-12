<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MarriageRecord extends Model
{
    use HasFactory;

    protected $fillable = [
        // Administrative
        'book_number',
        'page_number',
        'registration_number',
        'date_of_registration',

        // Husband's Details
        'husband_name',
        'dob_husband',
        'place_of_birth_husband',
        'nationality_husband',
        'father_husband', // Added
        'mother_husband', // Added

        // Wife's Details
        'wife_name',
        'dob_wife',
        'place_of_birth_wife',
        'nationality_wife',
        'father_wife', // Added
        'mother_wife', // Added

        // Marriage Event
        'place_of_marriage',
        'date_of_marriage'
    ];
}
