<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Models\SalesOrder;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function create($orderId)
    {
        $sale = SalesOrder::with(['customer.spo', 'items.product','items.batch','salesRep'])->where('id', $orderId)->first();
        // dd($sale);
        return view('admin.payments.create', compact('sale'));
    }


    public function store(Request $request)
    {
        // dd($request->all());
        $request->validate([
            'sales_order_id' => 'required|exists:sales_orders,id',
            'amount' => 'required|numeric|min:0.01',
            'payment_date' => 'required|date',
        ]);

        $sale = SalesOrder::with('customer')->findOrFail($request->sales_order_id);

        $sale = SalesOrder::with('customer', 'payments')->findOrFail($request->sales_order_id);

        $payment = Payment::create([
            'sales_order_id' => $sale->id,
            'customer_id' => $sale->customer->id,
            'amount' => $request->amount,
            'payment_date' => $request->payment_date,
        ]);

        $totalPaid = $sale->payments->sum('amount') + $payment->amount;

        if ($totalPaid >= $sale->net_total) {
            $sale->update(['status' => 'paid']);
        }

        return redirect()->route('admin.pos.index')->with('success', 'Payment added successfully.');
    }
}
