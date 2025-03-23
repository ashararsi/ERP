<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\GoodsReceipt;
use Illuminate\Http\Request;
use App\Models\Batch;
use App\Models\Processe;
use App\Services\BatchServices;
use App\Services\FormulationServices;
use App\Models\GoodsIssuance;

class GoodsReceiptController extends Controller
{

    public function __construct(BatchServices $BatchServices, FormulationServices $FormulationServices)
    {
        $this->BatchServices = $BatchServices;
        $this->FormulationServices = $FormulationServices; // Assign the service
    }


    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('admin.goods-receipt.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $goodsIssuance = GoodsIssuance::all();
        $batches = Batch::all();
        $processes = Processe::all();
        $users = $this->BatchServices->getusers();
        return view('admin.goods-receipt.create', compact('batches', 'processes', 'users', 'goodsIssuance'));

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->all();
        GoodsReceipt::create($data);
        dd($data);
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
}
