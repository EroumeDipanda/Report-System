<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Property;

class PropertyController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $properties = Property::latest()->get();
        return view('backend.property.index', compact('properties'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('backend.property.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'type_name' => ['required', 'unique:properties', 'max:200'],
            'type_icon' => ['nullable']
        ]);

        $property = new Property();
        $property->type_name = $request->type_name;
        $property->type_icon = $request->type_icon;
        $property->save();

        $notification = array(
            'message' => 'New Property Created Successfully',
            'alert-type' => 'success'
        );
        return redirect()->route('all.property')->with($notification);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $property = Property::find($id);
        return view('backend.property.edit', compact('property'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'type_name' => ['required', 'max:200'],
            'type_icon' => ['nullable']
        ]);

        $property = Property::find($id);
        // dd($property);
        $property->type_name = $request->type_name;
        $property->type_icon = $request->type_icon;
        $property->save();

        $notification = array(
            'message' => 'Property has been updated Successfully',
            'alert-type' => 'success'
        );
        return redirect()->route('all.property')->with($notification);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $property = Property::find($id);
        if (!$property) {
            $notification = array(
                'message' => 'Property not found',
                'alert-type' => 'error'
            );
            return redirect()->back()->with($notification);
        }
        $property->delete();
        $notification = array(
            'message' => 'Property deleted successfully',
            'alert-type' => 'success'
        );
        return redirect()->back()->with($notification);
    }
}
