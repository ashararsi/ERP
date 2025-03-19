<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Country;
use App\Services\CityServices;
use Illuminate\Http\Request;

class CityController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function __construct(CityServices $CityServices)
    {
        $this->CityServices = $CityServices;
    }
    public function index()
    {
        $cities =Country::all();
        return view('admin.city.index',compact('cities'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $countries =Country::all();
        return view('admin.city.create',compact('countries'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $city = $this->CityServices->store($request);
            return redirect()->route('admin.city.index');
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
            $city = $this->CityServices->edit($id);
            return view('admin.city.view', compact('city'));
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
            $city = $this->CityServices->edit($id);

            $countries =Country::all();
            return view('admin.city.edit', compact('city','countries'));
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
            $raw = $this->CityServices->update($request, $id);
            return redirect()->route('admin.city.index');
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

            $raw = $this->CityServices->destroy($id);
            return redirect()->route('admin.city.index');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function getdata(Request $request)
    {
        return $this->CityServices->getdata($request);

    }
}
