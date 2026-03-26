<?php

namespace App\Http\Controllers;

use App\Models\BirthRecord;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use PhpOffice\PhpWord\TemplateProcessor;

class BirthRecordController extends Controller
{
    /**
     * Display a listing of the birth records with advanced search functionality.
     */
    public function index(Request $request)
    {
        $search = $request->input('search');

        $births = BirthRecord::when($search, function ($query, $search) {
            return $query->where('full_name', 'like', "%{$search}%")
                         ->orWhere('registration_number', 'like', "%{$search}%")
                         ->orWhereRaw("DATE_FORMAT(date_of_registration, '%M %Y') like ?", ["%{$search}%"])
                         ->orWhereRaw("DATE_FORMAT(date_of_registration, '%Y') = ?", [$search]);
        })->latest()->get();

        return view('births.index', compact('births'));
    }

    /**
     * Show the form for creating a new birth record.
     */
    public function create()
    {
        return view('births.create');
    }

    /**
     * Store a newly created birth record in storage.
     */
    public function store(Request $request)
    {
        // FIX: Handle the "N/A" string sent by the JavaScript for unknown fathers
        if ($request->date_of_marriage === 'N/A') {
            $request->merge(['date_of_marriage' => null]);
        }

        $year = $request->date_of_registration ? explode('-', $request->date_of_registration)[0] : date('Y');

        $request->merge([
            'registration_number' => $year . '-' . $request->reg_sequence
        ]);

        $validated = $request->validate([
            'book_number'          => 'required|string',
            'page_number'          => 'required|string',
            'registration_number'  => 'required|string|unique:birth_records,registration_number',
            'reg_sequence'         => 'required|string',
            'date_of_registration' => 'required|date|after_or_equal:date_of_birth',
            'full_name'            => 'required|string',
            'sex'                  => 'required|string',
            'place_of_birth'       => 'required|string',
            'date_of_birth'        => 'required|date',
            'nationality'          => 'required|string',
            'name_of_mother'       => 'required|string',
            'mother_nationality'   => 'required|string',
            'name_of_father'       => 'required|string',
            'father_nationality'   => 'required|string',
            'place_of_marriage'    => 'nullable|string',
            'date_of_marriage'     => 'nullable|date', // null is accepted now
        ], [
            'date_of_registration.after_or_equal' => 'The registration date cannot be earlier than the date of birth.',
            'registration_number.unique' => 'This Registration Number has already been recorded for this year.',
        ]);

        BirthRecord::create($validated);

        return redirect()->route('births.index')->with('success', 'Birth record for ' . $request->full_name . ' has been saved successfully!');
    }

    /**
     * Generate PDF Report (Filtered List)
     */
    public function exportPDF(Request $request)
    {
        $search = $request->input('search');

        $births = BirthRecord::when($search, function ($query, $search) {
            return $query->where('full_name', 'like', "%{$search}%")
                         ->orWhere('registration_number', 'like', "%{$search}%")
                         ->orWhereRaw("DATE_FORMAT(date_of_registration, '%M %Y') like ?", ["%{$search}%"])
                         ->orWhereRaw("DATE_FORMAT(date_of_registration, '%Y') = ?", [$search]);
        })->latest()->get();

        $pdf = Pdf::loadView('births.pdf', compact('births'))
                  ->setPaper([0, 0, 612, 936], 'landscape');

        $filename = $search ? 'Birth_Records_' . str_replace(' ', '_', $search) . '.pdf' : 'Birth_Records_Report.pdf';

        return $pdf->download($filename);
    }

    /**
     * Generate Single Certificate PDF
     */
    public function generateSinglePdf(Request $request, $id)
    {
        $birth = BirthRecord::findOrFail($id);

        $details = [
            'issued_to'    => $request->query('issued_to', '________________'),
            'gender_ref'   => $request->query('gender_ref', 'her'),
            'or_number'    => $request->query('or_number', '________________'),
            'amount_paid'  => $request->query('amount_paid', '________________'),
            'current_date' => now()->format('F d, Y'),
            'date_paid'    => now()->format('n/j/y')
        ];

        $pdf = Pdf::loadView('births.certificate_pdf', compact('birth', 'details'))
                  ->setPaper([0, 0, 612, 936], 'portrait');

        return $pdf->stream('Birth_Certificate_' . $birth->registration_number . '.pdf');
    }

    /**
     * Generate Editable Word Document
     */
    public function generateDocx(Request $request, $id)
    {
        $birth = BirthRecord::findOrFail($id);

        $issuedTo = $request->query('issued_to', '________________');
        $genderRef = $request->query('gender_ref', 'her');
        $orNumber = $request->query('or_number', '________________');
        $amountPaid = $request->query('amount_paid', '________________');

        $templatePath = storage_path('app/templates/birth_template.docx');

        if (!file_exists($templatePath)) {
            return back()->with('error', 'Template file not found.');
        }

        $templateProcessor = new TemplateProcessor($templatePath);

        // Data Mappings
        $templateProcessor->setValue('page_number', $birth->page_number);
        $templateProcessor->setValue('book_number', $birth->book_number);
        $templateProcessor->setValue('registration_number', $birth->registration_number);
        $templateProcessor->setValue('full_name', strtoupper($birth->full_name));
        $templateProcessor->setValue('sex', strtoupper($birth->sex));
        $templateProcessor->setValue('date_of_birth', \Carbon\Carbon::parse($birth->date_of_birth)->format('F d, Y'));
        $templateProcessor->setValue('place_of_birth', strtoupper($birth->place_of_birth));
        $templateProcessor->setValue('nationality', strtoupper($birth->nationality));

        // Parent Names and Nationalities
        $templateProcessor->setValue('name_of_mother', strtoupper($birth->name_of_mother));
        $templateProcessor->setValue('mother_nationality', strtoupper($birth->mother_nationality));
        $templateProcessor->setValue('name_of_father', strtoupper($birth->name_of_father));
        $templateProcessor->setValue('father_nationality', strtoupper($birth->father_nationality));

        // Parent Marriage Logic
        $templateProcessor->setValue('date_of_marriage', $birth->date_of_marriage ? \Carbon\Carbon::parse($birth->date_of_marriage)->format('F d, Y') : 'NOT APPLICABLE');
        $templateProcessor->setValue('place_of_marriage', strtoupper($birth->place_of_marriage ?? 'NOT APPLICABLE'));

        $templateProcessor->setValue('date_of_registration', \Carbon\Carbon::parse($birth->date_of_registration)->format('F d, Y'));

        // Modal/Payment Mappings
        $templateProcessor->setValue('issued_to', strtoupper($issuedTo));
        $templateProcessor->setValue('gender_ref', $genderRef);
        $templateProcessor->setValue('or_number', $orNumber);
        $templateProcessor->setValue('amount_paid', $amountPaid);
        $templateProcessor->setValue('current_date', now()->format('F d, Y'));
        $templateProcessor->setValue('date_paid', now()->format('n/j/y'));

        $fileName = 'Birth_Certificate_' . str_replace('-', '_', $birth->registration_number) . '.docx';
        $tempFile = tempnam(sys_get_temp_dir(), 'PHPWord');
        $templateProcessor->saveAs($tempFile);

        return response()->download($tempFile, $fileName)->deleteFileAfterSend(true);
    }
}
