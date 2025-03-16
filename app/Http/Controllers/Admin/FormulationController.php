<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\FormulationServices;
use Illuminate\Http\Request;

class FormulationController extends Controller
{


    public function __construct(FormulationServices $FormulationServices)
    {
        $this->FormulationServices = $FormulationServices;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('admin.formulation.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $raw = $this->FormulationServices->Raw();
        $users = $this->FormulationServices->getusers();
        $process = $this->FormulationServices->getprocess();
        $units = $this->FormulationServices->getprocess();


        return view('admin.formulation.create', compact('raw', 'users','process','units'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $this->FormulationServices->store($request);
            return redirect()->route('admin.formulations.index');
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
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function getdata(Request $request)
    {
      return $this->FormulationServices->getdata($request);
    }
}
