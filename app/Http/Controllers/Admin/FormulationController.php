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
        $raw = $this->FormulationServices->create();
        $users = $this->FormulationServices->getusers();


        return view('admin.formulation.create', compact('raw', 'users'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
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
        $data = $this->FormulationServices->getdata($request);
    }
}
