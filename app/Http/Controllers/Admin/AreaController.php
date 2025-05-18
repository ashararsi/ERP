<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Area;
use App\Models\City;
use App\Models\Company;
use App\Services\AreaService;
use Illuminate\Http\Request;

class AreaController extends Controller
{
    protected $areaService;

    public function __construct(AreaService $areaService)
    {
        $this->areaService = $areaService;
    }

    public function index()
    {
        try {
            $areas = $this->areaService->getAll();
            return view('admin.areas.index', compact('areas'));
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    public function create()
    {
        $companies = Company::all();
        $cities = City::all();
        return view('admin.areas.create', compact('companies','cities'));
    }

    public function store(Request $request)
    {
        try {
            $this->areaService->store($request->all());
            return redirect()->route('admin.areas.index')->with('success', 'Area created successfully.');
        } catch (\Exception $e) {
            return back()->withInput()->with('error', $e->getMessage());
        }
    }

    public function show()
    {
        //
    }

    public function edit(string $id)
    {
        try {
            $area = $this->areaService->find($id);
            $companies = Company::all();
            $cities = City::all();
            return view('admin.areas.edit', compact('area', 'companies','cities'));
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    public function update(Request $request, string $id)
    {
        try {
            $this->areaService->update($id, $request->all());
            return redirect()->route('admin.areas.index')->with('success', 'Area updated successfully.');
        } catch (\Exception $e) {
            return back()->withInput()->with('error', $e->getMessage());
        }
    }

    public function destroy(string $id)
    {
        try {
            $this->areaService->delete($id);
            return redirect()->route('admin.areas.index')->with('success', 'Area deleted successfully.');
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    public function getdata(Request $request)
    {
        return $this->areaService->getdata($request);
    }

    public function getByCompany(Request $request)
    {
        $areas = Area::where('company_id', $request->company_id)->get(['id', 'name']);
        return response()->json($areas);
    }

    public function getByCity($cityId)
    {
        $areas = Area::where('city_id', $cityId)->get(['id', 'name']);
        return response()->json($areas);
    }
}
