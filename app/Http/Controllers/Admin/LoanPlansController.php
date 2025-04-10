<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\LoanPlansServices;
use Illuminate\Http\Request;

class LoanPlansController extends Controller
{
    protected $loanPlansServices;

    /**
     * Constructor to initialize the service.
     */
    public function __construct(LoanPlansServices $LoanPlansServices)
    {
        $this->LoanPlansServices = $LoanPlansServices;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
//        $loanPlans = $this->LoanPlansServices->getAll();
        return view('admin.loan_plans.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.loan_plans.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $this->LoanPlansServices->store($request);
            return redirect()->route('admin.loan-plans.index')->with('success', 'Loan plan added successfully.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $loanPlan = $this->LoanPlansServices->findById($id);
        return view('admin.loan_plans.show', compact('loanPlan'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $loanPlan = $this->LoanPlansServices->findById($id);
        return view('admin.loan_plans.edit', compact('loanPlan'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try {
            $this->LoanPlansServices->update($request, $id);
            return redirect()->route('admin.loan-plans.index')->with('success', 'Loan plan updated successfully.');
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
            $this->LoanPlansServices->destroy($id);
            return redirect()->route('admin.loan-plans.index')->with('success', 'Loan plan deleted successfully.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
    public function getdata(Request $request)
    {
        return $this->LoanPlansServices->getdata($request);
    }
}
