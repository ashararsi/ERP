<?php

namespace App\Services;

use App\Models\Formulations;
use App\Models\FormulationDetail;
use App\Models\Batche;
use App\Models\Processe;
use App\Models\Unit;
use App\Models\User;

use App\Models\RawMaterials;
use DataTables;

use Config;

class FormulationServices
{
    public function create()
    {
        return RawMaterials::all();

    }

    public function getusers()
    {
        $suppliers = User::whereHas('roles', function ($query) {
            $query->where('name', 'supplier');
        })->get();


        $qaUsers = User::whereHas('roles', function ($query) {
            $query->where('name', 'QA');
        })->get();
        return ['suppliers' => $suppliers, 'qaUsers' => $qaUsers];
    }

    public function getprocess()
    {
        return $suppliers = Processe::get();
    }

    public function units()
    {
        return Unit::get();
    }

    public function index($request)
    {
        $perPage = $request->get('per_page', 20);
        $posts = Formulations::with('formulationDetail')->orderBy('created_at', 'desc')->paginate($perPage);
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

//        $data['parent_id'] = ($request->parent_id == 0) ? null : $request->parent_id;


        $f = Formulations::create($data);

        foreach ($request->raw_material_id as $key => $value) {

            $data1 = [
                'formulation_id' => $f->id,
                'raw_material_id' => $request->raw_material_id[$key] ?? '',
                'unit_id' => $request->unit[$key] ?? '',
                'standard_quantity' => $request->standard_quantity[$key] ?? 1,
                'remarks' => $request->remarks[$key] ?? '',
            ];

            FormulationDetail::create($data1);
        }


    }

    public function edit($id)
    {
        return Formulations::with('formulationDetail')->where('id', $id)->first();

    }

    public function update($request, $id)
    {
        $validated = $request->all();
        $transaction = Formulations::find($id);
        if ($transaction) {
            $transaction->update($validated);
            FormulationDetail::update($request->all());
        }
        return $transaction;
    }

    public function destroy($id)
    {
        $Transaction = Formulations::findOrFail($id);
        if ($Transaction) {
            $Transaction->delete();
            FormulationDetail::where('formulation_id', $id)->delete();
        }
    }


    public function getdata($request)
    {
        $data = Formulations::select('*')->orderBy('id', 'desc');
        return Datatables::of($data)->addIndexColumn()
            ->addColumn('action', function ($row) {
                $btn = ' <form  method="POST" onsubmit="return confirm(' . "'Are you sure you want to Delete this?'" . ');"  action="' . route("admin.formulations.destroy", $row->id) . '"> ';
                $btn = $btn . '<a href=" ' . route("admin.formulations.show", $row->id) . '"  class="ml-2"><i class="fas fa-eye"></i></a>';
                $btn = $btn . ' <a href="' . route("admin.formulations.edit", $row->id) . '" class="ml-2">  <i class="fas fa-edit"></i></a>';
                $btn = $btn . '<button  type="submit" class="ml-2" ><i class="fas fa-trash"></i></button>';
                $btn = $btn . method_field('DELETE') . '' . csrf_field();
                $btn = $btn . ' </form>';
                return $btn;
            })
            ->rawColumns(['action'])
            ->make(true);

    }
}
