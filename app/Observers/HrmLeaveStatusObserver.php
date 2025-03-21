<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\LeaveStatusesServices;
use Illuminate\Http\Request;

class LeavesStatusesController extends Controller
{
    protected $leaveStatusesServices;

    /**
     * Constructor to initialize the service.
     */
    public function __construct(LeaveStatusesServices $leaveStatusesServices)
    {
        $this->leaveStatusesServices = $leaveStatusesServices;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('admin.leaves_statuses.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.leaves_statuses.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $this->LeaveStatusesServices->store($request);
            return redirect()->route('admin.leaves_statuses.index')->with('success', 'Leave status added successfully.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return view('admin.leaves_statuses.view');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        return view('admin.leaves_statuses.edit');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try {
            $this->leaveStatusesServices->update($request, $id);
            return redirect()->route('admin.leaves_statuses.index')->with('success', 'Leave status updated successfully.');
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
            $this->leaveStatusesServices->destroy($id);
            return redirect()->route('admin.leaves_statuses.index')->with('success', 'Leave status deleted successfully.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    /**
     * Get leave statuses data.
     */
    public function getdata(Request $request)
    {
        return $this->leaveStatusesServices->getdata($request);
    }
}
