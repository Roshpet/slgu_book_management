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
        'age_husband',
        'nationality_husband',        // Newly Added
        'father_husband',
        'father_nationality_husband',
        'mother_husband',
        'mother_nationality_husband',

        // Wife's Details
        'wife_name',
        'age_wife',
        'nationality_wife',          // Newly Added
        'father_wife',
        'father_nationality_wife',
        'mother_wife',
        'mother_nationality_wife',

        // Marriage Event
        'place_of_marriage',
        'date_of_marriage'
    ];

    /**
     * Optional: Cast dates to Carbon instances if you want to
     * use format() directly on the model attributes.
     */
    protected $casts = [
        'date_of_registration' => 'date',
        'date_of_marriage' => 'date',
    ];
}
