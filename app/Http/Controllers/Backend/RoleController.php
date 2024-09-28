<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\DB;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $roles = Role::all();
        return view('backend.role.index', compact('roles'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('backend.role.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $role = Role::create([
            'name' => $request->name,
        ]);
        $notification = array(
            'message' => 'Role Created Successfully',
            'alert-type' => 'success'
        );
        return redirect()->route('all.role')->with($notification);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $role = Role::find($id);
        return view('backend.role.edit', compact('role'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $role = Role::find($id);
        $role->name = $request->name;
        $role->save();
        $notification = array(
            'message' => 'Role Updated Successfully',
            'alert-type' => 'success'
        );
        return redirect()->route('all.role')->with($notification);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $role = Role::find($id);
        $role->delete();
        $notification = array(
            'message' => 'Role Deleted Successfully',
            'alert-type' => 'success'
        );
        return redirect()->back()->with($notification);
    }

    //FUCTIONS FOR ROLES IN PERMISSIONS

    public function all_role_permission()
    {
        $roles = Role::all();
        return view('backend.role-permission.all-role-permission', compact('roles'));
    }

    public function add_role_permission()
    {
        $roles = Role::all();
        $permissions = Permission::all();

        return view('backend.role-permission.add-role-permission', compact('roles', 'permissions'));
    }

    public function store_role_permission(Request $request)
    {
        // dd($request->all());
        $data = array();
        $permissions = $request->permission;

        foreach ($permissions as $key => $item) {
            $data[] = [
                'role_id' => $request->role_id,
                'permission_id' => $item,
            ];
        }

        DB::table('role_has_permissions')->insert($data);

        $notification = array(
            'message' => 'Permission Assigned to Role Successfully',
            'alert-type' => 'success'
        );
        return redirect()->route('all.role.permission')->with($notification);
    }

    // public function edit_role_permission($id)
    // {
    //     $role = Role::find($id);
    //     $permissions = Permission::all();

    //     return view('backend.role-permission.edit-role-permission', compact('role', 'permissions'));
    // }

    public function edit_role_permission($id)
    {
        $role = Role::find($id);
        $roles = Role::all();
        $permissions = Permission::all();
        $selectedPermissions = $role->permissions()->pluck('id')->toArray(); // Fetching selected role's permissions

        return view('backend.role-permission.edit-role-permission', compact('role', 'roles', 'permissions', 'selectedPermissions'));
    }

    public function update_role_permission(Request $request, $roleId)
    {
        // Remove existing permissions for the role
        DB::table('role_has_permissions')->where('role_id', $roleId)->delete();

        // Then insert the new permissions
        $permissions = $request->permission;
        $data = [];

        foreach ($permissions as $key => $item) {
            $data[] = [
                'role_id' => $request->role_id,
                'permission_id' => $item,
            ];
        }

        DB::table('role_has_permissions')->insert($data);

        $notification = array(
            'message' => 'Permission Assigned to Role Successfully',
            'alert-type' => 'success'
        );
        return redirect()->route('all.role.permission')->with($notification);
    }

    public function delete_role_permission($roleId)
    {
        // Check if permissions associated with the given role exist
        $role = DB::table('role_has_permissions')->where('role_id', $roleId);

        if (!$role->exists()) {
            $notification = array(
                'message' => 'Assigned Role Permission Not Found',
                'alert-type' => 'error'
            );
            return redirect()->back()->with($notification);
        }

        // Delete permissions associated with the given role
        $role->delete();

        $notification = array(
            'message' => 'Assigned Role Permission Removed Successfully',
            'alert-type' => 'success'
        );
        return redirect()->back()->with($notification);
    }

}
