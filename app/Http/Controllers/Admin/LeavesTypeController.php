<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\LeaveTypeServices;
use Illuminate\Http\Request;

class LeavesTypeController extends Controller
{


    /**
     * Constructor to initialize the service.
     */
    public function __construct(LeaveTypeServices $LeaveTypeServices)
    {
        $this->LeaveTypeServices = $LeaveTypeServices;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('admin.leaves_types.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.leaves_types.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $this->LeaveTypeServices->store($request);
            return redirect()->route('admin.leaves_types.index')->with('success', 'Leave type added successfully.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return view('admin.leaves_types.view');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        return view('admin.leaves_types.edit');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try {
            $this->LeaveTypeServices->update($request, $id);
            return redirect()->route('admin.leaves_types.index')->with('success', 'Leave type updated successfully.');
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
            $this->LeaveTypeServices->destroy($id);
            return redirect()->route('admin.leaves_types.index')->with('success', 'Leave type deleted successfully.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    /**
     * Get leave type data.
     */
    public function getdata(Request $request)
    {
        return $this->LeaveTypeServices->getdata($request);
    }
}
