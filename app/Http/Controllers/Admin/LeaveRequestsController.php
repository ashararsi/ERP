<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\HrmLeaveRequestsServices;
use Illuminate\Http\Request;

class LeaveRequestsController extends Controller
{


    /**
     * Constructor to initialize the service.
     */
    public function __construct(HrmLeaveRequestsServices $HrmLeaveRequestsServices)
    {
        $this->HrmLeaveRequestsServices = $HrmLeaveRequestsServices;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('admin.leave_requests.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $data_create=$this->HrmLeaveRequestsServices->create();

        return view('admin.leave_requests.create',compact('data_create'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
      try {
            $this->HrmLeaveRequestsServices->store($request);
            return redirect()->route('admin.hrm-leave-requests.index')->with('success', 'Leave request submitted successfully.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return view('admin.leave_requests.view');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $data_create=$this->HrmLeaveRequestsServices->create();
        $leave_request=$this->HrmLeaveRequestsServices->edit($id);
        return view('admin.leave_requests.edit',compact('data_create','leave_request'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try {
            $this->HrmLeaveRequestsServices->update($request, $id);
            return redirect()->route('admin.leave-requests.index')->with('success', 'Leave request updated successfully.');
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
            $this->HrmLeaveRequestsServices->destroy($id);
            return redirect()->route('admin.leave-requests.index')->with('success', 'Leave request deleted successfully.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    /**
     * Get leave request data.
     */
    public function getdata(Request $request)
    {
        return $this->HrmLeaveRequestsServices->getdata($request);
    }
}
