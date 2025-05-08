<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Unit;
use App\Services\UnitServices;
use Illuminate\Http\Request;
use function Symfony\Component\String\u;

class UnitController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function __construct(UnitServices $UnitServices)
    {
        $this->UnitServices = $UnitServices;
    }


    public function index()
    {
        return view('admin.units.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $units = $this->UnitServices->create();
        return view('admin.units.create', compact('units'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $request->validate([
                'name' => 'required|string|max:255',
                'conversion_factor' => 'nullable|numeric|min:0'
            ]);
            $this->UnitServices->store($request);
            return redirect()->route('admin.units.index');
        } catch (\Exception $e) {
            dd($e->getMessage());
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $unit = Unit::with('parent')->findOrFail($id);
        return view('admin.units.view',compact('unit'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {

        try {
            $units = $this->UnitServices->create();
            $unit = $this->UnitServices->edit($id);
            return view('admin.units.edit', compact('unit', 'units'));
        } catch (\Exception $e) {
            dd($e->getMessage());
            return redirect()->back()->with('error', $e->getMessage());
        }
        return view('admin.units.edit');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try {
            $request->validate([
                'name' => 'required|string|max:255',
                'conversion_factor' => 'nullable|numeric|min:0',
                'parent_id' => 'nullable|exists:units,id'
            ]);

            $this->UnitServices->update($request, $id);
            return redirect()->route('admin.units.index');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $this->UnitServices->destroy($id);
            return redirect()->route('admin.units.index');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function getdata(Request $request)
    {
        return $this->UnitServices->getdata($request);

    }
}
