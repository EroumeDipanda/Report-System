<?php

namespace App\Http\Controllers;

use App\Models\Classe;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        // Get the currently authenticated user
        $user = Auth::user();

        // Check if the user has been marked as deleted
        if ($user->is_delete) {
            Auth::logout();  // Log out the user if they are marked as deleted
            return redirect()->route('login')->with('error', 'Your account has been deactivated.');
        }

        // Fetch file and school counts
        $classCount = Classe::count();
        $studentCount = Student::count();

        // Determine the dashboard view and data based on user role
        switch ($user->role) {
            case 'user':
                // Return the teacher's dashboard view with their file counts
                return view('teachers.dashboard');

            case 'admin':
                // Return the admin's dashboard view with file counts and school count
                return view('admin.dashboard', compact('classCount','studentCount'));

            case 'super_admin':
                // Return the super admin's dashboard view with overall file and school counts
                return view('admin.dashboard', compact('classCount','studentCount'));

            default:
                // Handle other roles or redirect if the role is not recognized
                return redirect()->route('home')->with('error', 'Unauthorized access.');
        }
    }
}
