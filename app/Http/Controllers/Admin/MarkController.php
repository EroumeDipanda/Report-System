<?php

namespace App\Http\Controllers\Admin;

use App\Models\Mark;
use App\Models\Classe;
use App\Models\Student;
use App\Models\Subject;
use App\Exports\ArrayExport;
use App\Exports\MarksExport;
use App\Imports\MarksImport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;

class MarkController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    // public function index(Request $request)
    // {
    //     $query = Mark::latest()
    //                  ->select('subject_id', 'sequence', 'classe_id', 'created_at') // Include created_at
    //                  ->with('classe','subject')
    //                  ->groupBy('subject_id', 'sequence', 'classe_id', 'created_at') // Group by created_at as well
    //                  ->orderBy('sequence');

    //     if ($request->filled('class_id')) {
    //         $query->where('classe_id', $request->class_id);
    //     }

    //     if ($request->filled('sequence')) {
    //         $query->where('sequence', $request->sequence);
    //     }

    //     // Get distinct marks and paginate
    //     $marks = $query->distinct()->paginate(13);
    //     $classes = Classe::all();

    //     // Add filled status to marks
    //     foreach ($marks as $mark) {
    //         $mark->filled = $mark->created_at !== null; // Add filled property
    //     }

    //     return view('marks.index', compact('marks', 'classes'));
    // }

    public function index(Request $request)
    {
        $classes = Classe::all();
        $classeId = $request->filled('class_id') ? $request->class_id : null;

        // Get all subjects for the selected class
        $subjects = Subject::where('classe_id', $classeId)->get();

        // Initialize marks array
        $marks = [];

        foreach ($subjects as $subject) {
            // Check if marks exist for this subject and class
            $mark = Mark::where('subject_id', $subject->id)
                         ->where('classe_id', $classeId)
                         ->when($request->filled('sequence'), function ($query) use ($request) {
                             return $query->where('sequence', $request->sequence);
                         })
                         ->first();

            // Determine filled status
            $filled = $mark && $mark->created_at !== null;

            $classe = Classe::find($request->class_id);

            $marks[] = [
                'classe' => $classe, // Get the actual Classe object
                'subject' => $subject,
                'filled' => $filled,
                'mark' => $mark,
                'sequence' => $request->sequence,
            ];


        }

        return view('marks.index', compact('marks', 'classes'));
    }










    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Retrieve all classes
        $classes = Classe::with(['subjects', 'students'])->get();

        return view('marks.create', compact('classes'));
    }

    public function getSubjects($id)
    {
        $classe = Classe::with('subjects')->findOrFail($id);
        return response()->json($classe->subjects);
    }

    public function getStudents($id)
    {
        $classe = Classe::with('students')->findOrFail($id);
        return response()->json($classe->students);
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // dd($request->all());

        // Validate input
        $request->validate([
            'classe_id' => 'required|exists:classes,id',
            'subject_id' => 'required|exists:subjects,id',
            'sequence' => 'required|in:1,2,3,4,5,6',
            'marks' => 'required|array',
            'marks.*' => 'required|numeric|min:0|max:100', // Adjust validation as needed
        ]);

        // Iterate through each student mark
        foreach ($request->input('marks') as $studentId => $mark) {
            // Determine appreciation based on the mark
            if ($mark == 0) {
                $appreciation ='Absent';
            } elseif ($mark < 10) {
                $appreciation ='C.N.A'; // Competences Not Acquired (CNA)
            } elseif ($mark >= 10 && $mark < 12) {
                $appreciation ='C.A.A'; // Competences markly Acquired (CAA)
            } elseif ($mark >= 12 && $mark < 14) {
                $appreciation ='C.A'; // Competences Acquired (CA)
            } elseif ($mark >= 14 && $mark < 16) {
                $appreciation ='C.W.A'; // Competences Well Acquired (CWA)
            } elseif ($mark >= 16 && $mark <= 20) {
                $appreciation ='C.V.W.A'; // Competences Very Well Acquired (CVWA)
            }

            // Store the mark
            Mark::updateOrCreate(
                [
                    'student_id' => $studentId,
                    'subject_id' => $request->input('subject_id'),
                    'classe_id' => $request->input('classe_id'),
                    'sequence' => $request->input('sequence'),
                ],
                [
                    'mark' => $mark,
                    'appreciation' => $appreciation,
                ]
            );
        }

        return redirect()->route('marks.index')->with('success', 'Marks have been saved successfully.');
    }


    public function view($classe_id, $subject_id, $sequence)
    {
        $marks = Mark::with('student')
            ->where('classe_id', $classe_id)
            ->where('subject_id', $subject_id)
            ->where('sequence', $sequence)
            ->get();

        $classe = Classe::find($classe_id);
        $subject = Subject::find($subject_id);

        return view('marks.view', compact('marks', 'classe', 'subject', 'sequence'));
    }


    public function export(Request $request)
    {
        // Get parameters from the request
        $classeId = $request->query('classe_id');
        $subjectId = $request->query('subject_id');
        $sequence = $request->query('sequence');

        // Validate parameters
        if (!$classeId || !$subjectId || !$sequence) {
            return back()->with('error', 'Missing parameters for export.');
        }

        // Fetch subject and class names
        $subject = Subject::find($subjectId);
        $classe = Classe::find($classeId);

        // Fetch students in the selected class
        $students = Student::where('classe_id', $classeId)->get();
        if ($students->isEmpty()) {
            return back()->with('error', 'No students found for this class.');
        }

        // Fetch marks for the selected subject and sequence
        $marks = Mark::where('classe_id', $classeId)
            ->where('subject_id', $subjectId)
            ->where('sequence', $sequence)
            ->get()
            ->keyBy('student_id');

        // Prepare data for export
        $exportData = [];
        foreach ($students as $student) {
            $mark = $marks->get($student->id);
            $exportData[] = [
                'matricule' => $student->matricule,
                'name_of_student' => $student->first_name . ' ' . $student->last_name,
                'classe_id' => $classeId,
                'subject_id' => $subjectId,
                'evaluation' => $sequence,
                'marks' => $mark ? $mark->mark : '0',
            ];
        }

        // Check if exportData is populated
        if (empty($exportData)) {
            return back()->with('error', 'No marks found for the selected parameters.');
        }

        // Return the Excel file download
        return Excel::download(new \App\Exports\ArrayExport($exportData), 'MARKS_' . $classe->name . '_' . $subject->code_subject . '_Eval ' . $sequence . '.xlsx');
    }





    public function import() {
        return view('marks.import');
    }


    public function store_import(Request $request)
    {
        // Validate the request for file upload
        $request->validate([
            'file' => 'required|file|mimes:xlsx,xls,csv',
        ]);

        try {
            // Load the Excel file
            $file = $request->file('file');
            $data = Excel::toArray(new MarksImport, $file);

            // Fetch all classes and subjects to map IDs to names
            $classes = Classe::all()->pluck('name', 'id')->toArray(); // ID mapped to class names
            $subjects = Subject::all()->pluck('name', 'id')->toArray(); // ID mapped to subject names

            // Initialize variables for success message
            $classeNames = [];
            $subjectNames = [];
            $evaluation = '';

            // Process the data starting from the second row
            foreach ($data[0] as $index => $row) {
                if ($index === 0) {
                    continue; // Skip the header row
                }

                // Validate name
                $name = trim($row[1]);
                if (empty($name) || !preg_match("/^[a-zA-Z\s]+$/", $name)) {
                    return back()->with('error', 'Invalid name format on row ' . ($index + 1));
                }

                // Retrieve class ID
                $classeId = (int)trim($row[2]); // Assuming the third column contains class IDs
                if (isset($classes[$classeId])) {
                    $classeNames[] = $classes[$classeId]; // Collect valid class names
                } else {
                    Log::warning("Invalid class ID '{$classeId}' on row " . ($index + 1));
                    return back()->with('error', 'Invalid class ID "' . $classeId . '" on row ' . ($index + 1));
                }

                // Retrieve subject ID
                $subjectId = (int)trim($row[3]);
                if (isset($subjects[$subjectId])) {
                    $subjectNames[] = $subjects[$subjectId]; // Collect valid subject names
                } else {
                    Log::warning("Invalid subject ID '{$subjectId}' on row " . ($index + 1));
                    return back()->with('error', 'Invalid subject ID "' . $subjectId . '" on row ' . ($index + 1));
                }

                // Assuming marks and evaluation are in the correct columns
                $marks = $row[5];
                $evaluation = $row[4];

                // Validate marks
                if (!is_numeric($marks) || $marks < 0 || $marks > 100) {
                    return back()->with('error', 'Invalid mark format on row ' . ($index + 1));
                }

                // Determine appreciation
                $appreciation = $this->determineAppreciation($marks);

                // Store the mark using the student ID directly from the file
                Mark::updateOrCreate(
                    [
                        'student_id' => Student::where('matricule', $row[0])->first()->id ?? null,
                        'subject_id' => $subjectId,
                        'classe_id' => $classeId,
                        'sequence' => $evaluation,
                    ],
                    [
                        'mark' => $marks,
                        'appreciation' => $appreciation,
                    ]
                );
            }

            // Create success message with class names, subject names, and evaluation
            $uniqueClasseNames = implode(', ', array_unique($classeNames));
            $uniqueSubjectNames = implode(', ', array_unique($subjectNames));
            $successMessage = "Marks for $uniqueClasseNames, have been imported and saved successfully in $uniqueSubjectNames, for Evaluation $evaluation.";

            return redirect()->route('marks.index')->with('success', $successMessage);
        } catch (\Exception $e) {
            return back()->with('error', 'Error importing file: ' . $e->getMessage());
        }
    }







    // Helper method to determine appreciation based on the mark
    // private function determineAppreciation($mark)
    // {
    //     if ($mark < 9) {
    //         return 'C.N.A';
    //     } elseif ($mark >= 9 && $mark <= 11) {
    //         return 'C.I.A';
    //     } elseif ($mark >= 12 && $mark <= 16) {
    //         return 'C.A';
    //     } else {
    //         return 'Expert';
    //     }
    // }

    private function determineAppreciation($mark)
    {
        if ($mark == 0) {
            return 'Absent';
        } elseif ($mark < 10) {
            return 'C.N.A'; // Competences Not Acquired (CNA)
        } elseif ($mark >= 10 && $mark < 12) {
            return 'C.A.A'; // Competences markly Acquired (CAA)
        } elseif ($mark >= 12 && $mark < 14) {
            return 'C.A'; // Competences Acquired (CA)
        } elseif ($mark >= 14 && $mark < 16) {
            return 'C.W.A'; // Competences Well Acquired (CWA)
        } elseif ($mark >= 16 && $mark <= 20) {
            return 'C.V.W.A'; // Competences Very Well Acquired (CVWA)
        }
    }










    /**
     * Remove the specified resource from storage.
     */
    public function destroy($classe_id, $subject_id, $sequence)
    {
        // Find the mark based on multiple parameters
        $mark = Mark::where('classe_id', $classe_id)
                    ->where('subject_id', $subject_id)
                    ->where('sequence', $sequence)
                    ->firstOrFail(); // Use firstOrFail to throw a 404 if not found

        // Delete the mark
        $mark->delete();

        // Redirect to the index page with a success message
        return redirect()->route('marks.index')
                         ->with('success', 'Mark deleted successfully');
    }

}
