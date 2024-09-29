<?php

namespace App\Http\Controllers\Admin;

use Dompdf\Dompdf;
use App\Models\Classe;
use App\Models\Student;
use App\Models\Subject;
use App\Models\ReportCard;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Http\Controllers\Controller;

class ReportController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $reports = ReportCard::latest()->get();
        $classes = Classe::all();

        return view('report-cards.create', compact('reports', 'classes'));
    }


    public function store(Request $request)
    {
        // Step 1: Validate the request
        $this->validateRequest($request);

        // Step 2: Retrieve class and student data
        $classe = Classe::findOrFail($request->input('classe_id'));
        $subjects = $classe->subjects()->get();
        $students = Student::where('classe_id', $classe->id)->get();

        // Step 3: Determine term sequences
        $sequences = $this->getSequencesForTerm($request->input('term'));

        // Step 4: Calculate student data
        $studentsData = $this->calculateStudentsData($students, $subjects, $sequences);

        // Step 5: Calculate class average
        $classAvg = $this->calculateClassAverage($studentsData['studentsData']);

        // Step 6: Calculate term grade
        $totalTermAverage = $studentsData['totalCoef'] > 0 ? $studentsData['totalMarks'] / $studentsData['totalCoef'] : 0;
        $termGrade = $this->determineTermGrade($totalTermAverage);

        // Step 7: Calculate percentage passed
        $passedStudentsCount = $studentsData['passedStudentsCount'];
        $totalStudents = $studentsData['totalStudents'];
        $percentagePassed = $totalStudents > 0 ? ($passedStudentsCount / $totalStudents) * 100 : 0;

        // Step 8: Get minimum and maximum term averages
        $minMaxTermAverages = $this->getMinMaxTermAverages($studentsData['studentsData']);

        // Step 9: Generate and save the PDF report
        $pdfPath = $this->generatePdfReport(
            $classe,
            $subjects,
            $studentsData,
            $sequences,
            $studentsData['totalCoef'],
            $request->input('term'),
            $classAvg,
            $termGrade,
            $passedStudentsCount,
            $percentagePassed,
            $minMaxTermAverages['min'],  // Minimum term average
            $minMaxTermAverages['max']   // Maximum term average
        );

        // Step 10: Save the report card path to the database
        $this->saveReportCardPath($classe->id, $request->input('term'), $pdfPath);

        // Step 11: Return success response
        return redirect()->back()->with('success', 'Report cards generated and saved successfully.');
    }

    private function validateRequest(Request $request)
    {
        $request->validate([
            'classe_id' => 'required|exists:classes,id',
            'term' => 'required|integer|min:1|max:3',
        ]);
    }

    private function getSequencesForTerm(int $term)
    {
        $sequences = [
            1 => [1, 2],
            2 => [3, 4],
            3 => [5, 6],
        ];

        return $sequences[$term] ?? abort(redirect()->back()->with('error', 'Invalid term value.'));
    }

    private function calculateStudentsData($students, $subjects, $sequences)
    {
        $studentsData = [];
        $totalMarks = 0;
        $totalCoef = 0;
        $totalWeightedMarks = 0;
        $passedStudentsCount = 0;
        $totalStudents = count($students);

        foreach ($students as $student) {
            $studentData = $this->calculateStudentData($student, $subjects, $sequences);

            $studentTotalCoef = 0;
            $studentTotalWeightedMarks = 0;
            foreach ($subjects as $subject) {
                $average = $this->calculateSubjectAverage($student, $subject, $sequences);
                if ($average > 0) {
                    $studentTotalCoef += $subject->coef ?? 0;
                    $studentTotalWeightedMarks += $average * ($subject->coef ?? 0);
                }
            }

            if ($studentData['termAverage'] >= 10) {
                $passedStudentsCount++;
            }

            $studentsData[$student->id] = array_merge($studentData, [
                'totalWeightedMarks' => $studentTotalWeightedMarks,
                'totalCoef' => $studentTotalCoef
            ]);

            $totalMarks += $studentData['totalMarks'];
            $totalCoef += $studentTotalCoef;
            $totalWeightedMarks += $studentTotalWeightedMarks;
        }

        return [
            'studentsData' => $studentsData,
            'totalMarks' => $totalMarks,
            'totalCoef' => $totalCoef,
            'totalWeightedMarks' => $totalWeightedMarks,
            'totalStudents' => $totalStudents,
            'passedStudentsCount' => $passedStudentsCount
        ];
    }

    private function calculateStudentData(Student $student, $subjects, $sequences)
    {
        $marksData = [];
        $studentTotalMarks = 0;
        $studentTotalCoef = 0;

        foreach ($subjects as $subject) {
            $average = $this->calculateSubjectAverage($student, $subject, $sequences);
            $coefficient = $subject->coef ?? 0; // Default to 0 if null

            if ($average > 0) {
                $weightedMark = $average * $coefficient;

                $marksData[$subject->id] = [
                    'eval1' => $this->getEvalMarks($student, $subject, $sequences, 0),
                    'eval2' => $this->getEvalMarks($student, $subject, $sequences, 1),
                    'average' => $average,
                    'weightedMark' => $weightedMark,
                    'grade' => $this->determineSubjectGrade($average),
                    'appreciation' => $this->getAppreciation($average),
                ];

                $studentTotalMarks += $weightedMark;
                $studentTotalCoef += $coefficient;
            } else {
                // Still store subject data with default values
                $marksData[$subject->id] = [
                    'eval1' => 0,
                    'eval2' => 0,
                    'average' => 0,
                    'weightedMark' => 0,
                    'grade' => 'U', // Fail or default grade
                    'appreciation' => 'Absent', // Default appreciation
                ];
            }
        }

        // Calculate term average for the student
        $studentTermAverage = $studentTotalCoef > 0 ? $studentTotalMarks / $studentTotalCoef : 0;

        // Determine term grade based on the term average
        $studentTermGrade = $this->determineTermGrade($studentTermAverage);

        return [
            'info' => $student,
            'marksData' => $marksData,
            'totalMarks' => $studentTotalMarks,
            'totalCoef' => $studentTotalCoef,
            'termAverage' => $studentTermAverage,
            'termGrade' => $studentTermGrade,
        ];
    }


    private function determineTermGrade(float $termAverage): string
    {
        if ($termAverage >= 18 && $termAverage <= 20) {
            return 'A+'; // Excellent
        } elseif ($termAverage >= 16 && $termAverage < 18) {
            return 'A'; // Very Good
        } elseif ($termAverage >= 15 && $termAverage < 16) {
            return 'B+'; // Good
        } elseif ($termAverage >= 14 && $termAverage < 15) {
            return 'B'; // Satisfactory
        } elseif ($termAverage >= 12 && $termAverage < 14) {
            return 'C+'; // Average
        } elseif ($termAverage >= 10 && $termAverage < 12) {
            return 'C'; // Below Average
        } elseif ($termAverage <= 10) {
            return 'D'; // Poor
        }
    }


    private function getMinMaxTermAverages(array $studentsData): array
    {
        $termAverages = array_column($studentsData, 'termAverage');

        $minTermAverage = !empty($termAverages) ? min($termAverages) : 0;
        $maxTermAverage = !empty($termAverages) ? max($termAverages) : 0;

        return [
            'min' => $minTermAverage,
            'max' => $maxTermAverage,
        ];
    }

    private function calculateSubjectAverage(Student $student, $subject, $sequences)
    {
        $eval1 = $this->getEvalMarks($student, $subject, $sequences, 0);
        $eval2 = $this->getEvalMarks($student, $subject, $sequences, 1);

        // Only calculate the average if at least one of the evaluations is greater than 0
        if ($eval1 > 0 || $eval2 > 0) {
            return ($eval1 + $eval2) / 2;
        }

        return 0;
    }

    private function determineSubjectGrade(float $average): string
    {
        if ($average >= 18 && $average <= 20) {
            return 'A+'; // Excellent
        } elseif ($average >= 16 && $average < 18) {
            return 'A'; // Very Good
        } elseif ($average >= 15 && $average < 16) {
            return 'B+'; // Good
        } elseif ($average >= 14 && $average < 15) {
            return 'B'; // Satisfactory
        } elseif ($average >= 12 && $average < 14) {
            return 'C+'; // Average
        } elseif ($average >= 10 && $average < 12) {
            return 'C'; // Below Average
        } elseif ($average <= 10) {
            return 'D'; // Poor
        }
    }


    private function getEvalMarks(Student $student, $subject, $sequences, $index)
    {
        $sequence = $sequences[$index] ?? null;
        if ($sequence) {
            // Fetch the mark and ensure it is greater than zero
            $mark = $student->marks()
                ->where('subject_id', $subject->id)
                ->where('sequence', $sequence)
                ->pluck('mark')
                ->filter(function ($value) {
                    return $value > 0; // Only return marks greater than zero
                })
                ->first(); // Get the first positive mark if available
            return $mark ?? 0; // Return 0 if no valid mark is found
        }
        return 0; // Return 0 if the sequence is not found
    }



    private function getAppreciation(float $average)
    {
        if ($average == 0) {
            return 'Absent';
        } elseif ($average < 10) {
            return 'C.N.A'; // Competences Not Acquired (CNA)
        } elseif ($average >= 10 && $average < 12) {
            return 'C.A.A'; // Competences Averagely Acquired (CAA)
        } elseif ($average >= 12 && $average < 14) {
            return 'C.A'; // Competences Acquired (CA)
        } elseif ($average >= 14 && $average < 16) {
            return 'C.W.A'; // Competences Well Acquired (CWA)
        } elseif ($average >= 16 && $average <= 20) {
            return 'C.V.W.A'; // Competences Very Well Acquired (CVWA)
        } else {
            return 'Expert'; // for any average greater than 20, if applicable
        }
    }


    private function calculateClassAverage(array $studentsData)
    {
        $totalTermAverages = 0;
        $totalStudents = count($studentsData); // Total number of students in the class

        foreach ($studentsData as $studentData) {
            // Check if 'termAverage' exists and is numeric
            if (isset($studentData['termAverage']) && is_numeric($studentData['termAverage'])) {
                $totalTermAverages += (float)$studentData['termAverage']; // Convert to float for safety
            }
        }

        // Return the average if there are students; otherwise, return 0
        return $totalStudents > 0 ? $totalTermAverages / $totalStudents : 0;
    }

    private function generatePdfReport(
        $classe,
        $subjects,
        $studentsData,
        $sequences,
        $totalCoef,
        $term,
        $classAvg,
        $termGrade,
        $passedStudentsCount,
        $percentagePassed,
        $minTermAverage,
        $maxTermAverage
    )
    {
        $pdf = Pdf::loadView('pdf.report-cards', [
            'leftLogoPath' => public_path('assets/images/logo.jpg'),
            'profile' => public_path('assets/images/images.jpeg'),
            'classe' => $classe,
            'subjects' => $subjects,
            'studentsData' => $studentsData['studentsData'],
            'sequences' => $sequences,
            'term' => $term,
            'classAvg' => $classAvg,
            'totalMarks' => $studentsData['totalMarks'],
            'totalCoef' => $totalCoef,
            'termGrade' => $termGrade,
            'numberPassed' => $passedStudentsCount,
            'percentagePassed' => $percentagePassed,
            'minTermAverage' => $minTermAverage, // Minimum term average
            'maxTermAverage' => $maxTermAverage  // Maximum term average
        ])->setPaper('A4', 'portrait');

        $pdfPath = 'report_cards/';
        $pdfFilename = 'REPORT_CARDS_' . $classe->name . '_TERM_' . $term . '.pdf';
        $pdfFullPath = storage_path('app/public/' . $pdfPath . $pdfFilename);

        if (!file_exists(dirname($pdfFullPath))) {
            mkdir(dirname($pdfFullPath), 0777, true);
        }

        try {
            $pdf->save($pdfFullPath);
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to generate report cards: ' . $e->getMessage());
        }

        return $pdfPath . $pdfFilename;
    }

    private function saveReportCardPath(int $classeId, int $term, string $pdfPath)
    {
        ReportCard::updateOrCreate(
            [
                'classe_id' => $classeId,
                'term' => $term,
            ],
            [
                'pdf_path' => $pdfPath,
            ]
        );
    }





    public function download($id)
    {
        // Find the report card by ID
        $reportCard = ReportCard::findOrFail($id);
        $filePath = storage_path('app/public/' . $reportCard->pdf_path);

        if (file_exists($filePath)) {
            // Stream the file to the user
            return response()->stream(function () use ($filePath) {
                // Open the file and stream it
                $stream = fopen($filePath, 'r');
                fpassthru($stream);
                fclose($stream);
            }, 200, [
                'Content-Type' => 'application/pdf',
                'Content-Disposition' => 'inline; filename="' . basename($filePath) . '"',
            ]);
        }

    }




}
