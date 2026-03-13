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
        'age_husband', // Added
        'father_husband',
        'father_nationality_husband', // Added
        'mother_husband',
        'mother_nationality_husband', // Added

        // Wife's Details
        'wife_name',
        'age_wife', // Added
        'father_wife',
        'father_nationality_wife', // Added
        'mother_wife',
        'mother_nationality_wife', // Added

        // Marriage Event
        'place_of_marriage',
        'date_of_marriage'
    ];
}
