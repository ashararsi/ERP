<?php

namespace App\Http\Controllers\Admin;
use PDF;
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
        return view('admin.good-receipt.index');

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
       $data= $this->GoodReceiptNoteServices->create();
        return view('admin.good-receipt.create',compact('data'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $this->GoodReceiptNoteServices->store($request);
            return redirect()->route('admin.grns.index');
        } catch (\Exception $e) {

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
        return $this->GoodReceiptNoteServices->getdata($request);
    }
    public function fetch_po_record(Request $request)
    {
        return $this->GoodReceiptNoteServices->fetch_po_record($request);

    }
    public function generatePDF($id)
    {
        $grn = $this->GoodReceiptNoteServices->edit($id);

        $pdf = Pdf::loadView('admin.good-receipt.report_pdf', compact('grn'));
        return $pdf->download('GRN_Report_'.$id.'.pdf');
    }

}
