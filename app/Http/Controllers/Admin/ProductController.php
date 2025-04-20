<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\ProductServices;
use Illuminate\Http\Request;

class ProductController extends Controller
{


    public function __construct(ProductServices $ProductServices)
    {
        $this->ProductServices = $ProductServices;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('admin.product.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $units = $this->ProductServices->create();
        $packing = $this->ProductServices->packing();
        return view('admin.product.create', compact('units','packing'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $this->ProductServices->store($request);
            return redirect()->route('admin.products.index');
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
        return $this->ProductServices->getdata($request);
    }
}
