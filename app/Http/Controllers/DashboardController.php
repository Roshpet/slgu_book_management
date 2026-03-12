<?php

namespace App\Http\Controllers;

use App\Models\BirthRecord;
use App\Models\MarriageRecord;
use App\Models\DeathRecord;

class DashboardController extends Controller
{
    public function index()
    {
        $counts = [
            'births' => \App\Models\BirthRecord::count(),
            'marriages' => \App\Models\MarriageRecord::count(),
            'deaths' => \App\Models\DeathRecord::count(),
        ];

        return view('dashboard', compact('counts'));
    }
}
