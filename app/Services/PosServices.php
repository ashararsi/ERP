<?php

namespace App\Services;
use PDF;
use App\Models\Batch;
use App\Models\BatchDetail;
use App\Models\Batch as Batche;
use App\Models\Customer;
use App\Models\GoodsIssuance;
use App\Models\Processe;
use App\Models\Product;
use App\Models\Unit;
use App\Models\User;
use App\Models\SalesOrder;
use App\Models\SalesOrderItem;
use DB;

use App\Models\RawMaterials;
use Carbon\Carbon;
use DataTables;

use Config;

class PosServices
{
    public function create()
    {
        $data['customers'] = Customer::all();

        return $data;
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

    public function products()
    {

        return Product::with('packing.units')->get();


    }

    public function Batches()
    {
        return Batch::orderBy('created_at', 'desc')->get();


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
        $posts = Batch::orderBy('created_at', 'desc')->paginate($perPage);
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

        try {
            // @dd($request->all());
            // Create the sales order
            $salesOrder = SalesOrder::create([
                'order_number' => $request->sOrdNo,
                'order_date' => $request->sOrdDate,
                'customer_id' => $request->customer_id,
                'customer_po_no' => $request->customerPO,
                'customer_po_date' => $request->customerPODate,
                'city' => $request->city,
                'payment_terms' => $request->paymentTerms,
                'sales_rep_id' => $request->salesRep ?? 3,
                'delivery_date' => $request->deliveryDate,
                'sub_total' => $request->subTotal,
                'total_discount' => $request->totalDiscount,
                'total_tax' => $request->totalTax,
                'advance_tax' => $request->advanceTax,
                'further_sale_tax' => $request->furtherSalesTax,
                'net_total' => $request->netTotal,
                'notes' => $request->notes,
                'status' => 'pending',
                'total_sale_tax' => $request->salesTax,
            ]);

                     

            // Add order items
            foreach ($request->product as $index => $productId) {
                SalesOrderItem::create([
                    'sales_order_id' => $salesOrder->id,
                    'product_id' => $productId,
                    'batch_id' => $request->batch[$index],
                    'expiry_date' => $request->expiry[$index],
                    'quantity' => $request->qty[$index],
                    'rate' => $request->rate[$index],
                    'amount' => $request->amount[$index],
                    'discount_percent' => $request->discPercent[$index],
                    'discount_amount' => $request->discAmt[$index],
                    'tax_percent' => $request->taxPercent[$index],
                    'tax_amount' => $request->taxAmt[$index],
                    'net_amount' => $request->netAmt[$index],
                    'trade_discount' => $request->trade_discount[$index],
                    'special_discount' => $request->special_discount[$index],
                    'scheme_discount' => $request->scheme_discount[$index],
                    'tp_amount' => $request->tpAmt[$index],
                    'includedAmt' => $request->includedAmt[$index],
                ]);
            }

            DB::commit();

            return "done";

        } catch (\Exception $e) {
            DB::rollBack();
            dd($e->getMessage());
            return back()->withInput()->with('error', 'Error creating sales order: ' . $e->getMessage());
        }
    }

    public function edit($id)
    {
        return Batch::findOrFail($id);
    }

    public function update($request, $id)
    {
        $validated = $request->all();
        $transaction = Batch::find($id);
        if ($transaction) {
            $transaction->update($validated);
        }
        return $transaction;
    }

    public function destroy($id)
    {
        $Transaction = Batch::findOrFail($id);
        if ($Transaction) {
            $Transaction->delete();
            BatchDetail::where('batch_id', $id)->delete();

        }
    }

    public function pdf($request, $id)
    {
      
        $sale = SalesOrder::with(['customer', 'items.product','items.batch','salesRep'])->where('id', $id)->first();
        $pdf = Pdf::loadView('admin.pos.invoice', compact('sale'));
    //    return view('admin.pos.invoice', compact('sale'));
    // return $pdf->stream('pos_Report_'.$id.'.pdf');
return $pdf->download('pos_Report_'.$id.'.pdf');
//        return view('admin.pos.invoice', compact('sale'));

    }

    public function getdata($request)
    {
        $orders = SalesOrder::with(['customer'])
            ->select([
                'sales_orders.*',
                DB::raw('(SELECT COUNT(*) FROM sales_order_items WHERE sales_order_items.sales_order_id = sales_orders.id) as items_count')
            ])
            ->orderBy('id', 'desc');

            if ($request->filled('start_date') && $request->filled('end_date')) {
                $start = Carbon::parse($request->start_date)->startOfDay();
                $end = Carbon::parse($request->end_date)->endOfDay();
                $orders->whereBetween('order_date', [$start, $end]);
            }
            
        return Datatables::of($orders)
            ->addIndexColumn()
            ->addColumn('order_number', function ($row) {
                return '<a href="' . route('admin.pos.show', $row->id) . '">' . $row->order_number . '</a>';
            })
            ->addColumn('order_date', function ($row) {
                return \Carbon\Carbon::parse($row->order_date)->format('d M Y');
            })
            ->addColumn('customer', function ($row) {
                return $row->customer ? $row->customer->name : 'N/A';
            })
            ->addColumn('items_count', function ($row) {
                return $row->items_count;
            })
            ->addColumn('net_total', function ($row) {
                return '₹' . number_format($row->net_total, 2);
            })
            ->addColumn('status', function ($row) {
                $statusClass = '';
                switch ($row->status) {
                    case 'completed':
                        $statusClass = 'status-completed';
                        break;
                    case 'cancelled':
                        $statusClass = 'status-cancelled';
                        break;
                    default:
                        $statusClass = 'status-pending';
                }
                return '<span class="' . $statusClass . '">' . ucfirst($row->status) . '</span>';
            })
            ->addColumn('action', function ($row) {
//                $btn = '<div class="">';
//                $btn .= '<form method="POST" action="' . route('admin.pos.destroy', $row->id) . '">';
//                $btn .= '<a href="' . route('admin.pos.show', $row->id) . '" class="btn     " title="View"><i class="fas fa-eye"></i></a>';
//                $btn .= '<a href="' . route('admin.pos.edit', $row->id) . '" class="btn   " title="Edit"><i class="fas fa-edit"></i></a>';
//                $btn .= '<a href="' . route('admin.pos.pdf', $row->id) . '" class="btn    " title="pdf"><i class="fas fa-print"></i></a>';
//                $btn .= csrf_field();
//                $btn .= method_field('DELETE');
//                $btn .= '<button type="submit" class="" title="Delete" onclick="return confirm(\'Are you sure you want to delete this order?\')"><i class="fas fa-trash"></i></button>';
//                $btn .= '</form>';
//                $btn .= '</div>';
//                return $btn;


                $btn = ' <form  method="POST" onsubmit="return confirm(' . "'Are you sure you want to Delete this?'" . ');"  action="' . route("admin.pos.destroy", $row->id) . '"> ';
                $btn = $btn . '<a href=" ' . route("admin.pos.show", $row->id) . '"  class="ml-2"><i class="fas fa-eye"></i></a>';
                $btn = $btn . ' <a href="' . route("admin.pos.edit", $row->id) . '" class="ml-2 mr-2">  <i class="fas fa-edit"></i></a>';
                $btn = $btn . ' <a href="' . route("admin.pos.pdf", $row->id) . '" class="ml-2 mr-2">  <i class="fas fa-print"></i></a>';
//                $btn = $btn . '<button  type="submit" class="ml-2 mr-2" ><i class="fas fa-trash"></i></button>';
                $btn = $btn . method_field('DELETE') . '' . csrf_field();
                $btn = $btn . ' </form>';
                return $btn;

            })
            ->rawColumns(['order_number', 'status', 'action'])
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
