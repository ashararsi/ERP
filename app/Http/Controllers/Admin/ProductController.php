<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Packing;
use App\Models\Product;
use App\Models\Unit;
use App\Services\ProductServices;
use Illuminate\Http\Request;

class ProductController extends Controller
{

    protected $ProductServices;
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
        $product = Product::findOrFail($id);
        $units = Unit::all();
        $packing = Packing::all(); 
    
        return view('admin.product.view', compact('product', 'units', 'packing'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $product = Product::findOrFail($id);
        $units = Unit::all();
        $packing = Packing::all(); 
    
        return view('admin.product.edit', compact('product', 'units', 'packing'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try {
            // dd($request->all());
            $this->ProductServices->update($request,$id);
            return redirect()->route('admin.products.index');
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

            $raw = $this->ProductServices->destroy($id);
            return redirect()->route('admin.products.index');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function getdata(Request $request)
    {
        return $this->ProductServices->getdata($request);
    }

    public function showImport()
    {
        // dd(2);
        return view('admin.product.import');
    }

    public function importProductData(Request $request)
    {
         $this->ProductServices->importdata($request);
         return redirect()->route('admin.products.index')->with('success', 'Data created successfully');
    }
}
