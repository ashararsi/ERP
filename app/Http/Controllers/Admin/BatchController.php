<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\BatchServices;
use App\Services\FormulationServices;

use Illuminate\Http\Request;

class BatchController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    public function __construct(BatchServices $BatchServices, FormulationServices $FormulationServices)
    {
        $this->BatchServices = $BatchServices;
        $this->FormulationServices = $FormulationServices; // Assign the service
    }

    public function index()
    {
        return view('admin.batch.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {

        $raw = $this->BatchServices->create();

        $formulation = $this->FormulationServices->create();

        $users = $this->BatchServices->getusers();

        return view('admin.batch.create', compact('raw', 'users', 'formulation'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $this->BatchServices->store($request);
            return redirect()->route('admin.batches.index');
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
        return view('admin.batch.view');

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        return view('admin.batch.edit');

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try {
            $this->BatchServices->update($request, $id);
            return redirect()->route('admin.batches.index');
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
            $this->BatchServices->destroy($id);
            return redirect()->route('admin.batches.index');
        } catch (\Exception $e) {
            dd($e->getMessage());
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function getdata(Request $request)
    {
        return $this->BatchServices->getdata($request);

    }
}
