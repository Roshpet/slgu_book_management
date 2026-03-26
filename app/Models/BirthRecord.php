<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent;
use Illuminate\Database\Eloquent\Model;

class BirthRecord extends Model
{
    use HasFactory;

    protected $fillable = [
        'book_number',
        'page_number',
        'registration_number',
        'date_of_registration',
        'full_name',
        'sex',                  // Added
        'place_of_birth',
        'date_of_birth',
        'nationality',
        'name_of_mother',
        'mother_nationality',   // Added
        'name_of_father',
        'father_nationality',   // Added
        'place_of_marriage',
        'date_of_marriage'
    ];

    /**
     * The attributes that should be cast.
     * This allows you to use ->format() on these dates in your Blade/Controller.
     */
    protected $casts = [
        'date_of_registration' => 'date',
        'date_of_birth' => 'date',
        'date_of_marriage' => 'date',
    ];
}
