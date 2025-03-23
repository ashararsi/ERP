<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\BatchServices;
use App\Services\FormulationServices;
use App\Services\InventoryServices;

class InventoryController extends Controller
{
    public function __construct(InventoryServices $InventoryServices, FormulationServices $FormulationServices)
    {
        $this->InventoryServices = $InventoryServices;
        $this->FormulationServices = $FormulationServices; // Assign the service
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('admin.inventory.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

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

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {

    }

    public function getdata(Request $request)
    {
        return $this->InventoryServices->getdata($request);
    }
}
