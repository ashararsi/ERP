<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Area;
use App\Models\City;
use App\Models\Customer;
use App\Models\User;
use App\Services\CustomerServise;
use Illuminate\Http\Request;


class CustomerController extends Controller
{

    public function __construct(CustomerServise $CustomerServise)
    {
        $this->CustomerServise = $CustomerServise;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('admin.customers.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $cities = City::all();
        $spos = User::role('SPO')->get();
        return view('admin.customers.create', compact('spos','cities'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
//        try {
        $this->CustomerServise->store($request);
        return redirect()->route('admin.customers.index');
//        } catch (\Exception $e) {
//
//            return redirect()->back()->with('error', $e->getMessage());
//        }
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
        try {
            $spos = User::role('SPO')->get();
            $customer = $this->CustomerServise->edit($id);
            $cities = City::all();

            $areas = Area::where('city_id', $customer->city_id)->get();

            return view('admin.customers.edit', compact('customer', 'spos','areas','cities'));
        } catch (\Exception $exception) {
            return redirect()->route('admin.customers.index');
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {

//        try {
        $customer = $this->CustomerServise->update($request, $id);
        return redirect()->route('admin.customers.index');
//        }catch (\Exception $exception){
//            return redirect()->route('admin.customers.index');
//        }
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
        return $this->CustomerServise->getdata($request);

    }

    public function getCustomerData(Request $request)
    {

        return $this->CustomerServise->getCustomerData($request);
    }

    public function showImport()
    {

        $data = User::with('roles')
            ->select('id', 'email', 'name')
            ->orderBy('id', 'desc')
            ->whereHas('roles', function ($query) {
                $query->where('name', 'Spo');
            })->get();


        return view('admin.customers.import', compact('data'));
    }

    public function importCustomerData(Request $request)
    {

        $this->CustomerServise->importdata($request);
        return redirect()->route('admin.customers.index')->with('success', 'Data created successfully');
    }
}
