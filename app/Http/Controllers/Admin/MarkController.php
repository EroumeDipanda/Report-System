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
use Barryvdh\DomPDF\Facade\Pdf;
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
                        //  ->where('sequence', $request->sequence)
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
    // public function create()
    // {
    //     // Retrieve all classes
    //     $classes = Classe::with(['subjects', 'students'])->get();

    //     return view('marks.create', compact('classes'));
    // }
    public function create(Request $request)
    {
        $classes = Classe::all();
        $subjects = collect(); // Initialize an empty collection
        $students = collect(); // Initialize an empty collection

        if ($request->classe_id) {
            $subjects = Subject::where('classe_id', $request->classe_id)->orderBy('name')->get();
        }

        if ($request->classe_id && $request->subject_id) {
            $students = Student::where('classe_id', $request->classe_id)->orderBy('first_name')->get();
        }

        return view('marks.create', compact('classes', 'subjects', 'students'));
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
        // Validate input
        $request->validate([
            'mark' => 'required|array', // Ensure marks is an array
            'mark.*' => 'required|numeric|min:0|max:20', // Each mark must be a number between 0 and 20
            'subject_id' => 'required|exists:subjects,id', // Ensure subject_id exists in subjects table
            'classe_id' => 'required|exists:classes,id', // Ensure classe_id exists in classes table
            'sequence' => 'required|string|max:255', // Ensure sequence is a non-empty string
        ]);

        // Iterate through each student mark
        foreach ($request->input('mark') as $studentId => $mark) {
            // Determine appreciation based on the mark
            if ($mark == 0) {
                $appreciation = 'Absent';
            } elseif ($mark < 10) {
                $appreciation = 'C.N.A'; // Competences Not Acquired (CNA)
            } elseif ($mark >= 10 && $mark < 12) {
                $appreciation = 'C.A.A'; // Competences markly Acquired (CAA)
            } elseif ($mark >= 12 && $mark < 14) {
                $appreciation = 'C.A'; // Competences Acquired (CA)
            } elseif ($mark >= 14 && $mark < 16) {
                $appreciation = 'C.W.A'; // Competences Well Acquired (CWA)
            } elseif ($mark >= 16 && $mark <= 20) {
                $appreciation = 'C.V.W.A'; // Competences Very Well Acquired (CVWA)
            }

            // Fetch the class and subject IDs from the request
            $classeId = $request->input('classe_id');
            $subjectId = $request->input('subject_id');
            $sequence = $request->input('sequence');

            // Initialize variables for success message
            $classeName = Classe::find($classeId)->name; // Get class name
            $subjectName = Subject::find($subjectId)->name; // Get subject name

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

        // Create success message
        $successMessage = "Marks for '$classeName' have been saved successfully in '$subjectName' for Evaluation $sequence.";


        return back()->with('success', $successMessage);
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


    // public function export(Request $request)
    // {
    //     // Get parameters from the request
    //     $classeId = $request->query('classe_id');
    //     $subjectId = $request->query('subject_id');
    //     $sequence = $request->query('sequence');

    //     // Validate parameters
    //     if (!$classeId || !$subjectId || !$sequence) {
    //         return back()->with('error', 'Missing parameters for export.');
    //     }

    //     // Fetch subject and class names
    //     $subject = Subject::find($subjectId);
    //     $classe = Classe::find($classeId);

    //     // Fetch students in the selected class
    //     $students = Student::where('classe_id', $classeId)->get();
    //     if ($students->isEmpty()) {
    //         return back()->with('error', 'No students found for this class.');
    //     }

    //     // Fetch marks for the selected subject and sequence
    //     $marks = Mark::where('classe_id', $classeId)
    //         ->where('subject_id', $subjectId)
    //         ->where('sequence', $sequence)
    //         ->get()
    //         ->keyBy('student_id');

    //     // Prepare data for export
    //     $exportData = [];
    //     foreach ($students as $student) {
    //         $mark = $marks->get($student->id);
    //         $exportData[] = [
    //             'matricule' => $student->matricule,
    //             'name_of_student' => $student->first_name . ' ' . $student->last_name,
    //             'classe_id' => $classeId,
    //             'subject_id' => $subjectId,
    //             'evaluation' => $sequence,
    //             'marks' => $mark ? $mark->mark : '0',
    //         ];
    //     }

    //     // Check if exportData is populated
    //     if (empty($exportData)) {
    //         return back()->with('error', 'No marks found for the selected parameters.');
    //     }

    //     // Return the Excel file download
    //     return Excel::download(new \App\Exports\ArrayExport($exportData), 'MARKS_' . $classe->name . '_' . $subject->code_subject . '_Eval ' . $sequence . '.xlsx');
    // }

    public function export(Request $request)
    {
        // Get parameters from the request
        $classeId = $request->query('classe_id');
        $subjectId = $request->query('subject_id');
        $sequence = $request->query('sequence');

        // dd($classeId);
        // Validate parameters
        if (!$classeId || !$subjectId || !$sequence) {
            return back()->with('error', 'Missing parameters for export.');
        }

        // Fetch class and subject
        $classe = Classe::find($classeId);
        $subject = Subject::find($subjectId);

        // Check if class and subject exist
        if (!$classe || !$subject) {
            return back()->with('error', 'Invalid class or subject selected.');
        }

        // Fetch students in the selected class
        $students = Student::where('classe_id', $classeId)->orderBy('first_name')->get();
        if ($students->isEmpty()) {
            return back()->with('error', 'No students found for this class.');
        }

        // Fetch marks for the selected subject and sequence
        $marks = Mark::where('classe_id', $classeId)
            ->where('subject_id', $subjectId)
            ->where('sequence', $sequence)
            ->get()
            ->keyBy('student_id');

        // Prepare data for export with only necessary columns
        $exportData = [];
        foreach ($students as $student) {
            $mark = $marks->get($student->id);
            $exportData[] = [
                'matricule' => $student->matricule,
                'name_of_student' => $student->first_name . ' ' . $student->last_name,
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


    public function import(Request $request) {
        // Get parameters from the request
        $classeId = $request->query('classe_id');
        $subjectId = $request->query('subject_id');
        $sequence = $request->query('sequence');

        // dd($subjectId);

        return view('marks.import', compact('classeId', 'subjectId', 'sequence'));
    }


    public function store_import(Request $request)
    {
        // Validate the request for file upload and additional parameters
        $request->validate([
            'file' => 'required|file|mimes:xlsx,xls,csv',
            'classe_id' => 'required|exists:classes,id', // Ensure class ID exists
            'subject_id' => 'required|exists:subjects,id', // Ensure subject ID exists
            'sequence' => 'required|in:1,2,3,4,5,6', // Ensure sequence is valid
        ]);

        try {
            // Load the Excel file
            $file = $request->file('file');
            $data = Excel::toArray(new MarksImport, $file);

            // Fetch the class and subject IDs from the request
            $classeId = $request->classe_id;
            $subjectId = $request->subject_id;
            $sequence = $request->sequence;

            // Initialize variables for success message
            $classeName = Classe::find($classeId)->name; // Get class name
            $subjectName = Subject::find($subjectId)->name; // Get subject name

            // Fetch the full names of students in the specified class
            $students = Student::where('classe_id', $classeId)
                ->get()
                ->map(function ($student) {
                    return trim($student->first_name . ' ' . $student->last_name);
                })
                ->toArray();

            // Process the data starting from the second row
            foreach ($data[0] as $index => $row) {
                if ($index === 0) {
                    continue; // Skip the header row
                }

                // Sanitize name field (trim and remove multiple spaces)
                $name = trim(preg_replace('/\s+/', ' ', $row[1])); // Normalize spaces
                $name = preg_replace('/\x{00A0}/u', ' ', $name); // Remove non-breaking spaces

                // Validate name: allow letters, spaces, apostrophes, hyphens, periods, and commas
                if (empty($name) || !preg_match("/^[\p{L}\s'\-,\.]+$/u", $name)) {
                    return back()->with('error', 'Invalid name format on row ' . ($index + 1));
                }

                // Check if the name exists in the class
                if (!in_array($name, $students)) {
                    return back()->with('error', 'Name "' . $name . '" does not match any student in the class on row ' . ($index + 1));
                }

                // Retrieve marks from the appropriate column
                $marks = $row[2]; // Adjust this index based on your Excel structure

                // Validate marks: Ensure it's a numeric value within the valid range (0-100)
                if (!is_numeric($marks) || $marks < 0 || $marks > 100) {
                    return back()->with('error', 'Invalid mark format on row ' . ($index + 1));
                }

                // Determine appreciation based on the marks
                $appreciation = $this->determineAppreciation($marks);

                // Store the mark using the student ID directly from the file
                $studentId = Student::where('matricule', $row[0])->first()->id ?? null; // Assuming first column has matricule

                // Check if the student ID exists
                if (!$studentId) {
                    return back()->with('error', 'Student with matricule "' . $row[0] . '" not found on row ' . ($index + 1));
                }

                // Save or update the mark for the student
                Mark::updateOrCreate(
                    [
                        'student_id' => $studentId,
                        'subject_id' => $subjectId,
                        'classe_id' => $classeId,
                        'sequence' => $sequence,
                    ],
                    [
                        'mark' => $marks,
                        'appreciation' => $appreciation,
                    ]
                );
            }

            // Create success message
            $successMessage = "Marks in '$classeName' have been imported and saved successfully for '$subjectName' for Evaluation $sequence.";

            return redirect()->route('marks.create')->with('success', $successMessage);
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


    // public function downloadMarksPdf(Request $request)
    // {
    //     // Use the correct input names based on the route
    //     $classeId = $request->input('classe_id'); // Changed from 'id' to 'classe_id'
    //     $subjectId = $request->input('subject_id'); // Retrieve subject_id
    //     $sequence = $request->input('sequence');

    //     // Retrieve the class
    //     $classe = Classe::find($classeId);

    //     if (!$classe) {
    //         return response()->json(['error' => 'Class not found'], 404);
    //     }

    //     // Ensure the subject exists
    //     $subject = $classe->subjects()->find($subjectId);

    //     if (!$subject) {
    //         return response()->json(['error' => 'Subject not found'], 404);
    //     }

    //     // Retrieve marks for the specified subject, sequence, and class
    //     $marks = Mark::where('subject_id', $subject->id) // Filter by subject
    //         ->where('sequence', $sequence) // Filter by sequence
    //         ->whereHas('student', function ($query) use ($classeId) {
    //             $query->where('classe_id', $classeId); // Filter students by class
    //         })
    //         ->with(['student', 'subject']) // Include relationships
    //         ->get();

    //     // Check if marks exist
    //     if ($marks->isEmpty()) {
    //         return response()->json(['error' => 'No marks found for this class, subject, and sequence.'], 404);
    //     }

    //     // Get the subject for the PDF view
    //     // It's safe to get subject here since we know marks exist
    //     // We can re-fetch the subject if needed
    //     // $subject = $marks->first()->subject;

    //     // Define paths to logos
    //     $logoPath = public_path('assets/images/logo.jpg');

    //     // Generate PDF
    //     $pdf = Pdf::loadView('pdf.marks', compact('marks', 'classe', 'sequence', 'subject', 'logoPath'))
    //               ->setPaper('A4', 'portrait');

    //     return $pdf->stream('marks.pdf');
    // }

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

        // Calculate number of passed, failed, and absent students
        $numberPassed = $marks->where('mark', '>=', 10)->count(); // Assuming passing mark is 50
        $numberFailed = $marks->where('mark', '>', 0)->where('mark', '<', 10)->count(); // Failed: marks > 0 and < 10
        $numberAbsent = $marks->where('mark', 0)->count(); // Count students with marks == 0

        // Define paths to logos
        $logoPath = public_path('assets/images/logo.jpg');

        // Generate PDF
        $pdf = Pdf::loadView('pdf.marks', compact('marks', 'classe', 'sequence', 'subject', 'logoPath', 'numberPassed', 'numberFailed', 'numberAbsent'))
                  ->setPaper('A4', 'portrait');

        return $pdf->stream('marks.pdf');
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



    // Master Sheet
    public function downloadMasterSheet(Request $request)
    {
        $classId = $request->input('class_id');
        $sequence = $request->input('sequence');
        $logoPath = public_path('assets/images/logo.jpg');

        // Fetch class and its subjects
        $class = Classe::with('subjects')->find($classId);

        // Fetch students in the selected class with their marks
        $students = Student::where('classe_id', $classId)->orderBy('first_name')->get();

        // Initialize counters
        $numberPassed = 0;
        $numberAbsent = 0;
        $numberFailed = 0;

        // Prepare marks for each student
        foreach ($students as $student) {
            // Fetch marks for the selected sequence
            $marks = $student->marks()->where('sequence', $sequence)->get();

            // Create an associative array for marks, with subject IDs as keys
            $marksArray = [];
            foreach ($marks as $mark) {
                $marksArray[$mark->subject_id] = $mark->mark;
            }

            // Add marks for all subjects, defaulting to 0 where no mark exists
            foreach ($class->subjects as $subject) {
                if (!isset($marksArray[$subject->id])) {
                    $marksArray[$subject->id] = 0; // Default to 0 if no mark exists
                }
            }

            // Calculate total and average
            $total = $this->calculateTotal($marksArray, $class->subjects);
            $avg = $this->calculateAvg($total, $marksArray, $class->subjects); // Pass marksArray here

            // Store the marks array and calculated values back into the student object
            $student->marksArray = $marksArray; // Add the marks array to the student object
            $student->total = $total;            // Add total to the student object
            $student->average = $avg;            // Add average to the student object

            // Update counters based on the average
            if ($avg >= 10) {
                $numberPassed++;
            } elseif ($avg == 0) {
                $numberAbsent++;
            } elseif ($avg > 0 && $avg < 10) {
                $numberFailed++;
            }
        }

        // Calculate rank based on the average
        $this->calculateRank($students);

        // Calculate the class average
        $classAverage = $this->calculateClassAverage($students);

        // Generate the PDF
        $pdf = PDF::loadView('pdf.master-sheet', [
            'students' => $students,
            'class' => $class,
            'sequence' => $sequence,
            'logoPath' => $logoPath,
            'numberPassed' => $numberPassed,
            'numberAbsent' => $numberAbsent,
            'numberFailed' => $numberFailed,
            'classAverage' => $classAverage, // Pass the class average to the view
        ])->setPaper('A4', 'landscape');

        // Stream the PDF
        return $pdf->stream('MASTER SHEET ' . $class->name . '_EVALUATION_' . $sequence . '.pdf');
    }


    private function calculateRank($students)
    {
        // Sort students by their average in descending order
        $students = $students->sortByDesc('average');

        // Assign ranks based on sorted averages
        $rank = 1;
        foreach ($students as $index => $student) {
            // If the current student's average is the same as the previous student's, they share the same rank
            if ($index > 0 && $student->average == $students[$index - 1]->average) {
                $student->rank = $students[$index - 1]->rank; // Same rank as the previous student
            } else {
                // Determine suffix for the rank
                $suffix = $this->getRankSuffix($rank);
                $student->rank = $rank.' ' .$suffix; // Assign the rank with suffix
            }

            // Increment rank for the next student
            $rank++;
        }
    }

    // Helper function to get the suffix for the rank
    private function getRankSuffix($rank)
    {
        // Get last two digits to handle exceptions like 11th, 12th, 13th
        $lastDigit = $rank % 10;
        $lastTwoDigits = $rank % 100;

        if ($lastTwoDigits >= 11 && $lastTwoDigits <= 13) {
            return 'th'; // Special cases for 11th, 12th, 13th
        }

        // Determine suffix based on last digit
        switch ($lastDigit) {
            case 1:
                return 'st';
            case 2:
                return 'nd';
            case 3:
                return 'rd';
            default:
                return 'th';
        }
    }


    private function calculateTotal($marksArray, $subjects)
    {
        $total = 0;

        foreach ($subjects as $subject) {
            // Check if the mark exists for the subject
            if (isset($marksArray[$subject->id])) {
                // Multiply mark by coefficient and add to total
                $total += $marksArray[$subject->id] * $subject->coef;
            }
        }

        return $total;
    }

    private function calculateAvg($total, $marksArray, $subjects)
    {
        $sumCoefficients = 0;
        $count = 0;

        foreach ($subjects as $subject) {
            // Check if the subject's mark exists and is greater than 0
            if (isset($marksArray[$subject->id]) && $marksArray[$subject->id] > 0) {
                $sumCoefficients += $subject->coef;
                $count++;
            }
        }

        // Return the average or 0 if no valid marks
        return $count > 0 ? $total / $sumCoefficients : 0;
    }

    private function calculateClassAverage($students)
    {
        // Initialize total to sum the student averages
        $totalAverage = 0;

        // Count the number of students
        $totalStudents = count($students);

        // Sum all the student averages
        foreach ($students as $student) {
            $totalAverage += $student->average;  // Assuming `average` property exists on the student model
        }

        // Calculate the class average
        $classAverage = $totalStudents > 0 ? $totalAverage / $totalStudents : 0;

        return $classAverage;
    }







}
