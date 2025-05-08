<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\PurchaseOrderServices;
use Illuminate\Http\Request;
use PDF;
class PurchaseOrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    public function __construct(PurchaseOrderServices $PurchaseOrderServices)
    {
        $this->PurchaseOrderServices = $PurchaseOrderServices;
    }


    public function index()
    {
        return view('admin.purchase-order.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $data = $this->PurchaseOrderServices->create();

        return view('admin.purchase-order.create', compact('data'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $this->PurchaseOrderServices->store($request);
            return redirect()->route('admin.purchaseorders.index');
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
        $data = $this->PurchaseOrderServices->create();
        $p = $this->PurchaseOrderServices->edit($id);
        if ($p) {
            return view('admin.purchase-order.view', compact('data', 'p'));

        } else {
            return redirect()->route('admin.purchaseorders.index');
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $data = $this->PurchaseOrderServices->create();
        $p = $this->PurchaseOrderServices->edit($id);
        if ($p) {
            return view('admin.purchase-order.edit', compact('data', 'p'));

        } else {
            return redirect()->route('admin.purchaseorders.index');
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try {
            $this->PurchaseOrderServices->update($request, $id);
            return redirect()->route('admin.purchaseorders.index');
        } catch (\Exception $e) {
            dd($e->getMessage());
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $this->PurchaseOrderServices->destroy($id);
            return redirect()->route('admin.purchaseorders.index');
        } catch (\Exception $e) {
            dd($e->getMessage());
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function getdata(Request $request)
    {
        return $this->PurchaseOrderServices->getdata($request);

    }


    public function generatePDF($id)
    {
        $p = $this->PurchaseOrderServices->edit($id);
        $pdf = Pdf::loadView('admin.purchase-order.report_pdf', compact('p'));
        return $pdf->download('po_Report_'.$id.'.pdf');
    }

}
