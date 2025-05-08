<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\ProcessesServices;
use Illuminate\Http\Request;
use PDF;
class ProcessController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function __construct(ProcessesServices $ProcessesServices)
    {
        $this->ProcessesServices = $ProcessesServices;
    }
    public function index()
    {
         return view('admin.processes.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.processes.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {

            $this->ProcessesServices->store($request);
            return redirect()->route('admin.processes.index');
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
        try {

          $processes=  $this->ProcessesServices->edit($id);
            return view('admin.processes.view',compact('processes'));
        } catch (\Exception $e) {
            dd($e->getMessage());
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        try {

            $processes=$this->ProcessesServices->edit($id);
            return view('admin.processes.edit',compact('processes'));
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

            $this->ProcessesServices->update($request,$id);
            return redirect()->route('admin.processes.index');
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

            $this->ProcessesServices->destroy($id);
            return redirect()->route('admin.processes.index');
        } catch (\Exception $e) {
            dd($e->getMessage());
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function getdata(Request $request){
        return $this->ProcessesServices->getdata($request);
    }
}
