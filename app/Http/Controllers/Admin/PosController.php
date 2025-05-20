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

        return view('admin.pos.index');
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
        //
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
    public function destroy(string $id)
    {
        //
    }

    public function getdata(Request $request)
    {

        return $this->PosServices->getdata($request);
    }
   public function pdf(Request $request,$id)
    {

        return $this->PosServices->pdf($request,$id);
    }

    public function getPayments($id)
    {
        $response = $this->PosServices->getPaymentsBySaleOrderId($id);
        return response()->json($response);
    }

}

