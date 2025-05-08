<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PackingMaterial;
use App\Services\PackingMaterialService;
use Illuminate\Http\Request;

class PackingMaterialController extends Controller
{
    protected $service;

    public function __construct(PackingMaterialService $service)
    {
        $this->service = $service;
    }

    public function index()
    {
        return view('admin.packing-materials.index');
    }

    public function create()
    {
        return $this->service->getCreateView();
    }

    public function store(Request $request)
    {
        try {
            $this->service->store($request->all());
            return redirect()->route('admin.packing-materials.index');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors($e->getMessage());
        }
    }

    public function edit($id)
    {
        return $this->service->getEditView($id);
    }

    public function update(Request $request, $id)
    {
        try {
            $this->service->update($request->all(), $id);
            return redirect()->route('admin.packing-materials.index');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors($e->getMessage());
        }
    }

    public function destroy($id)
    {
        try {
            $this->service->delete($id);
            return redirect()->route('admin.packing-materials.index');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors($e->getMessage());
        }
    }

    public function getdata(Request $request)
    {
        return $this->service->getdata($request);
    }

    public function showImport()
    {
        return view('admin.packing-materials.import');
    }

    public function importData(Request $request)
    {
         $this->service->importdata($request);
         return redirect()->route('admin.packing-materials.index')->with('success', 'Data created successfully');
    }

    public function show($id)
    {
        $packingMaterial = PackingMaterial::with(['category', 'unit'])->findOrFail($id);

        return view('admin.packing-materials.view', compact('packingMaterial'));
    }
}
