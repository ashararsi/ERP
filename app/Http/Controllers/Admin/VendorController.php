<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\VendorServices;
use Illuminate\Http\Request;

class VendorController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    public function __construct(VendorServices $VendorServices)
    {
        $this->VendorServices = $VendorServices;
    }
    public function index()
    {
        return view('admin.vendor.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.vendor.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $this->VendorServices->store($request);
            return redirect()->route('admin.vendor.index');
        } catch (\Exception $e) {
            dd($e);
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
            $v=$this->VendorServices->edit($id);
            return view('admin.vendor.edit',compact('v'));
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
            $this->VendorServices->update($request,$id);
            return redirect()->route('admin.vendor.index');

        } catch (\Exception $e) {

            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(  $id)
    {
        try {
            $this->VendorServices->destroy($id);
            return redirect()->route('admin.vendor.index');

        } catch (\Exception $e) {

            return redirect()->back()->with('error', $e->getMessage());
        }
    } public function getdata(Request $request)
{
    return $this->VendorServices->getdata($request);
}
}
