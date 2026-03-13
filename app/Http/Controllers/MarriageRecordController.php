<?php

namespace App\Http\Controllers;

use App\Models\MarriageRecord;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use PhpOffice\PhpWord\TemplateProcessor;

class MarriageRecordController extends Controller
{
    /**
     * Display a listing of the marriage records with search functionality.
     */
    public function index(Request $request)
    {
        $search = $request->input('search');

        $marriages = MarriageRecord::when($search, function ($query, $search) {
            return $query->where('husband_name', 'like', "%{$search}%")
                         ->orWhere('wife_name', 'like', "%{$search}%")
                         ->orWhere('registration_number', 'like', "%{$search}%")
                         ->orWhere('place_of_marriage', 'like', "%{$search}%");
        })->latest()->get();

        return view('marriages.index', compact('marriages'));
    }

    /**
     * Show the form for creating a new marriage record.
     */
    public function create()
    {
        return view('marriages.create');
    }

    /**
     * Store a newly created marriage record in storage.
     */
    public function store(Request $request)
    {
        $year = $request->date_of_registration ? explode('-', $request->date_of_registration)[0] : date('Y');

        $request->merge([
            'registration_number' => $year . '-' . $request->reg_sequence
        ]);

        $validated = $request->validate([
            'book_number'                => 'required|string',
            'page_number'                => 'required|string',
            'registration_number'        => 'required|string|unique:marriage_records,registration_number',
            'reg_sequence'               => 'required|string',
            'date_of_registration'       => 'required|date|after_or_equal:date_of_marriage',
            'husband_name'               => 'required|string',
            'age_husband'                => 'required|numeric',
            'father_husband'             => 'required|string',
            'father_nationality_husband' => 'required|string',
            'mother_husband'             => 'required|string',
            'mother_nationality_husband' => 'required|string',
            'wife_name'                  => 'required|string',
            'age_wife'                   => 'required|numeric',
            'father_wife'                => 'required|string',
            'father_nationality_wife'    => 'required|string',
            'mother_wife'                => 'required|string',
            'mother_nationality_wife'    => 'required|string',
            'place_of_marriage'          => 'required|string',
            'date_of_marriage'           => 'required|date',
        ], [
            'date_of_registration.after_or_equal' => 'The registration date cannot be earlier than the date of marriage.',
            'registration_number.unique'          => 'This Registration Number has already been used for the selected year.',
        ]);

        MarriageRecord::create($validated);

        return redirect()->route('marriages.index')->with('success', 'Marriage record saved successfully!');
    }

    /**
     * Generate PDF Report (List) for Marriage Records.
     */
    public function exportPDF(Request $request)
    {
        $search = $request->input('search');

        $marriages = MarriageRecord::when($search, function ($query, $search) {
            return $query->where('husband_name', 'like', "%{$search}%")
                         ->orWhere('wife_name', 'like', "%{$search}%")
                         ->orWhere('registration_number', 'like', "%{$search}%");
        })->latest()->get();

        $pdf = Pdf::loadView('marriages.pdf', compact('marriages'))
                  ->setPaper([0, 0, 612, 936], 'landscape');

        return $pdf->download('Marriage_Records_Report.pdf');
    }

    /**
     * Generate Single Certificate PDF (View/Print only)
     */
    public function generateSinglePdf(Request $request, $id)
    {
        $marriage = MarriageRecord::findOrFail($id);

        $details = [
            'issued_to'    => $request->query('issued_to', '________________'),
            'gender_ref'   => $request->query('gender_ref', 'her'), // New: captured from modal dropdown
            'or_number'    => $request->query('or_number', '________________'),
            'amount_paid'  => $request->query('amount_paid', '________________'),
            'current_date' => now()->format('F d, Y'),
            'date_paid'    => now()->format('n/j/y')
        ];

        $pdf = Pdf::loadView('marriages.certificate_pdf', compact('marriage', 'details'))
                  ->setPaper([0, 0, 612, 936], 'portrait');

        return $pdf->stream('Marriage_Certificate_' . $marriage->registration_number . '.pdf');
    }

    /**
     * Generate Editable Word Document (LCR Form No. 3A)
     */
    public function generateDocx(Request $request, $id)
    {
        $marriage = MarriageRecord::findOrFail($id);

        $issuedTo = $request->query('issued_to', '________________');
        $genderRef = $request->query('gender_ref', 'her'); // New: captured from modal dropdown
        $orNumber = $request->query('or_number', '________________');
        $amountPaid = $request->query('amount_paid', '________________');

        $currentDate = now()->format('F d, Y');
        $datePaid = now()->format('n/j/y');

        $templatePath = storage_path('app/templates/marriage_template.docx');

        if (!file_exists($templatePath)) {
            return back()->with('error', 'Template file not found.');
        }

        $templateProcessor = new TemplateProcessor($templatePath);

        // Database mappings
        $templateProcessor->setValue('page_number', $marriage->page_number);
        $templateProcessor->setValue('book_number', $marriage->book_number);
        $templateProcessor->setValue('husband_name', strtoupper($marriage->husband_name));
        $templateProcessor->setValue('age_husband', $marriage->age_husband);
        $templateProcessor->setValue('father_husband', strtoupper($marriage->father_husband));
        $templateProcessor->setValue('father_nationality_husband', $marriage->father_nationality_husband);
        $templateProcessor->setValue('mother_husband', strtoupper($marriage->mother_husband));
        $templateProcessor->setValue('mother_nationality_husband', $marriage->mother_nationality_husband);
        $templateProcessor->setValue('wife_name', strtoupper($marriage->wife_name));
        $templateProcessor->setValue('age_wife', $marriage->age_wife);
        $templateProcessor->setValue('father_wife', strtoupper($marriage->father_wife));
        $templateProcessor->setValue('father_nationality_wife', $marriage->father_nationality_wife);
        $templateProcessor->setValue('mother_wife', strtoupper($marriage->mother_wife));
        $templateProcessor->setValue('mother_nationality_wife', $marriage->mother_nationality_wife);
        $templateProcessor->setValue('registration_number', $marriage->registration_number);
        $templateProcessor->setValue('date_of_registration', \Carbon\Carbon::parse($marriage->date_of_registration)->format('F d, Y'));
        $templateProcessor->setValue('date_of_marriage', \Carbon\Carbon::parse($marriage->date_of_marriage)->format('F d, Y'));
        $templateProcessor->setValue('place_of_marriage', strtoupper($marriage->place_of_marriage));

        // Modal and Date mappings
        $templateProcessor->setValue('issued_to', strtoupper($issuedTo));
        $templateProcessor->setValue('gender_ref', $genderRef); // Use ${gender_ref} in your Word template
        $templateProcessor->setValue('or_number', $orNumber);
        $templateProcessor->setValue('amount_paid', $amountPaid);
        $templateProcessor->setValue('current_date', $currentDate);
        $templateProcessor->setValue('date_paid', $datePaid);

        $fileName = 'Marriage_Certificate_' . str_replace('-', '_', $marriage->registration_number) . '.docx';
        $tempFile = tempnam(sys_get_temp_dir(), 'PHPWord');
        $templateProcessor->saveAs($tempFile);

        return response()->download($tempFile, $fileName)->deleteFileAfterSend(true);
    }
}
