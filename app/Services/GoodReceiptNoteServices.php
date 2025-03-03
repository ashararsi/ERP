<?php

namespace App\Services;

use App\Models\RawMaterials;
use App\Models\Supplier;
use App\Models\Unit;
use App\Models\PurchaseOrder;
use App\Models\PurchaseOrderItem;
use DataTables;

use Config;

class PurchaseOrderServices
{
    public function index($request)
    {
        $perPage = $request->get('per_page', 20);
        $posts = PurchaseOrder::orderBy('created_at', 'desc')->paginate($perPage);
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

    public function create()
    {
        $data['units'] = Unit::all();
        $data['Supplier'] = Supplier::all();
        $data['RawMaterials'] = RawMaterials::all();
        return $data;
    }

    public function suptlier_get()
    {
        return Supplier::all();
    }

    public function store($request)
    {
        $data = $request->all();
        $total = 0;
        $p = PurchaseOrder::create($data);

        foreach ($request->items['raw_material_id'] as $key => $item) {
            $data1 = [
                'raw_material_id' => $request->items['raw_material_id'][$key],
                'quantity' => $request->items['quantity'][$key],
                'unit_id' => $request->items['unit_id'][$key],
                'unit_price' => $request->items['unit_price'][$key],
                'subtotal' => $request->items['subtotal'][$key],
                'purchase_order_id' => $p->id
            ];

            $total = $total + $request->items['subtotal'][$key];
            PurchaseOrderItem::create($data1);
        }
        $p->total_amount = $total;
        $p->save();
        return $p;


    }

    public function edit($id)
    {
        return PurchaseOrder::with('items')->where('id', $id)->first();

    }

    public function update($request, $id)
    {
        $data = $request->all();
        $total = 0;
        $p = PurchaseOrder::find($id);
        $p->update($data);

        foreach ($request->items['raw_material_id'] as $key => $item) {
            $data1 = [
                'raw_material_id' => $request->items['raw_material_id'][$key],
                'quantity' => $request->items['quantity'][$key],
                'unit_id' => $request->items['unit_id'][$key],
                'unit_price' => $request->items['unit_price'][$key],
                'subtotal' => $request->items['subtotal'][$key],
                'purchase_order_id' => $p->id
            ];
            $total = $total + $request->items['subtotal'][$key];
            PurchaseOrderItem::create($data1);
        }
        $p->total_amount = $total;
        $p->save();
        return $p;
    }

    public function destroy($id)
    {
        $Transaction = PurchaseOrder::findOrFail($id);
        if ($Transaction) {

            $Transaction->delete();
            PurchaseOrderItem::where('purchase_order_id', $id)->delete();

        }
    }


    public function getdata($request)
    {
        $data = PurchaseOrder::select('*')->orderBy('id', 'desc');
        return Datatables::of($data)->addIndexColumn()
            ->addColumn('action', function ($row) {
                $btn = ' <form  method="POST" onsubmit="return confirm(' . "'Are you sure you want to Delete this?'" . ');"  action="' . route("admin.purchaseorders.destroy", $row->id) . '"> ';
                $btn = $btn . '<a href=" ' . route("admin.purchaseorders.show", $row->id) . '"  class="ml-2"><i class="fas fa-eye"></i></a>';
                $btn = $btn . ' <a href="' . route("admin.purchaseorders.edit", $row->id) . '" class="ml-2">  <i class="fas fa-edit"></i></a>';
                $btn = $btn . '<button  type="submit" class="ml-2" ><i class="fas fa-trash"></i></button>';
                $btn = $btn . method_field('DELETE') . '' . csrf_field();
                $btn = $btn . ' </form>';
                return $btn;
            })
            ->rawColumns(['action'])
            ->make(true);

    }
}
