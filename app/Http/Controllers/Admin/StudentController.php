<?php

namespace App\Http\Controllers\Admin;

use App\Models\Classe;
use App\Models\Student;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

class StudentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Fetch 10 students per page, ordered by `classe_id`
        $students = Student::orderBy('classe_id')->orderBy('first_name')->paginate(10);

        // Calculate the starting number for the current page
        $startingNumber = ($students->currentPage() - 1) * $students->perPage() + 1;

        return view('students.index', compact('students', 'startingNumber'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $classes = Classe::all();
        return view('students.create', compact('classes'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validate the input
        $validated = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'nullable|string|max:255',
            'date_of_birth' => 'nullable|date',
            'place_of_birth' => 'nullable|string|max:255',
            'sex' => 'required|in:male,female',
            'classe_id' => 'required|exists:classes,id',
            'parents_contact' => 'nullable|string|max:15',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'matricule' => 'required|string|unique:students,matricule',
        ]);

        // Handle photo upload if exists
        if ($request->hasFile('photo')) {
            $path = $request->file('photo')->store('students_photos', 'public');
            $validated['photo'] = $path;  // Save photo path to the database
        }

        // Create new student with the validated data
        $student = Student::create($validated);

        $studentName = $student->first_name.' '.$student->last_name;
        $studentClass = $student->classe->name;

        // Redirect back with a success message
        return redirect()->back()->with('success', 'L\'eleve '.$studentName.' enregistre en classe de '.$studentClass);
    }

    public function edit($id)
    {
        // Find the student by ID
        $student = Student::findOrFail($id);
        $classes = Classe::all(); // Fetch all classes for the dropdown

        // Pass the student and classes to the view
        return view('students.edit', compact('student', 'classes'));
    }

    public function update(Request $request, $id)
    {
        // Validate the input
        $validated = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'nullable|string|max:255',
            'date_of_birth' => 'nullable|date',
            'place_of_birth' => 'nullable|string|max:255',
            'sex' => 'required|in:male,female',
            'classe_id' => 'required|exists:classes,id',
            'parents_contact' => 'nullable|string|max:15',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'matricule' => 'required|string|unique:students,matricule,' . $id,
        ]);

        // Find the student
        $student = Student::findOrFail($id);

        // Handle photo upload if exists
        if ($request->hasFile('photo')) {
            // Delete old photo if exists
            if ($student->photo) {
                Storage::disk('public')->delete($student->photo);
            }
            $path = $request->file('photo')->store('students_photos', 'public');
            $validated['photo'] = $path;  // Save new photo path to the database
        } else {
            $validated['photo'] = $student->photo; // Keep old photo if not uploading a new one
        }

        // Update the student with the validated data
        $student->update($validated);

        $studentName = $student->first_name.' '.$student->last_name;
        $studentClass = $student->classe->name;

        // Redirect back with a success message
        return redirect()->back()->with('success', 'Modification sur l\'eleve '.$studentName.' en classe de '.$studentClass);
    }

    public function downloadPDF($classId)
    {
        // Fetch students associated with the specified class
        $students = Student::where('classe_id', $classId)->with('classe')->orderBy('first_name')->get();

        // Fetch the class details
        $class = Classe::findOrFail($classId); // Assuming you have a Classe model

        // Correctly set the logo path
        $logoPath = public_path('assets/images/logo.jpg');

        // Load the PDF view and pass the necessary data
        $pdf = Pdf::loadView('pdf.classe-list', compact('students', 'class', 'logoPath'));

        // Stream the generated PDF to the browser
        return $pdf->stream('CLASS_LIST_' . $class->name . '.pdf');
    }


    public function students_id($classId)
    {
        // Fetch students by class
        $students = Student::where('classe_id', $classId)->get();
        $logoPath = public_path('assets/images/logo.jpg');
        $pdfPaths = []; // Array to hold paths of the generated PDFs

        foreach ($students as $student) {
            // Generate PDF for each student
            $pdf = PDF::loadView('pdf.student_id', compact('student', 'logoPath'))->setPaper('A6', 'landscape');

            // Define file name and path
            $fileName = "student_id_{$student->id}.pdf";
            $filePath = storage_path("app/public/{$fileName}");

            // Save the PDF to the defined path
            file_put_contents($filePath, $pdf->output());
            $pdfPaths[] = $filePath; // Add the path to the array
        }

        // Create a zip file with the PDFs using ZipArchive
        $zipFileName = "student_ids_class_{$classId}.zip";
        $zipFilePath = storage_path("app/public/{$zipFileName}");

        $zip = new \ZipArchive();

        // Open the zip file for creation
        if ($zip->open($zipFilePath, \ZipArchive::CREATE | \ZipArchive::OVERWRITE) === TRUE) {
            // Add each PDF file to the zip
            foreach ($pdfPaths as $pdfPath) {
                $zip->addFile($pdfPath, basename($pdfPath)); // Add PDF to zip
            }
            $zip->close(); // Close the zip file
        } else {
            return redirect()->route('classes.index')->with('error', 'Could not create ZIP file.');
        }

        // Download the zip file
        return response()->download($zipFilePath)->deleteFileAfterSend(true);
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
