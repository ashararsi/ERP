<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\BranchesServices;
use Illuminate\Http\Request;

class BranchesController extends Controller
{


    public function __construct(BranchesServices $BranchesServices)
    {
        $this->BranchesServices = $BranchesServices;
    }


    /**
     * Display a listing of the resource.
     */


    public function index()
    {
        return view('admin.branches.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $companies = $this->BranchesServices->create();
        return view('admin.branches.create', compact('companies'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $this->BranchesServices->store($request);
            return redirect()->route('admin.branches.index');
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
        try {
            $companies = $this->BranchesServices->create();
            $b = $this->BranchesServices->edit($id);
            return view('admin.branches.edit', compact('companies', 'b'));
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
            $this->BranchesServices->update($request, $id);
            return redirect()->route('admin.branches.index');
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
            $this->BranchesServices->destroy($id);
            return redirect()->route('admin.branches.index');
        } catch (\Exception $e) {

            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function getdata(Request $request)
    {
        return $this->BranchesServices->getdata($request);

    }   public function getBranches($company_id)
    {
        return $this->BranchesServices->getBranches($company_id);

    }
}
