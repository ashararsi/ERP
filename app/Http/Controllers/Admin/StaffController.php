<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Branch;
use App\Models\User;
use App\Services\StaffServices;
use Illuminate\Http\Request;

class StaffController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function __construct(StaffServices $StaffServices)
    {
        $this->StaffServices = $StaffServices;
    }
    public function index()
    {
        return view('admin.staff.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $branches=Branch::all();
        $users=User::all();
        return view('admin.staff.create',compact('branches','users'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $staff = $this->StaffServices->store($request);
            return redirect()->route('admin.staff.index');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        try {
            $staff = $this->StaffServices->edit($id);
            return view('admin.staff.view', compact('staff'));
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        try {
            $staff = $this->StaffServices->edit($id);
            return view('admin.staff.edit', compact('staff'));
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try {
            $raw = $this->StaffServices->update($request, $id);
            return redirect()->route('admin.staff.index');
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

            $raw = $this->StaffServices->destroy($id);
            return redirect()->route('admin.staff.index');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function getdata(Request $request)
    {
        return $this->StaffServices->getdata($request);

    }
}
