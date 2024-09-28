<?php

namespace App\Http\Controllers\Admin;

use App\Models\Classe;
use App\Models\Subject;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

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
