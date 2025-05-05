<?php

namespace App\Services;

use App\Imports\PackingMaterialImport;
use App\Models\Category;
use App\Models\PackingMaterial;
use App\Models\Unit;
use DataTables;
use Maatwebsite\Excel\Facades\Excel;

class PackingMaterialService
{
    public function getCreateView()
    {
        $categories = Category::all();
        $units = Unit::all();
        return view('admin.packing-materials.form', compact('categories', 'units'));
    }

    public function getEditView($id)
    {
        $packingMaterial = PackingMaterial::findOrFail($id);
        $categories = Category::all();
        $units = Unit::all();
        return view('admin.packing-materials.form', compact('packingMaterial', 'categories', 'units'));
    }

    public function store(array $data)
    {
        PackingMaterial::create($data);
    }

    public function update(array $data, $id)
    {
        $packingMaterial = PackingMaterial::findOrFail($id);
        $packingMaterial->update($data);
    }

    public function delete($id)
    {
        PackingMaterial::findOrFail($id)->delete();
    }

    public function getdata($request)
    {
        $data = PackingMaterial::select('*')->orderBy('id', 'desc');
        return Datatables::of($data)->addIndexColumn()
            ->addColumn('action', function ($row) {
                $btn = ' <form  method="POST" onsubmit="return confirm(' . "'Are you sure you want to Delete this?'" . ');"  action="' . route("admin.packing-materials.destroy", $row->id) . '"> ';
                $btn = $btn . '<a href=" ' . route("admin.packing-materials.show", $row->id) . '"  class="ml-2"><i class="fas fa-eye"></i></a>';
                $btn = $btn . ' <a href="' . route("admin.packing-materials.edit", $row->id) . '" class="ml-2">  <i class="fas fa-edit"></i></a>';
                $btn = $btn . '<button  type="submit" class="ml-2" ><i class="fas fa-trash"></i></button>';
                $btn = $btn . method_field('DELETE') . '' . csrf_field();
                $btn = $btn . ' </form>';
                return $btn;
            })
            ->rawColumns(['action'])
            ->make(true);

    }

    public function importdata($request)
    {
        return Excel::import(new PackingMaterialImport(), $request->file('excel_file')); 
    }
}
