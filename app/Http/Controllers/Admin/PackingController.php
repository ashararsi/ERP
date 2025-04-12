<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\PackingServices;
use Illuminate\Http\Request;

class PackingController extends Controller
{


    public function __construct(PackingServices $PackingServices)
    {
        $this->PackingServices = $PackingServices;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        return view('admin.packing.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $units = $this->PackingServices->units();
        return view('admin.packing.create', compact('units'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $this->PackingServices->store($request);
            return redirect()->route('admin.packing.index');
        } catch (\Exception $e) {

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
        $units = $this->PackingServices->units();
        $packing = $this->PackingServices->edit($id);
        return view('admin.packing.edit', compact('units', 'packing'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try {
            $this->PackingServices->update($request, $id);
            return redirect()->route('admin.packing.index');
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
            $this->PackingServices->destroy($id);
            return redirect()->route('admin.packing.index');
        } catch (\Exception $e) {

            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function getdata(Request $request)
    {
        return $this->PackingServices->getdata($request);
    }
}
