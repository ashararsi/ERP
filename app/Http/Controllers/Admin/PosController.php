<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use App\Models\SalesOrder;
use App\Services\PosServices;
use Carbon\Carbon;
use Illuminate\Http\Request;

class PosController extends Controller
{

    public function __construct(PosServices $PosServices)
    {
        $this->PosServices = $PosServices;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // $id = 5;
        // return $this->PosServices->pdf($request,$id);
        $salesPersons = $this->PosServices->getSalesPersons();
        return view('admin.pos.index',compact('salesPersons'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $data = $this->PosServices->create();
        $users = $this->PosServices->getusers();
        $products = $this->PosServices->products();
        $Batches = $this->PosServices->Batches();
        return view('admin.pos.create', compact('data', 'users', 'products','Batches'));

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
        
            $this->PosServices->store($request);
            return redirect()->route('admin.pos.index');
        } catch (\Exception $e) {
            dd($e->getMessage());
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $data = $this->PosServices->create();
        $users = $this->PosServices->getusers();
        $products = $this->PosServices->products();
        $Batches = $this->PosServices->Batches();
        $sale = SalesOrder::with('items')->find($id);
        $saleItems = $sale->items->map(function ($item) {
            return [
                'productId' => $item->product_id,
                'batchId' => $item->batch_id,
                'expiry' => $item->expiry_date,
                'qty' => $item->quantity,
                'rate' => $item->rate,
                'discPercent' => $item->discount_percent,
                'taxPercent' => $item->tax_percent,
                'tradeDiscount' => $item->trade_discount,
                'specialDiscount' => $item->special_discount,
                'schemeDiscount' => $item->scheme_discount,
                'taxAmt' => $item->tax_amount,
                'netAmt' => $item->net_amount,
                'tpAmt' => $item->tp_amount,
                'excludedAmt' => $item->excluded_amount,
                'includedAmt' => $item->included_amount,
            ];
        })->toArray();
        return view('admin.pos.edit', compact('data', 'users', 'products','Batches','sale','saleItems'));

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            $this->PosServices->delete($id);
            return redirect()->route('admin.pos.index')->with('success', 'Invoice deleted successfully.');
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    public function getdata(Request $request)
    {

        return $this->PosServices->getdata($request);
    }
   public function pdf(Request $request,$id)
    {

        return $this->PosServices->pdf($request,$id);
    }

    public function orderPdf(Request $request,$id)
    {

        return $this->PosServices->orderPdf($request,$id);
    }

    public function getPayments($id)
    {
        $response = $this->PosServices->getPaymentsBySaleOrderId($id);
        return response()->json($response);
    }

}

