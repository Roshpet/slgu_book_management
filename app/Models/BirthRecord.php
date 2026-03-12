<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BirthRecord extends Model
{
    protected $fillable = [
        'book_number', 'page_number', 'registration_number', 'date_of_registration',
        'full_name', 'place_of_birth', 'date_of_birth', 'nationality',
        'name_of_mother', 'name_of_father', 'place_of_marriage', 'date_of_marriage'
    ];
}
