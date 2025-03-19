<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Country;
use App\Services\CountryServices;
use Illuminate\Http\Request;

class CountryController extends Controller
{
    public function __construct(CountryServices $CountryServices)
    {
        $this->CountryServices = $CountryServices;
    }

    public function index()
    {
        $countries =Country::all();
        return view('admin.country.index',compact('countries'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.country.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
//        dd($request);
        try {
            $country = $this->CountryServices->store($request);
            return redirect()->route('admin.country.index');
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
            $country = $this->CountryServices->edit($id);
            return view('admin.country.view', compact('country'));
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
            $country = $this->CountryServices->edit($id);
            return view('admin.country.edit', compact('country'));
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
            $raw = $this->CountryServices->update($request, $id);
            return redirect()->route('admin.country.index');
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

            $raw = $this->CountryServices->destroy($id);
            return redirect()->route('admin.country.index');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function getdata(Request $request)
    {
        return $this->CountryServices->getdata($request);

    }
}
