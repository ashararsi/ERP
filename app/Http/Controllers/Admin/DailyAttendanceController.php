<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\DailyAttendanceServices;
use Illuminate\Http\Request;

class DailyAttendanceController extends Controller
{


    public function __construct(DailyAttendanceServices $DailyAttendanceServices)
    {
        $this->DailyAttendanceServices = $DailyAttendanceServices;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('admin.daily_attendance.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $data_create = $this->DailyAttendanceServices->create();
        return view('admin.daily_attendance.create', compact('data_create'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $this->DailyAttendanceServices->store($request);
            return redirect()->route('admin.attendance.index')->with('success', 'Leave entitlement added successfully.');
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
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        try {
            $Attendance=   $this->DailyAttendanceServices->edit($id);
            $data_create = $this->DailyAttendanceServices->create();
            return view('admin.daily_attendance.edit', compact('data_create','Attendance'));
        } catch (\Exception $e) {
            dd($e->getMessage());
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try {
            $this->DailyAttendanceServices->update($request,$id);
            return redirect()->route('admin.attendance.index')->with('success', 'attendance Update     successfully.');
        } catch (\Exception $e) {
            dd($e->getMessage());
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $this->DailyAttendanceServices->destroy($id);
            return redirect()->route('admin.attendance.index')->with('success', 'attendance delete     successfully.');
        } catch (\Exception $e) {
            dd($e->getMessage());
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function getdata(Request $request)
    {
        return $this->DailyAttendanceServices->getdata($request);
    }
}
