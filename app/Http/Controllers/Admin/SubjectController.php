<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Classe;
use App\Models\Subject;

class SubjectController extends Controller
{
    public function index()
    {
        $subjects = Subject::orderBy('classe_id')->paginate(13);
        return view('subjects.index', compact('subjects'));
    }

    public function create($id)
    {
        // $classes = Classe::all();
        $class = Classe::with('subjects')->findOrFail($id);
        return view('subjects.create', compact('class'));
    }

    public function store(Request $request, $id)
    {
        $class = Classe::with('subjects')->findOrFail($id);

        // Validate the incoming request data
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'code_subject' => 'required|string|max:255',
            'classe_id' => 'required|exists:classes,id', // Ensure the class exists
            'coef' => 'required|numeric|min:0', // Ensure coefficient is a positive number
            'teacher' => 'nullable',
        ]);

        // Create the new subject
        Subject::create([
            'name' => $validatedData['name'],
            'code_subject' => $validatedData['code_subject'],
            'classe_id' => $validatedData['classe_id'], // Assign the subject to the selected class
            'coef' => $validatedData['coef'], // Assign the coefficient
            'teacher' => $validatedData['teacher'],
        ]);

        // Redirect to subjects index with a success message
        return redirect()->route('class.subjects', $class->id)->with('success', 'Subject created and assigned successfully.');
    }

    public function edit($id)
    {
        // Find the subject by ID
        $subject = Subject::findOrFail($id);
        // $class = Classe::with('subjects')->findOrFail($id);
        // $classes = Classe::all(); // Fetch all classes for the dropdown
        $class = $subject->classe;

        // Pass the subject and classes to the view
        return view('subjects.edit', compact('subject', 'class'));
    }

    public function update(Request $request, $id)
    {

        // Validate the incoming request data
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'code_subject' => 'required|string|max:255',
            'classe_id' => 'required|exists:classes,id',
            'coef' => 'required|numeric|min:0',
            'teacher' => 'nullable',
        ]);

        // Find the subject and update its details
        $subject = Subject::findOrFail($id);
        $subject->update([
            'name' => $validatedData['name'],
            'code_subject' => $validatedData['code_subject'],
            'classe_id' => $validatedData['classe_id'],
            'coef' => $validatedData['coef'],
            'teacher' => $validatedData['teacher'],
        ]);

        // Redirect to subjects index with a success message
        return redirect()->back()->with('success', 'Subject updated successfully.');
    }

    public function destroy(string $id)
    {
        $subject = Subject::findOrFail($id);
        if ($subject) {
           $subject->delete();
        }

        // Redirect to subjects index with a success message
        return redirect()->back()->with('success', 'Subject deleted successfully.');
    }



}
