<?php

namespace App\Services;

use App\Models\Formulations;
use App\Models\FormulationDetail;
use App\Models\Batche;
use App\Models\Processe;
use App\Models\PurchaseOrder;
use App\Models\Supplier;
use App\Models\Unit;
use App\Models\User;

use App\Models\RawMaterials;
use DataTables;

use Config;

class FormulationServices
{
    public function create()
    {
        return Formulations::all();

    }

    public function Raw()
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
        return [
            'suppliers' => $suppliers,
            'qaUsers' => $qaUsers,
            'operator_initials' => $operator_initials,
            'Prod' => $Prod
        ];
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
        $f = Formulations::create($data);

        $materials = $data['materials'];

        foreach ($materials as $key => $value) {

            $data1 = [
                'formulation_id' => $f->id,
                'raw_material_id' => $value['raw_material_id'] ?? null,
                'unit_id' => $value['unit'] ?? null,
                'standard_quantity' => $value['standard_quantity'] ?? 1,
                'process_id' => $value['process'] ?? 1,
                'remarks' => $value['remarks'] ?? '',
            ];

            FormulationDetail::create($data1);
        }


        foreach ($data['processes'] as $processData) {
            $batchProcess = $batch->processes()->create([
                'process_id' => $processData['process_id'],
                'duration_minutes' => $processData['duration_minutes'],
                'order' => $processData['order'] ?? 0,
                'remarks' => $processData['remarks'] ?? null,
                'status' => 'pending',
            ]);

            // Add checkpoints
            foreach ($processData['checkpoints'] as $checkpointData) {
                $batchProcess->checkpoints()->create([
                    'name' => $checkpointData['name'],
                    'unit_id' => $checkpointData['unit_id'],
                    'standard_value' => $checkpointData['standard_value'],
                    'actual_value' => null, // Will be filled during execution
                ]);
            }
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
                $btn = $btn . '<a href=" ' . route("admin.formulation.pdf", $row->id) . '"  class="ml-2"><i class="fas fa-print"></i></a>';
                return $btn;
            })
            ->rawColumns(['action'])
            ->make(true);

    }

    public function fetch_po_record($request)
    {
        $data = $this->data_pdf();
        $f = Formulations::with('formulationDetail')->where('id', $request->id)->first();
        $qty = $request->total_qty;
        $users = $this->getusers();
        return view('admin.formulation.data', compact('users', 'f', 'data', 'qty'));


    }

    public function data_pdf()
    {
        $data['units'] = Unit::all();
        $data['Supplier'] = Supplier::all();
        $data['RawMaterials'] = RawMaterials::all();
        $data['po'] = PurchaseOrder::all();
        return $data;
    }


}
