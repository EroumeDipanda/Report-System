<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use Spatie\Permission\Models\Role;

class AdminController extends Controller
{
    //Function for admin dashboard
    public function admin_dashboard()
    {
        return view('admin.dashboard');
    }

    //function for admin logout
    public function admin_logout(Request $request)
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/login');
    }

    //Function for Admin profile
    public function admin_profile()
    {
        $id = Auth::user()->id;
        $user = User::find($id);
        // dd($user);

        return view('admin.profile-index', compact('user'));
    }

    //Function to store admin profile
    public function profile_store(Request $request)
    {
        // dd($request->all());

        $id = Auth::user()->id;

        $user = User::find($id);
        $user->name = $request->name;
        $user->username = $request->username;
        $user->email = $request->email;
        $user->phone = $request->phone;
        $user->address = $request->address;

        if ($request->file('photo')) {
            $file = $request->file('photo');
            @unlink(public_path('upload/profiles/'.$user->photo));
            $fileName = date('YmdHi').$file->getClientOriginalName();
            $file->move(public_path('upload/profiles'), $fileName);
            $user->photo = $fileName;
        }
        $user->save();

        $notification = array(
            'message' => 'Profile updated successfully',
            'alert-type' => 'success'
        );

        return redirect()->back()->with($notification);
    }

    //Function to change admin password
    public function change_password()
    {
        $id = Auth::user()->id;
        $user = User::find($id);
        return view('admin.change-password', compact('user'));
    }


    public function update_password(Request $request)
    {
        $request->validate([
            'old_password' => 'required',
            'new_password' => ['required', 'confirmed'],
        ]);

        $user = Auth::user();

        // Check if the old password matches the user's current password
        if (!Hash::check($request->old_password, $user->password)) {
            $notification = array(
                'message' => 'Old Password Does Not Match',
                'alert-type' => 'error'
            );
            return redirect()->back()->with($notification);
        }

        // Update the user's password
        $user->password = Hash::make($request->new_password);
        $user->save();

        $notification = array(
            'message' => 'Password Changed Successfully',
            'alert-type' => 'success'
        );
        return redirect()->back()->with($notification);
    }

    //FUNCTIONS TO MANAGE ALL ADMINS

    public function all_admin()
    {
        $admins = User::where('role','admin')->get();
        return view('backend.manage-admin.index', compact('admins'));
    }

    public function create_admin()
    {
        $roles = Role::all();
        return view('backend.manage-admin.create', compact('roles'));
    }

    public function store_admin(Request $request)
    {

        // dd($request->all());

        // Create the admin with mass assignment
        $admin = User::create([
            'name' => $request->input('name'),
            'username' => $request->input('username'),
            'address' => $request->input('address'),
            'phone' => $request->input('phone'),
            'email' => $request->input('email'),
            'password' => Hash::make($request->input('password')),
            'role' => 'admin',
            'status' => 1,
        ]);

        // Assign role to the admin
        if ($request->input('role_id')) {
            $role_id = Role::find($request->input('role_id'));
            if (!$role_id) {
                $notification = [
                    'message' => 'Role Not Found',
                    'alert-type' => 'error'
                ];
                return redirect()->back()->with($notification);
            }
            $admin->assignRole($role_id);
        }


        // Redirect with success message
        $notification = [
            'message' => 'Admin created successfully!',
            'alert-type' => 'success'
        ];

        return redirect()->route('all.admin')->with($notification);
    }

    public function edit_admin($id)
    {
        $admin = User::findOrFail($id); // Find the admin user by ID
        $roles = Role::all(); // Fetch all roles
        $assignedRole = $admin->roles; // Get the roles assigned to the admin

        return view('backend.manage-admin.edit', compact('admin', 'roles', 'assignedRole'));
    }

    public function update_admin(Request $request, $id)
    {

        // Find the admin user by ID
        $admin = User::findOrFail($id);

        // Update the admin's attributes
        $admin->name = $request->input('name');
        $admin->username = $request->input('username');
        $admin->address = $request->input('address');
        $admin->phone = $request->input('phone');
        $admin->email = $request->input('email');

        // Update password if provided
        if ($request->has('password')) {
            $admin->password = Hash::make($request->input('password'));
        }

        // Save the changes
        $admin->save();

        // Assign role to the admin if provided
        if ($request->input('role_id')) {
            $role = Role::find($request->input('role_id'));
            if (!$role) {
                $notification = [
                    'message' => 'Role Not Found',
                    'alert-type' => 'error'
                ];
                return redirect()->back()->with($notification);
            }
            $admin->syncRoles([$role->id]); // Assign the role to the admin
        }

        // Redirect with success message
        $notification = [
            'message' => 'Admin updated successfully!',
            'alert-type' => 'success'
        ];

        return redirect()->route('all.admin')->with($notification);
    }

    public function destroy_admin($id)
    {
        $admin = User::findOrFail($id);
        if ($admin) {
            $admin->delete();

            // Redirect with success message
            $notification = [
                'message' => 'Admin Deleted successfully!',
                'alert-type' => 'success'
            ];
            return redirect()->back()->with($notification);
        }
    }

}
