<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Bilty;
use App\Models\SalesOrder;
use App\Services\BiltyServices;
use Illuminate\Http\Request;

class BiltyController extends Controller
{
    protected $biltyService;

    public function __construct(BiltyServices $biltyService)
    {
        $this->biltyService = $biltyService;
    }

    public function index()
    {
        $invoices = SalesOrder::all();
        return view ('admin.bilties.index',compact('invoices'));
    }

    public function create()
    {
        $invoices = SalesOrder::all();
        return view ('admin.bilties.create',compact('invoices'));

    }

    public function store(Request $request)
    {
        $request->validate([
            'goods_name' => 'nullable|string',
            'place' => 'nullable|string',
            'bilty_no' => 'nullable|string',
            'bilty_date' => 'nullable|date',
            'courier_date' => 'nullable|date',
            'receipt_no' => 'nullable|string',
            'cartons' => 'nullable|integer',
            'fare' => 'nullable|numeric',
            'invoice_ids' => 'nullable|array'
        ]);

        $this->biltyService->store($request);

        return redirect()->route('admin.bilties.index')->with('success', 'Bilty created successfully.');
    }

    public function update(Request $request, Bilty $bilty)
    {
        $request->validate([
            'goods_name' => 'nullable|string',
            'place' => 'nullable|string',
            'bilty_no' => 'nullable|string',
            'bilty_date' => 'nullable|date',
            'courier_date' => 'nullable|date',
            'receipt_no' => 'nullable|string',
            'cartons' => 'nullable|integer',
            'fare' => 'nullable|numeric',
            'invoice_ids' => 'nullable|array'
        ]);

        $this->biltyService->update($request, $bilty);

        return redirect()->route('admin.bilties.index')->with('success', 'Bilty updated successfully.');
    }

    public function edit(Bilty $bilty)
    {
        $invoices = SalesOrder::all();
        $selectedInvoiceIds = $bilty->salesOrders()->pluck('id')->toArray();

        return view('admin.bilties.edit', compact('bilty', 'invoices', 'selectedInvoiceIds'));
    }


    public function destroy(Bilty $bilty)
    {
        $this->biltyService->delete($bilty);

        return redirect()->route('admin.bilties.index')->with('success', 'Bilty deleted.');
    }

    public function getdata(Request $request)
    {
        return $this->biltyService->getdata($request);
    }
}
