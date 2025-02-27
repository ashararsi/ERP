<?php

namespace App\Services;

use App\Models\RawMaterials;
use Spatie\Permission\Models\Role;
use DataTables;

use Config;

class RawMaterialServices
{
    public function index($request)
    {
        $perPage = $request->get('per_page', 20);
        $posts = RawMaterials::orderBy('created_at', 'desc')->paginate($perPage);
        return response()->json([
            'data' => $posts->items(),
            'current_page' => $posts->currentPage(),
            'last_page' => $posts->lastPage(),
            'per_page' => $posts->perPage(),
            'total' => $posts->total(),
            'next_page_url' => $posts->nextPageUrl(),
            'prev_page_url' => $posts->previousPageUrl(),
        ]);
    }

    public function store($request)
    {
        return RawMaterials::create($request->all());

    }

    public function edit($id)
    {
        return RawMaterials::findOrFail($id);

    }

    public function update($request, $id)
    {
        $validated = $request->all();
        $transaction = RawMaterials::find($id);
        if ($transaction) {
            $transaction->update($validated);
        }
        return $transaction;
    }

    public function destroy($id)
    {
        $Transaction = RawMaterials::findOrFail($id);
        if ($Transaction) {
            $Transaction->delete();
        }
    }


    public function getdata($request)
    {
        $data = RawMaterials::select('*')->orderBy('id', 'desc');
        return Datatables::of($data)->addIndexColumn()
            ->addColumn('action', function ($row) {
                $btn = ' <form  method="POST" onsubmit="return confirm(' . "'Are you sure you want to Delete this?'" . ');"  action="' . route("admin.raw-material.destroy", $row->id) . '"> ';
                $btn = $btn . '<a href=" ' . route("admin.raw-material.show", $row->id) . '"  class="ml-2"><i class="fas fa-eye"></i></a>';
                $btn = $btn . ' <a href="' . route("admin.raw-material.edit", $row->id) . '" class="ml-2">  <i class="fas fa-edit"></i></a>';
                $btn = $btn . '<button  type="submit" class="ml-2" ><i class="fas fa-trash"></i></button>';
                $btn = $btn . method_field('DELETE') . '' . csrf_field();
                $btn = $btn . ' </form>';
                return $btn;
            })
            ->rawColumns(['action'])
            ->make(true);

    }
}
