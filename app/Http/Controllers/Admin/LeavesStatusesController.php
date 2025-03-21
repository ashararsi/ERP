<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\HrmLeavesServices;
use App\Services\LeaveStatusesServices;
use Illuminate\Http\Request;

class LeavesStatusesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function __construct(LeaveStatusesServices $LeaveStatusesServices)
    {
        $this->LeaveStatusesServices = $LeaveStatusesServices;
    }
    public function index()
    {
   return view('admin.leave_statuses.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.leave_statuses.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $this->LeaveStatusesServices->store($request);
            return redirect()->route('admin.leave-statuses.index')->with('success', 'Leave request submitted successfully.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return view('admin.leave_statuses.view');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        return view('admin.leave_statuses.edit');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try {
            $this->LeaveStatusesServices->update($request, $id);
            return redirect()->route('admin.leave-statuses.index')->with('success', 'Leave request updated successfully.');
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
            $this->LeaveStatusesServices->destroy($id);
            return redirect()->route('admin.leave-statuses.index');
        } catch (\Exception $e) {

            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function getdata(Request $request)
    {
        return $this->LeaveStatusesServices->getdata($request);

    }
}
