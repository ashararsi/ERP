<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\CompanyServices;
use Illuminate\Http\Request;

class CompaniesController extends Controller
{
    /**
     * Display a listing of the resource.
     */


    public function __construct(CompanyServices $CompanyServices)
    {
        $this->CompanyServices = $CompanyServices;
    }


    public function index()
    {
        return view('admin.companies.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.companies.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $this->CompanyServices->store($request);
            return redirect()->route('admin.companies.index');
        } catch (\Exception $e) {

            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        try {
            $c = $this->CompanyServices->edit($id);
            return view('admin.companies.view', compact('c'));
        } catch (\Exception $e) {

            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        try {
            $c = $this->CompanyServices->edit($id);
            return view('admin.companies.edit', compact('c'));
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
            $c = $this->CompanyServices->update($request, $id);
            return redirect()->route('admin.companies.index');
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
            $c = $this->CompanyServices->destroy($id);
            return redirect()->route('admin.companies.index');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function getdata(Request $request)
    {
        return $this->CompanyServices->getdata($request);
    }
}
