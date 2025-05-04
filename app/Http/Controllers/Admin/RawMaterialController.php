<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\RawMaterialServices;
use Illuminate\Http\Request;

class RawMaterialController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function __construct(RawMaterialServices $RawMaterialServices)
    {
        $this->RawMaterialServices = $RawMaterialServices;
    }

    public function index()
    {
        return view('admin.raw-material.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $units = $this->RawMaterialServices->create();
        $supplier = $this->RawMaterialServices->suptlier_get();
        return view('admin.raw-material.create', compact('units', 'supplier'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $this->RawMaterialServices->store($request);
            return redirect()->route('admin.raw-material.index');
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
            $units = $this->RawMaterialServices->create();
            $raw = $this->RawMaterialServices->edit($id);
            return view('admin.raw-material.edit', compact('raw', 'units'));
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

            $raw = $this->RawMaterialServices->update($request, $id);
            return redirect()->route('admin.raw-material.index');
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

            $raw = $this->RawMaterialServices->destroy($id);
            return redirect()->route('admin.raw-material.index');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function getdata(Request $request)
    {
        return $this->RawMaterialServices->getdata($request);

    }    public function importdata(Request $request)
    {


        return view('admin.raw-material.import');

    } public function importdata_post(Request $request)
    {
        return $this->RawMaterialServices->importdata($request);

    }
}
