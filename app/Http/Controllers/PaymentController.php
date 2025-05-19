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
        $request->validate([
            'sales_order_id' => 'required|exists:sales_orders,id',
            'amount' => 'required|numeric|min:0.01',
            'payment_date' => 'required|date',
        ]);

        $sale = SalesOrder::with('customer', 'payments')->findOrFail($request->sales_order_id);

        $alreadyPaid = $sale->payments->sum('amount');
        $newPaymentAmount = $request->amount;
        $remainingAmount = max($sale->net_total - ($alreadyPaid + $newPaymentAmount), 0);

        $payment = Payment::create([
            'sales_order_id' => $sale->id,
            'customer_id' => $sale->customer->id,
            'amount' => $newPaymentAmount,
            'payment_date' => $request->payment_date,
            'remaining_amount' => $remainingAmount,
        ]);

        if (($alreadyPaid + $newPaymentAmount) >= $sale->net_total) {
            $sale->update(['status' => 'paid']);
        }

        return redirect()->route('admin.pos.index')->with('success', 'Payment added successfully.');
    }
}
