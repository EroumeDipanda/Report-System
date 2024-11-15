<?php

namespace App\Http\Controllers\Admin;

use App\Models\Classe;
use App\Models\Student;
use App\Models\Subject;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;

class ClasseController extends Controller
{
    public function index()
    {
        $classes = Classe::all();
        return view('classes.index', compact('classes'));
    }

    public function create(Request $request)
    {
        return view('classes.create');
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'code_classe' => 'required|string|max:255',
            'classe_master' => 'nullable|string|max:255',
        ]);

        // Create the new class with the provided code
        Classe::create([
            'name' => $validatedData['name'],
            'code_classe' => $validatedData['code_classe'],
            'classe_master' => $validatedData['classe_master'],
        ]);

        return redirect()->route('classes.index')->with('success', 'Class created successfully.');
    }

    public function viewStudents($id)
    {
        // Find the class with the given ID and eager load students
        $class = Classe::with('students')->findOrFail($id);

        // Optionally paginate the students
        $students = $class->students()->orderBy('first_name')->paginate(10); // Adjust the number of items per page as necessary

        // Pass the class and its students to the view
        return view('classes.students', compact('class', 'students'));
    }

    public function exportStudents($classId)
    {
        // dd($classId);

        // Fetch class
        $classe = Classe::find($classId);
        // dd($classe);

        // Check if class and subject exist
        if (!$classe) {
            return back()->with('error', 'Invalid class or subject selected.');
        }
        // Fetch students in the selected class
        $students = Student::where('classe_id', $classId)->orderBy('first_name')->get();
        // dd($students);
        if ($students->isEmpty()) {
            return back()->with('error', 'No students found for this class.');
        }

        // Prepare data for export with only necessary columns
        $exportData = [];
        foreach ($students as $key => $student) {
            $exportData[] = [
                's_n' => $key + 1,
                'name_of_student' => $student->first_name . ' ' . $student->last_name,
                'sexe' => $student->sex == 'male' ? 'M' : 'F',
                'date_de_naissance' => \Carbon\Carbon::parse($student->date_of_birth)->format('d/m/Y') ,
                'lieu_de_naissance' => $student->place_of_birth,
                'classe' => $student->classe->name,
                'contact_du_parent' => $student->parents_contact ?? '',
            ];
        }

        // Check if exportData is populated
        if (empty($exportData)) {
            return back()->with('error', 'No marks found for the selected parameters.');
        }

        // Return the Excel file download
        return Excel::download(new \App\Exports\StudentExport($exportData), 'LISTE DE ' . $classe->name . '.xlsx');
    }

    public function viewSubjects($id)
    {
        // Find the class with the given ID and eager load students
        $class = Classe::with('subjects')->findOrFail($id);

        // Optionally paginate the students
        $subjects = $class->subjects()->orderBy('name')->get(); // Adjust the number of items per page as necessary

        // Pass the class and its students to the view
        return view('classes.subjects', compact('class', 'subjects'));
    }


    public function edit($id)
    {
        // Find the class by ID
        $class = Classe::findOrFail($id);

        // Pass the class data to the view
        return view('classes.edit', compact('class'));
    }

    public function update(Request $request, $id)
    {
        // Validate the input
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'code_classe' => 'required|string|max:255',
            'classe_master' => 'string|max:255',
        ]);

        // Find the class and update its details
        $class = Classe::findOrFail($id);
        $class->update([
            'name' => $validatedData['name'],
            'code_classe' => $validatedData['code_classe'],
            'classe_master' => $validatedData['classe_master'],
        ]);

        return redirect()->route('classes.index')->with('success', 'Class updated successfully.');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
