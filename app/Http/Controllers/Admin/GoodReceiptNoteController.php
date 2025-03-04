<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\GoodReceiptNoteServices;
use Illuminate\Http\Request;

class GoodReceiptNoteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function __construct(GoodReceiptNoteServices $GoodReceiptNoteServices)
    {
        $this->GoodReceiptNoteServices = $GoodReceiptNoteServices;
    }


    public function index(){
        return view('admin.good-recipit.index');

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
       $data= $this->GoodReceiptNoteServices->create();
        return view('admin.good-recipit.create',compact('data'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
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

    }
    public function fetch_po_record($id)
    {
        return $this->GoodReceiptNoteServices->fetch_po_record($id);

    }
}
