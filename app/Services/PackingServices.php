<?php

namespace App\Services;


use App\Models\Packing;

use App\Models\Unit;
use App\Models\User;

use App\Models\RawMaterials;
use DataTables;

use Config;

class PackingServices
{
    public function create()
    {
        return Packing::all();
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




    public function units()
    {
        return Unit::get();
    }



    public function store($request)
    {
        $data = $request->all();

        $b = Packing::create($data);
    }

    public function edit($id)
    {
        return Packing::findOrFail($id);
    }

    public function update($request, $id)
    {
        $validated = $request->all();
        $transaction = Packing::find($id);
        if ($transaction) {
            $transaction->update($validated);
        }
        return $transaction;
    }

    public function destroy($id)
    {
        $Transaction = Packing::findOrFail($id);
        if ($Transaction) {
            $Transaction->delete();

        }
    }


    public function getdata($request)
    {
        $data = Packing::select('*')->orderBy('id', 'desc');
        return Datatables::of($data)->addIndexColumn()
            ->addColumn('action', function ($row) {
                $btn = ' <form  method="POST" onsubmit="return confirm(' . "'Are you sure you want to Delete this?'" . ');"  action="' . route("admin.packing.destroy", $row->id) . '"> ';
                $btn = $btn . '<a href=" ' . route("admin.packing.show", $row->id) . '"  class="ml-2"><i class="fas fa-eye"></i></a>';
                $btn = $btn . ' <a href="' . route("admin.packing.edit", $row->id) . '" class="ml-2">  <i class="fas fa-edit"></i></a>';
                $btn = $btn . '<button  type="submit" class="ml-2" ><i class="fas fa-trash"></i></button>';
                $btn = $btn . method_field('DELETE') . '' . csrf_field();
                $btn = $btn . ' </form>';
                return $btn;
            })
            ->rawColumns(['action'])
            ->make(true);

    }

    public function getdata_good_issuance($request)
    {
        $data = GoodsIssuance::select('*')->orderBy('id', 'desc');
        return Datatables::of($data)->addIndexColumn()
            ->addColumn('action', function ($row) {
                $btn = '';
//                $btn = ' <form  method="POST" onsubmit="return confirm(' . "'Are you sure you want to Delete this?'" . ');"  action="' . route("admin.batches.destroy", $row->id) . '"> ';
////                $btn = $btn . '<a href=" ' . route("admin.batches.show", $row->id) . '"  class="ml-2"><i class="fas fa-eye"></i></a>';
////                $btn = $btn . ' <a href="' . route("admin.batches.edit", $row->id) . '" class="ml-2">  <i class="fas fa-edit"></i></a>';
//                $btn = $btn . '<button  type="submit" class="ml-2" ><i class="fas fa-trash"></i></button>';
//                $btn = $btn . method_field('DELETE') . '' . csrf_field();
//                $btn = $btn . ' </form>';
//                return $btn;
                $btn = $btn . '<a href=" ' . route("admin.goods-issuance.pdf", $row->id) . '"  class="ml-2"><i class="fas fa-file-pdf"></i></a>';

                return $btn;
            })->addColumn('status', function ($row) {
                $badgeClass = match ($row->status) {
                    'in_process' => 'bg-warning',
                    'packaging' => 'bg-primary',
                    'completed' => 'bg-success',
                    'dispatched_for_warehouse' => 'bg-info',
                    default => 'bg-secondary',
                };
                return '<span class="badge ' . $badgeClass . '">' . ucfirst(str_replace('_', ' ', $row->status)) . '</span>';

            })
            ->rawColumns(['action', 'status'])
            ->make(true);

    }


    public function generatePDF($id)
    {
        $g = GoodsIssuance::with('batch.batchDetails', 'batch.Formulation')->find($id);

        if (!$g) {
            abort(404, 'Goods Issuance not found');
        }

        $process = Processe::find($g->process_id);

        $processViews = [
            1 => 'Mixing',
            2 => 'Heating',
            3 => 'Cooling',
            4 => 'Packaging',
            5 => 'Storage',
        ];

        if (!isset($processViews[$g->process_id])) {
            abort(404, 'Invalid process ID');
        }
        return view("admin.goods-issuance.Pdf.test");
        return view("admin.goods-issuance.Pdf.test");
//        return view("admin.goods-issuance.Pdf.{$processViews[$g->process_id]}", compact('id', 'g', 'process'));
    }


    public function getdata_issuance($request)
    {
        $batch = Batch::where('id', $request->id)->with('batchDetails', 'Formulation.formulationDetail')->first();
        $raw = $this->Raw();
        $users = $this->getusers();
        $process = $this->getprocess();
        $units = $this->units();

        return view('admin.goods-issuance.data', compact('batch', 'units', 'raw', 'users', 'process'));

    }
}
