<?php

namespace App\Exports;

use App\Models\Student;
use App\Models\Mark;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithHeadings;

class MarksExport implements FromView, WithHeadings
{
    protected $classeId;
    protected $subjectId;
    protected $sequence;

    public function __construct($classeId, $subjectId, $sequence)
    {
        $this->classeId = $classeId;
        $this->subjectId = $subjectId;
        $this->sequence = $sequence;
    }

    public function view(): View
    {
        // Get students in the selected class
        $students = Student::where('classe_id', $this->classeId)->get();

        // Fetch marks for the selected class, subject, and sequence
        $marks = Mark::where('classe_id', $this->classeId)
            ->where('subject_id', $this->subjectId)
            ->where('sequence', $this->sequence)
            ->get()
            ->keyBy('student_id'); // Key marks by student_id for easier access

        return view('exports.marks', [
            'students' => $students,
            'marks' => $marks,
        ]);
    }

    public function headings(): array
    {
        return [
            'Matricule',
            'Student Name',
            'Evaluation Number',
            'Mark',
        ];
    }
}
