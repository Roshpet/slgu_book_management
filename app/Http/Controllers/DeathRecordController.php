<?php

namespace App\Http\Controllers;

use App\Models\DeathRecord;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use PhpOffice\PhpWord\TemplateProcessor;

class DeathRecordController extends Controller
{
    /**
     * Display a listing of the death records with advanced search functionality.
     */
    public function index(Request $request)
    {
        $search = $request->input('search');

        $deaths = DeathRecord::when($search, function ($query, $search) {
            return $query->where('full_name', 'like', "%{$search}%")
                         ->orWhere('registration_number', 'like', "%{$search}%")
                         ->orWhere('cause_of_death', 'like', "%{$search}%")
                         // Advanced Search: Supports "March 2026" or "2026"
                         ->orWhereRaw("DATE_FORMAT(date_of_registration, '%M %Y') like ?", ["%{$search}%"])
                         ->orWhereRaw("DATE_FORMAT(date_of_registration, '%Y') = ?", [$search]);
        })->latest()->get();

        return view('deaths.index', compact('deaths'));
    }

    /**
     * Show the form for creating a new death record.
     */
    public function create()
    {
        return view('deaths.create');
    }

    /**
     * Store a newly created death record in storage.
     */
    public function store(Request $request)
    {
        $year = $request->date_of_registration ? explode('-', $request->date_of_registration)[0] : date('Y');

        $request->merge([
            'registration_number' => $year . '-' . $request->reg_sequence
        ]);

        $validated = $request->validate([
            'book_number'          => 'required|string',
            'page_number'          => 'required|string',
            'registration_number'  => 'required|string|unique:death_records,registration_number',
            'reg_sequence'         => 'required|string',
            'date_of_registration' => 'required|date|after_or_equal:date_of_death',
            'full_name'            => 'required|string',
            'sex'                  => 'required|string', // Added
            'nationality'          => 'required|string', // Added
            'date_of_death'        => 'required|date',
            'place_of_death'       => 'required|string',
            // 'place_of_birth'       => 'required|string',
            'cause_of_death'       => 'required|string',
            'age'                  => 'required|integer',
            'civil_status'         => 'required|string',
            'occupation'           => 'required|string',
        ], [
            'date_of_registration.after_or_equal' => 'The registration date cannot be earlier than the date of death.',
            'registration_number.unique'          => 'This Registration Number has already been used for the selected year.',
        ]);

        DeathRecord::create($validated);

        return redirect()->route('deaths.index')->with('success', 'Death record for ' . $request->full_name . ' has been saved successfully!');
    }

    /**
     * Generate PDF Report (Filtered List) for Death Records.
     */
    public function exportPDF(Request $request)
    {
        $search = $request->input('search');

        $deaths = DeathRecord::when($search, function ($query, $search) {
            return $query->where('full_name', 'like', "%{$search}%")
                         ->orWhere('registration_number', 'like', "%{$search}%")
                         ->orWhereRaw("DATE_FORMAT(date_of_registration, '%M %Y') like ?", ["%{$search}%"])
                         ->orWhereRaw("DATE_FORMAT(date_of_registration, '%Y') = ?", [$search]);
        })->latest()->get();

        $pdf = Pdf::loadView('deaths.pdf', compact('deaths'))
                  ->setPaper([0, 0, 612, 936], 'landscape');

        $filename = $search ? 'Death_Records_' . str_replace(' ', '_', $search) . '.pdf' : 'Death_Records_Report.pdf';

        return $pdf->download($filename);
    }

    /**
     * Generate Single Certificate PDF (View/Print only)
     */
    public function generateSinglePdf(Request $request, $id)
    {
        $death = DeathRecord::findOrFail($id);

        $details = [
            'issued_to'    => $request->query('issued_to', '________________'),
            'gender_ref'   => $request->query('gender_ref', 'her'),
            'or_number'    => $request->query('or_number', '________________'),
            'amount_paid'  => $request->query('amount_paid', '________________'),
            'current_date' => now()->format('F d, Y'),
            'date_paid'    => now()->format('n/j/y')
        ];

        $pdf = Pdf::loadView('deaths.certificate_pdf', compact('death', 'details'))
                  ->setPaper([0, 0, 612, 936], 'portrait');

        return $pdf->stream('Death_Certificate_' . $death->registration_number . '.pdf');
    }

    /**
     * Generate Editable Word Document (Death Certificate)
     */
    public function generateDocx(Request $request, $id)
    {
        $death = DeathRecord::findOrFail($id);

        $issuedTo = $request->query('issued_to', '________________');
        $genderRef = $request->query('gender_ref', 'her');
        $orNumber = $request->query('or_number', '________________');
        $amountPaid = $request->query('amount_paid', '________________');

        $currentDate = now()->format('F d, Y');
        $datePaid = now()->format('n/j/y');

        $templatePath = storage_path('app/templates/death_template.docx');

        if (!file_exists($templatePath)) {
            return back()->with('error', 'Template file not found.');
        }

        $templateProcessor = new TemplateProcessor($templatePath);

        // Mappings
        $templateProcessor->setValue('page_number', $death->page_number);
        $templateProcessor->setValue('book_number', $death->book_number);
        $templateProcessor->setValue('full_name', strtoupper($death->full_name));
        $templateProcessor->setValue('sex', strtoupper($death->sex)); // Added
        $templateProcessor->setValue('nationality', strtoupper($death->nationality)); // Added
        $templateProcessor->setValue('age', $death->age);
        $templateProcessor->setValue('civil_status', strtoupper($death->civil_status));
        $templateProcessor->setValue('occupation', strtoupper($death->occupation));
        // $templateProcessor->setValue('place_of_birth', strtoupper($death->place_of_birth));
        $templateProcessor->setValue('cause_of_death', strtoupper($death->cause_of_death));
        $templateProcessor->setValue('place_of_death', strtoupper($death->place_of_death));
        $templateProcessor->setValue('registration_number', $death->registration_number);
        $templateProcessor->setValue('date_of_registration', \Carbon\Carbon::parse($death->date_of_registration)->format('F d, Y'));
        $templateProcessor->setValue('date_of_death', \Carbon\Carbon::parse($death->date_of_death)->format('F d, Y'));

        // Modal and Date mappings
        $templateProcessor->setValue('issued_to', strtoupper($issuedTo));
        $templateProcessor->setValue('gender_ref', $genderRef);
        $templateProcessor->setValue('or_number', $orNumber);
        $templateProcessor->setValue('amount_paid', $amountPaid);
        $templateProcessor->setValue('current_date', $currentDate);
        $templateProcessor->setValue('date_paid', $datePaid);

        $fileName = 'Death_Certificate_' . str_replace('-', '_', $death->registration_number) . '.docx';
        $tempFile = tempnam(sys_get_temp_dir(), 'PHPWord');
        $templateProcessor->saveAs($tempFile);

        return response()->download($tempFile, $fileName)->deleteFileAfterSend(true);
    }
}
