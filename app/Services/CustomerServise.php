<?php

namespace App\Services;


use App\Models\Customer;

use Config;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Role;
use App\Models\User;

use DataTables;

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;


class CustomerServise
{

    public function index($request)
    {
        $perPage = $request->get('per_page', 20);


        // Query the users who are not in the excluded list, ordered by creation date
        $users = Customer::orderBy('created_at', 'desc')
            ->paginate($perPage);
        return response()->json([
            'data' => $users->items(), // The current page's items
            'current_page' => $users->currentPage(),
            'last_page' => $users->lastPage(),
            'per_page' => $users->perPage(),
            'total' => $users->total(),
            'next_page_url' => $users->nextPageUrl(),
            'prev_page_url' => $users->previousPageUrl(),
        ]);
    }


    public function create()
    {

        return Role::all();
    }

    public function store($request)
    {
        $data = $request->all();

        $data['created_by'] = Auth::user()->id;

        if ($request->status == "Active") {
            $data['status'] = 1;
        } else {
            $data['status'] = 0;
        }

        $user = Customer::create($data);


    }


    public function user_data($slug)
    {

        return $user = Customer::where('slug', $slug)->first();

    }


    public function getdata($request)
    {

        $data = Customer::with('agent')->orderBy('id', 'desc');
        return Datatables::of($data)->addIndexColumn()
            ->addColumn('action', function ($row) {
                $a = $row->active;
                $admin = $row->is_admin;
                $btn = ' <form  method="POST" onsubmit="return confirm(' . "'Are you sure you want to Delete this?'" . ');"  action="' . route("admin.customers.destroy", $row->id) . '"> ';
                $btn = $btn . '<a href=" ' . route("admin.customers.show", $row->id) . '"  class="ml-2"><i class="fas fa-eye"></i></a>';
                $btn = $btn . ' <a href="' . route("admin.customers.edit", $row->id) . '" class="ml-2">  <i class="fas fa-edit"></i></a>';
                $btn = $btn . '<button  type="submit" class="ml-2" ><i class="fas fa-trash"></i></button>';
                $btn = $btn . method_field('DELETE') . '' . csrf_field();
                $btn = $btn . ' </form>';
                return $btn;
            })->addColumn('agent', function ($row) {

                $btn = null;
                if ($row->agent)
                    $btn = $row->agent->name;

                return $btn;
            })
            ->rawColumns(['action', 'status', 'email_verified_at'])
            ->make(true);
    }

    public function edit($id)
    {
        return Customer::where('id', $id)->first();


    }

    public function update($request, $id)
    {
        $data = $request->all();
        if ($request->status == "Active") {
            $data['status'] = 1;
        } else {
            $data['status'] = 0;
        }
        unset($data['_token']);
        unset($data['_method']);
//        $data['_token']

        Customer::where('id', $id)->update($data);

    }

    public function destroy($id)
    {
        $User = Customer::findOrFail($id);
        if ($User)
            $User->delete();

    }

    public function getCustomerData($request) {
        $customer = Customer::findOrFail($request->customer_id);
        // dd($customer);
        return response()->json([
            'city_name' => $customer->city_name,
            'email' => $customer->email,
            'ntn' => $customer->ntn,
            'customer_code' => $customer->customer_code,
            'stn' => $customer->stn,
            'name' => $customer->name
        ]);
    }
   

}
