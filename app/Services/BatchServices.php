<?php

namespace App\Services;

use App\Models\Batch;
use App\Models\BatchDetail;
use App\Models\Batch as Batche;
use App\Models\GoodsIssuance;
use App\Models\Processe;
use App\Models\Unit;
use App\Models\User;

use App\Models\RawMaterials;
use DataTables;

use Config;

class BatchServices
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


    public function Raw()
    {
        return RawMaterials::all();

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
        $posts = Batche::orderBy('created_at', 'desc')->paginate($perPage);
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
        $b = Batche::create($data);
        foreach ($data['items']['item_id'] as $key => $item) {
            $item_data = [
                'batch_id' => $b->id,
                'raw_material_id' => $data['items']['item_id'][$key],
                'operator_initials' => $data['items']['operator_ids'][$key],
                'actual_quantity' => $data['items']['actual_quantity'][$key],
                'qa_initials' => $data['items']['qa_initials'][$key],
                'in_charge' => $data['items']['in_charge'][$key],
            ];
             BatchDetail::create($item_data);
        }
    }

    public function edit($id)
    {
        return Batche::findOrFail($id);
    }

    public function update($request, $id)
    {
        $validated = $request->all();
        $transaction = Batche::find($id);
        if ($transaction) {
            $transaction->update($validated);
        }
        return $transaction;
    }

    public function destroy($id)
    {
        $Transaction = Batche::findOrFail($id);
        if ($Transaction) {
            $Transaction->delete();
            BatchDetail::where('batch_id', $id)->delete();

        }
    }


    public function getdata($request)
    {
        $data = Batche::select('*')->orderBy('id', 'desc');
        return Datatables::of($data)->addIndexColumn()
            ->addColumn('action', function ($row) {
                $btn = ' <form  method="POST" onsubmit="return confirm(' . "'Are you sure you want to Delete this?'" . ');"  action="' . route("admin.batches.destroy", $row->id) . '"> ';
//                $btn = $btn . '<a href=" ' . route("admin.batches.show", $row->id) . '"  class="ml-2"><i class="fas fa-eye"></i></a>';
//                $btn = $btn . ' <a href="' . route("admin.batches.edit", $row->id) . '" class="ml-2">  <i class="fas fa-edit"></i></a>';
                $btn = $btn . '<button  type="submit" class="ml-2" ><i class="fas fa-trash"></i></button>';
                $btn = $btn . method_field('DELETE') . '' . csrf_field();
                $btn = $btn . ' </form>';
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
        $batch = Batche::where('id', $request->id)->with('batchDetails', 'Formulation.formulationDetail')->first();
        $raw = $this->Raw();
        $users = $this->getusers();
        $process = $this->getprocess();
        $units = $this->units();

        return view('admin.goods-issuance.data', compact('batch', 'units', 'raw', 'users', 'process'));

    }
}
