<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DeathRecord extends Model
{
    use HasFactory;

    protected $fillable = [
        'book_number',
        'page_number',
        'registration_number',
        'date_of_registration',
        'full_name',
        'date_of_death',
        'place_of_death',
        'place_of_birth', // Added to fix SQLSTATE[HY000] error
        'age',
        'civil_status',
        'occupation',
        'cause_of_death'
    ];
}
