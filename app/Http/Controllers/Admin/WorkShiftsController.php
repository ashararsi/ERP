<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\WorkShiftServices;
use Illuminate\Http\Request;

class WorkShiftsController extends Controller
{


    /**
     * Constructor to initialize the service.
     */
    public function __construct(WorkShiftServices $WorkShiftServices)
    {
        $this->WorkShiftServices = $WorkShiftServices;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $workShifts = $this->WorkShiftServices->getAll();
        return view('admin.work_shifts.index', compact('workShifts'));
    }

    /**
     * Fetch work shift data (for AJAX or API).
     */


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.work_shifts.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $this->WorkShiftServices->store($request);
            return redirect()->route('admin.work_shifts.index')->with('success', 'Work shift added successfully.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $workShift = $this->WorkShiftServices->findById($id);
        return view('admin.work_shifts.show', compact('workShift'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $workShift = $this->WorkShiftServices->findById($id);
        return view('admin.work_shifts.edit', compact('workShift'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try {
            $this->WorkShiftServices->update($request, $id);
            return redirect()->route('admin.work_shifts.index')->with('success', 'Work shift updated successfully.');
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
            $this->WorkShiftServices->destroy($id);
            return redirect()->route('admin.work_shifts.index')->with('success', 'Work shift deleted successfully.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
    public function getdata(Request $request)
    {
        return $this->WorkShiftServices->getdata($request);
    }
}
