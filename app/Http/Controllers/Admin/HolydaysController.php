<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Country;
use App\Services\HolydaysServices;
use Illuminate\Http\Request;

class HolydaysController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function __construct(HolydaysServices $HolydaysServices)
    {
        $this->HolydaysServices = $HolydaysServices;
    }

    public function index()
    {
        return view('admin.holyday.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {

        return view('admin.holyday.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $this->HolydaysServices->store($request);
            return redirect()->route('admin.holydays.index');
        } catch (\Exception $e) {

            return redirect()->back()->with('error', $e->getMessage());
        }  //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return view('admin.holyday.view');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {

        try {
            $holyday = $this->HolydaysServices->edit($id);
            return view('admin.holyday.edit', compact('holyday'));
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
            $this->HolydaysServices->update($request, $id);
            return redirect()->route('admin.holydays.index');
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
            $this->HolydaysServices->destroy($id);
            return redirect()->route('admin.holydays.index');
        } catch (\Exception $e) {

            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function getdata(Request $request)
    {
        return $this->HolydaysServices->getdata($request);

    }

}
