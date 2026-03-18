<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DeathRecord extends Model
{
    use HasFactory;

    protected $fillable = [
        // Administrative Details
        'book_number',
        'page_number',
        'registration_number',
        'date_of_registration',

        // Personal Details
        'full_name',
        'sex',           // Added
        'age',
        'civil_status',
        'occupation',
        'nationality',   // Added

        // Death Event Details
        'date_of_death',
        'place_of_death',
        'cause_of_death'
    ];

    /**
     * Cast dates to Carbon instances for easier formatting in views.
     */
    protected $casts = [
        'date_of_registration' => 'date',
        'date_of_death'        => 'date',
    ];
}
