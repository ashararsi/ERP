<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\FinancialYearServices;
use Illuminate\Http\Request;

class FinancialYearController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function __construct(FinancialYearServices $FinancialYearServices)
    {
        $this->FinancialYearServices = $FinancialYearServices;
    }
    public function index()
    {
       return view('admin.financial_year.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.financial_year.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $this->FinancialYearServices->store($request);
            return redirect()->route('admin.financial-year.index');
        } catch (\Exception $e) {
dd($e);
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show( $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit( $id)
    {
        try {
            $f=$this->FinancialYearServices->edit($id);
            return view('admin.financial_year.edit',compact('f'));
        } catch (\Exception $e) {

            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request,  $id)
    {
        try {
            $this->FinancialYearServices->update($request,$id);
            return redirect()->route('admin.financial-year.index');

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
            $this->FinancialYearServices->destroy($id);
            return redirect()->route('admin.financial-year.index');

        } catch (\Exception $e) {

            return redirect()->back()->with('error', $e->getMessage());
        }
    } public function getdata(Request $request)
    {
        return $this->FinancialYearServices->getdata($request);
    }
}
