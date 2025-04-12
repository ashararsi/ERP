<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\HrmLeaveEntitlementServices;
use Illuminate\Http\Request;

class LeaveEntitlementsController extends Controller
{


    /**s
     * Constructor to initialize the service.
     */
    public function __construct(HrmLeaveEntitlementServices $HrmLeaveEntitlementServices)
    {
        $this->HrmLeaveEntitlementServices = $HrmLeaveEntitlementServices;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('admin.leave_entitlements.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $data_create=   $this->HrmLeaveEntitlementServices->create( );
        return view('admin.leave_entitlements.create',compact('data_create'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        try {
            $this->HrmLeaveEntitlementServices->store($request);
            return redirect()->route('admin.leave-entitlement.index')->with('success', 'Leave entitlement added successfully.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return view('admin.leave_entitlements.view');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        return view('admin.leave_entitlements.edit');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try {
            $this->HrmLeaveEntitlementServices->update($request, $id);
            return redirect()->route('admin.leave-entitlement.index')->with('success', 'Leave entitlement updated successfully.');
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
            $this->HrmLeaveEntitlementServices->destroy($id);
            return redirect()->route('admin.leave-entitlements.index')->with('success', 'Leave entitlement deleted successfully.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    /**
     * Get leave entitlement data.
     */
    public function getdata(Request $request)
    {
        return $this->HrmLeaveEntitlementServices->getdata($request);
    }
}
