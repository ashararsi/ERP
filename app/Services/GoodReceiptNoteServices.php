<?php

namespace App\Services;

use App\Models\GoodReceiptNote;
use App\Models\GoodReceiptNoteItem;
use App\Models\InventoryRawMaterial;
use App\Models\RawMaterials;
use App\Models\Supplier;
use App\Models\Unit;
use App\Models\PurchaseOrder;
use App\Models\PurchaseOrderItem;
use DataTables;

use Config;

class GoodReceiptNoteServices
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

    public function fetch_po_record($request)
    {
        $data = $this->create();
        $p = PurchaseOrder::with('items', 'supplier')->where('id', $request->id)->first();

        return view('admin.good-receipt.purchaseorder', compact('p', 'data'));
    }

    public function create()
    {
        $data['units'] = Unit::all();
        $data['Supplier'] = Supplier::all();
        $data['RawMaterials'] = RawMaterials::all();
        $data['po'] = PurchaseOrder::all();
        return $data;
    }

    public function suptlier_get()
    {
        return Supplier::all();
    }

    public function store($request)
    {
        $data = $request->all();
        $data['received_by']=auth()->id();
        $p = GoodReceiptNote::create($data);
        $id = $p->id;
        PurchaseOrder::find($request->purchase_order_id)->update(['status' => 'approved']);


        foreach ($data['items'] as $key => $item) {
            $item_p = PurchaseOrderItem::find($key);

            $data1 = [
                'product_id' => $item_p->raw_material_id,
                'quantity_received' => $item_p->quantity,
                'unit_id' => $item_p->unit_id,
                'unit_price' => $item_p->unit_price,
                'subtotal' => $item_p->subtotal,
                'good_receipt_note_id' => $id
            ];
            GoodReceiptNoteItem::create($data1);

         $old=   InventoryRawMaterial::where('product_id',$item_p->raw_material_id)->first();
            if($old){
                $to_update= InventoryRawMaterial::where('product_id',$item_p->raw_material_id)->first();
                $to_update->quantity_available = $old->quantity + $item_p->quantity;
                $to_update->unit_price = $old->unit_price + $item_p->unit_price;
                $to_update->save();
            }else{
                $data_inv=[
                    'product_id'=>$item_p->raw_material_id,
                    'quantity_available'=>$item_p->quantity,
                    'unit_price'=>$item_p->unit_price,
                    'unit_of_measurement'=>$item_p->unit_id,
                ];
                InventoryRawMaterial::create($data_inv);
            }





        }

        return $p;


    }

    public function edit($id)
    {
        return GoodReceiptNote::with('purchaseOrder','items.p_items.RawMaterial','user')->where('id', $id)->first();

    }

    public function update($request, $id)
    {
        $data = $request->all();
        $total = 0;
        $p = GoodReceiptNote::find($id);
        $data['receipt_date'] = now();
        $data['received_by']=auth()->id();
        $p->update($data);
        GoodReceiptNoteItem::where('good_receipt_note_id', $id)->delete();
        foreach ($data['items'] as $key => $item) {
            $item_p = PurchaseOrderItem::find($key);

            $data1 = [
                'product_id' => $key,
                'quantity_received' => $item_p->quantity,
                'unit_id' => $item_p->unit_id,
                'unit_price' => $item_p->unit_price,
                'subtotal' => $item_p->subtotal,
                'good_receipt_note_id' => $id
            ];
            GoodReceiptNoteItem::create($data1);
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
        $data = GoodReceiptNote::select('*')->orderBy('id', 'desc');
        return Datatables::of($data)->addIndexColumn()
            ->addColumn('action', function ($row) {
//                $btn = ' <form  method="POST" onsubmit="return confirm(' . "'Are you sure you want to Delete this?'" . ');"  action="' . route("admin.grns.destroy", $row->id) . '"> ';
//                $btn = $btn . '<a href=" ' . route("admin.grns.show", $row->id) . '"  class="ml-2"><i class="fas fa-eye"></i></a>';
////                $btn = $btn . ' <a href="' . route("admin.grns.edit", $row->id) . '" class="ml-2">  <i class="fas fa-edit"></i></a>';
//                $btn = $btn . '<button  type="submit" class="ml-2" ><i class="fas fa-trash"></i></button>';
//                $btn = $btn . method_field('DELETE') . '' . csrf_field();
//                $btn = $btn . ' </form>';


              $btn = '<a href=" ' . route("admin.grn.pdf", $row->id) . '"  class="ml-2"><i class="fas fa-print"></i></a>';

                return $btn;
            })
            ->rawColumns(['action'])
            ->make(true);

    }
}
