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

    // public function downloadMarksPdf(Request $request)
    // {
    //     // Retrieve class ID, subject ID, and sequence from request parameters
    //     $classeId = $request->input('id'); // Class ID
    //     $subjectId = $request->input('subject_id'); // Subject ID
    //     $sequence = $request->input('sequence'); // Evaluation sequence (enum type)

    //     // Retrieve the class
    //     $classe = Classe::find($classeId);
    //     dd($classe);

    //     if (!$classe) {
    //         // Handle the case where the class does not exist
    //         return response()->json(['error' => 'Class not found'], 404);
    //     }

    //     // Retrieve the specific subject by subject_id for the class
    //     $subject = $classe->subjects()->where('subjects.id', $subjectId)->first();
    //     // dd($subject);

    //     if (!$subject) {
    //         // Handle the case where the subject does not exist
    //         return response()->json(['error' => 'Subject not found'], 404);
    //     }

    //     // Retrieve marks related to the class, subject, and sequence
    //     $marks = Mark::whereHas('student', function($query) use ($classeId) {
    //         $query->where('classe_id', $classeId);
    //     })
    //     ->where('subject_id', $subject->id) // Filter by the exact subject
    //     ->where('sequence', $sequence) // Filter by sequence (enum)
    //     ->with('student')
    //     ->get();

    //     // Define the paths to the logos
    //     $leftLogoPath = public_path('assets/images/logo.jpg');
    //     $rightLogoPath = public_path('assets/images/logo.jpg');

    //     // Generate PDF
    //     $pdf = Pdf::loadView('pdf.marks', compact('marks', 'classe', 'subject', 'sequence', 'leftLogoPath', 'rightLogoPath'))
    //               ->setPaper('A4', 'portrait');

    //     // Return the PDF stream to the browser
    //     return $pdf->stream('marks.pdf');
    // }

    public function downloadMarksPdf(Request $request)
    {
        $classeId = $request->input('id');
        $sequence = $request->input('sequence');

        // Retrieve the class
        $classe = Classe::find($classeId);

        if (!$classe) {
            return response()->json(['error' => 'Class not found'], 404);
        }

        $subject = $classe->subjects->first();
        // dd($subject);

        $marks = Mark::where('subject_id', $subject->id) // Filter by subject
            ->where('sequence', $sequence) // Filter by sequence
            ->whereHas('student', function ($query) use ($classeId) {
                $query->where('classe_id', $classeId); // Filter students by class
            })
            ->with(['student', 'subject']) // Include relationships
            ->get();


        // dd($marks);
        // Check if marks exist
        if ($marks->isEmpty()) {
            return response()->json(['error' => 'No marks found for this class, subject, and sequence.'], 404);
        }

        // Get the subject for the PDF view
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
