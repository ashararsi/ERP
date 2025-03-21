<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\HrmLeavesServices;
use Illuminate\Http\Request;

class LeavesController extends Controller
{


    /**
     * Constructor to initialize the service.
     */
    public function __construct(HrmLeavesServices $HrmLeavesServices)
    {
        $this->HrmLeavesServices = $HrmLeavesServices;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('admin.leaves.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.leaves.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $this->HrmLeavesServices->store($request);
            return redirect()->route('admin.leaves.index')->with('success', 'Leave request submitted successfully.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return view('admin.leaves.view');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        return view('admin.leaves.edit');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try {
            $this->HrmLeavesServices->update($request, $id);
            return redirect()->route('admin.leaves.index')->with('success', 'Leave request updated successfully.');
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
            $this->HrmLeavesServices->destroy($id);
            return redirect()->route('admin.leaves.index')->with('success', 'Leave request deleted successfully.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    /**
     * Get leave data.
     */
    public function getdata(Request $request)
    {
        return $this->HrmLeavesServices->getdata($request);
    }
}
