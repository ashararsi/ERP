<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Processe;
use Illuminate\Http\Request;
use App\Models\Batch;
use App\Models\GoodsIssuance;
use Illuminate\Support\Facades\Auth;
use App\Services\BatchServices;
use App\Services\FormulationServices;


class GoodsIssuanceController extends Controller
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
        return view('admin.goods-issuance.index');

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $batches = Batch::all();
        $processes = Processe::all();
        $users = $this->BatchServices->getusers();
        return view('admin.goods-issuance.create', compact('batches', 'processes', 'users'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $data = $request->all();
        $data['issued_date'] = date('Y-m-d');
        $data['issued_by'] = Auth::user()->id;
        GoodsIssuance::create($data);
        return redirect()->route('admin.goods-issuance.index');
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
        return $this->BatchServices->getdata_good_issuance($request);
    }

    public function generatePDF($id)
    {
        return $this->BatchServices->generatePDF($request);
    }

    public function get_data(Request $request)
    {
        return $this->BatchServices->getdata_issuance($request);
    }
}
