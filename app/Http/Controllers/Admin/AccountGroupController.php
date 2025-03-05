<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\AccountGroupsServices;
use Illuminate\Http\Request;

class AccountGroupController extends Controller
{
    public function __construct(AccountGroupsServices $AccountGroupsServices)
    {
        $this->AccountGroupsServices = $AccountGroupsServices;
    }


    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $Groups = $this->AccountGroupsServices->index();
        return view('admin.accountgroup.index', compact('Groups'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $groups = $this->AccountGroupsServices->create();
        return view('admin.accountgroup.create', compact('groups'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $this->AccountGroupsServices->store($request);
            if ($response['status']) {
                return redirect()->route('admin.account_groups.index')->with('success', 'New Groups SuccessFully!');
            }
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
        return $this->AccountGroupsServices->getdata($request);
    }
}
