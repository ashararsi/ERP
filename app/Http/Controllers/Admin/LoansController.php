<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\LoansServices;
use Illuminate\Http\Request;

class LoansController extends Controller
{


    /**
     * Constructor to initialize the service.
     */
    public function __construct(LoansServices $LoansServices)
    {
        $this->LoansServices = $LoansServices;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
//        $loans = $this->LoansServices->getAll();
        return view('admin.loans.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.loans.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $this->LoansServices->store($request);
            return redirect()->route('admin.loans.index')->with('success', 'Loan added successfully.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $loan = $this->LoansServices->findById($id);
        return view('admin.loans.show', compact('loan'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $loan = $this->LoansServices->findById($id);
        return view('admin.loans.edit', compact('loan'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try {
            $this->LoansServices->update($request, $id);
            return redirect()->route('admin.loans.index')->with('success', 'Loan updated successfully.');
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
            $this->LoansServices->destroy($id);
            return redirect()->route('admin.loans.index')->with('success', 'Loan deleted successfully.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
    public function getdata(Request $request)
    {
        return $this->LoansServices->getdata($request);
    }
}
