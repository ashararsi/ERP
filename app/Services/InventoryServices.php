<?php

namespace App\Services;

use App\Models\BatchDetail;
use App\Models\Batche;
use App\Models\Inventory;
use App\Models\Product;
use App\Models\User;

use App\Models\RawMaterials;
use DataTables;

use Config;

class InventoryServices
{
    public function create()
    {
        return RawMaterials::all();
    }

    public function getusers()
    {
        $suppliers = User::whereHas('roles', function ($query) {
            $query->where('name', 'Supplier');
        })->get();

        $qaUsers = User::whereHas('roles', function ($query) {
            $query->where('name', 'QA');
        })->get();
        $operator_initials = User::whereHas('roles', function ($query) {
            $query->where('name', 'Operator');
        })->get();
        $Prod = User::whereHas('roles', function ($query) {
            $query->where('name', 'Prod In-Charge');
        })->get();
        return ['suppliers' => $suppliers, 'qaUsers' => $qaUsers, 'operator_initials' => $operator_initials, 'Prod' => $Prod];
    }

    public function index($request)
    {
        $perPage = $request->get('per_page', 20);
        $posts = Inventory::orderBy('created_at', 'desc')->paginate($perPage);
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
        $data = $request->all();
        $b = Inventory::create($data);

    }

    public function edit($id)
    {
        return Inventory::findOrFail($id);
    }

    public function update($request, $id)
    {
        $validated = $request->all();
        $transaction = Inventory::find($id);
        if ($transaction) {
            $transaction->update($validated);
        }
        return $transaction;
    }

    public function destroy($id)
    {
        $Transaction = Inventory::findOrFail($id);
        if ($Transaction) {
            $Transaction->delete();

        }
    }


    public function getdata($request)
    {
        $data = Inventory::select('*')->orderBy('id', 'desc');
        return Datatables::of($data)->addIndexColumn()
            ->addColumn('action', function ($row) {
//                $btn = ' <form  method="POST" onsubmit="return confirm(' . "'Are you sure you want to Delete this?'" . ');"  action="' . route("admin.inventory.destroy", $row->id) . '"> ';
//                $btn = $btn . '<a href=" ' . route("admin.batches.show", $row->id) . '"  class="ml-2"><i class="fas fa-eye"></i></a>';
//                $btn = $btn . ' <a href="' . route("admin.batches.edit", $row->id) . '" class="ml-2">  <i class="fas fa-edit"></i></a>';
//                $btn = $btn . '<button  type="submit" class="ml-2" ><i class="fas fa-trash"></i></button>';
//                $btn = $btn . method_field('DELETE') . '' . csrf_field();
//                $btn = $btn . ' </form>';
                return 'Coming Soon';
            })
            ->rawColumns(['action'])
            ->make(true);

    }
}
