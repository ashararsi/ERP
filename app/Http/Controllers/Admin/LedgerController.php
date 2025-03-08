<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Ledger;
use App\Services\LedgerServices;
use Illuminate\Http\Request;

class LedgerController extends Controller
{


    public function __construct(LedgerServices $LedgerServices)
    {
        $this->LedgerServices = $LedgerServices;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('admin.ledger.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $branches = $this->LedgerServices->getbranches();
        $groups = $this->LedgerServices->getgroups();
        return view('admin.ledger.create', compact('branches', 'groups'));

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
       try {
          $this->LedgerServices->store($request);

                return redirect()->route('admin.ledger.index')->with('success', 'New Groups SuccessFully!');

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
      $data=  $this->LedgerServices->edit($id);
      $ledger=$data['ledger'];
      $groups=$data['groups'];
      $branches=$data['branches'];
      $company=$data['company'];
        return view('admin.ledger.edit', compact('ledger', 'groups', 'branches', 'company'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try {
            $this->LedgerServices->update($request,$id);
            return redirect()->route('admin.ledger.index');
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
            $this->LedgerServices->destroy($id);
            return redirect()->route('admin.ledger.index');
        } catch (\Exception $e) {
            dd($e->getMessage());
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function ledger_already_created(Request $request)
    {
        $html = $this->LedgerServices->ledger_already_created($request);
        return $html;

    }

    public function load_ledgers(Request $request)
    {
        $data = Ledger::where(function ($query) use ($request) {

            if ($request['company_id'] != null && $request['company_id'] != "null") {
                $query->where('company_id', $request['company_id']);
            }
            if ($request['branch_id'] != null && $request['branch_id'] != "null") {
                $query->where('branch_id', $request['branch_id']);
            }
            if ($request['name'] != null && $request['name'] != "null") {
                $query->where('name', 'like', '%' . $request['name'] . '%');
            }
        })
            ->orderBy('number', 'asc')->get();

        return response()->json(['data' => $data]);
    }

}
