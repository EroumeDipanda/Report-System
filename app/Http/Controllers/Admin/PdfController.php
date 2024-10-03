<?php

namespace App\Http\Controllers\Admin;

use App\Models\Mark;
use App\Models\Classe;
use App\Models\Subject;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Http\Controllers\Controller;

class PdfController extends Controller
{

    public function downloadMarksPdf(Request $request)
    {
        // Use the correct input names based on the route
        $classeId = $request->input('classe_id'); // Changed from 'id' to 'classe_id'
        $subjectId = $request->input('subject_id'); // Retrieve subject_id
        $sequence = $request->input('sequence');

        // Retrieve the class
        $classe = Classe::find($classeId);

        if (!$classe) {
            return response()->json(['error' => 'Class not found'], 404);
        }

        // Ensure the subject exists
        $subject = $classe->subjects()->find($subjectId);

        if (!$subject) {
            return response()->json(['error' => 'Subject not found'], 404);
        }

        // Retrieve marks for the specified subject, sequence, and class
        $marks = Mark::where('subject_id', $subject->id) // Filter by subject
            ->where('sequence', $sequence) // Filter by sequence
            ->whereHas('student', function ($query) use ($classeId) {
                $query->where('classe_id', $classeId); // Filter students by class
            })
            ->with(['student', 'subject']) // Include relationships
            ->get();

        // Check if marks exist
        if ($marks->isEmpty()) {
            return response()->json(['error' => 'No marks found for this class, subject, and sequence.'], 404);
        }

        // Get the subject for the PDF view
        // It's safe to get subject here since we know marks exist
        // We can re-fetch the subject if needed
        // $subject = $marks->first()->subject;

        // Define paths to logos
        $logoPath = public_path('assets/images/logo.jpg');

        // Generate PDF
        $pdf = Pdf::loadView('pdf.marks', compact('marks', 'classe', 'sequence', 'subject', 'logoPath'))
                  ->setPaper('A4', 'portrait');

        return $pdf->stream('marks.pdf');
    }









    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
