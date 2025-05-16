<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use PDF;


class RecoverySheetController extends Controller
{
    public function index()
    {
       
        $salesPersons =  User::with('roles')
        ->select('id', 'email', 'name')
        ->orderBy('id', 'desc')
        ->whereHas('roles', function ($query) {
            $query->where('name', 'Spo');
        })->get();;
        return view('admin.recovery_sheet.index', compact('salesPersons'));
    }

    public function generate(Request $request)
    {
        $start = Carbon::parse($request->start_date)->startOfDay();
        $end = Carbon::parse($request->end_date)->endOfDay();

        $customers = Customer::where('spo_id', $request->sales_person_id)
            ->with(['salesOrders' => function ($query) use ($start, $end) {
                $query->whereBetween('order_date', [$start, $end])->with('payments');
            }])
            ->get()
            ->filter(function ($customer) {
                return $customer->salesOrders->isNotEmpty();
            });

        $salesPerson = User::find($request->sales_person_id);

        $pdf = PDF::loadView('admin.recovery_sheet.pdf', compact('customers', 'salesPerson', 'start', 'end'));
        return $pdf->download('RecoverySheet_' . $salesPerson->name . '.pdf');
    }
}
