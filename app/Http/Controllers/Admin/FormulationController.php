<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Formulations;
use App\Services\FormulationServices;
use Illuminate\Http\Request;
use PDF;

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
        $units = $this->FormulationServices->units();


        return view('admin.formulation.create', compact('raw', 'users', 'process', 'units'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
//        try {

            $this->FormulationServices->store($request);
            return redirect()->route('admin.formulations.index');
//        } catch (\Exception $e) {
//            dd($e->getMessage());
//            return redirect()->back()->with('error', $e->getMessage());
//        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $f = Formulations::with('formulationDetail')->find($id);
        $raw = $this->FormulationServices->Raw();
        $users = $this->FormulationServices->getusers();
        $process = $this->FormulationServices->getprocess();
        $units = $this->FormulationServices->units();
        return view('admin.formulation.view', compact('raw', 'users', 'process', 'units', 'f'));
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        try {
            $f = $this->FormulationServices->edit($id);
            $raw = $this->FormulationServices->Raw();
            $users = $this->FormulationServices->getusers();
            $process = $this->FormulationServices->getprocess();
            $units = $this->FormulationServices->units();
            return view('admin.formulation.edit', compact('raw', 'users', 'process', 'units', 'f'));

        } catch (\Exception $e) {
            dd($e->getMessage());
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
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
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $this->FormulationServices->destroy($id);
            return redirect()->route('admin.formulations.index');
        } catch (\Exception $e) {
            dd($e->getMessage());
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function getdata(Request $request)
    {
        return $this->FormulationServices->getdata($request);
    }

    public function fetch_po_record(Request $request)
    {
        return $this->FormulationServices->fetch_po_record($request);
    }

    public function generateformulationPDF($id)
    {
        $f = $this->FormulationServices->edit($id);
        $pdf = Pdf::loadView('admin.formulation.report_pdf', compact('f'));
        return $pdf->download('formulation_Report_' . $id . '.pdf');
    }
}
