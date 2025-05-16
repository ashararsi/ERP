<?php

namespace App\Services;

use App\Imports\CustomerImport;
use App\Models\Customer;

use Config;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Role;
use App\Models\User;
use App\Models\City;
use App\Models\Area;

use DataTables;

use PhpOffice\PhpSpreadsheet\RichText\RichText;
use PhpOffice\PhpSpreadsheet\IOFactory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Facades\Excel;

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

    public function getCustomerData($request)
    {
        $customer = Customer::with('spo')->findOrFail($request->customer_id);
        // dd($customer);
        return response()->json([
            'city_name' => $customer->city_name,
            'email' => $customer->email,
            'ntn' => $customer->ntn,
            'customer_code' => $customer->customer_code,
            'stn' => $customer->stn,
            'name' => $customer->name,
            'spo_name' => optional($customer->spo)->name,
        ]);
    }

    public function importdata($request)
    {
        $sale_man = $request->sale_man;
        // dd($sale_man);
        $file = $request->file('file');
        $path = $file->getRealPath();
        $spreadsheet = IOFactory::load($path);
        $worksheet = $spreadsheet->getActiveSheet();
        $isHeader = true;
        foreach ($worksheet->getRowIterator() as $row) {
            if ($isHeader) {
                $isHeader = false;
                continue;
            }
            $isEmptyRow = true;
            $data = [];
            foreach ($row->getCellIterator() as $cell) {
                $value = $cell->getValue();

                // Check if cell has value
                if (!is_null($value) && trim($value) !== '') {
                    $isEmptyRow = false;
                }

                // Handle RichText objects
                if ($value instanceof RichText) {
                    $value = $value->getPlainText();
                }

                $data[] = $value;
            }
            if ($isEmptyRow) {
                break;
            }
            $mapped = [
                'sr_no' => $data[0],
                'code' => $data[1],
                'name' => $data[2],
                'address' => $data[3],
                'ntn' => $data[4],
                'cnic' => $data[5],
                'salesman' => $data[6],
                'city' => $data[7],
                'area' => $data[8],
            ];

            // Create or get city
            $city = City::firstOrCreate(
                ['name' => trim($mapped['city'])],
                ['country_id' => 1, 'status' => 1]
            );

            // Create or get area
            $area = Area::firstOrCreate(
                ['name' => trim($mapped['area'])],
                ['company_id' => 1, 'status' => 1]
            );
            Customer::updateOrCreate(
                ['customer_code' => $mapped['code']],
                [
                    'name' => $mapped['name'],
                    'email' => null,
                    'phone' => null,
                    'address' => $mapped['address'],
                    'created_by' => auth()->id() ?? 1,
                    'agent_id' => null,
                    'status' => 1,
                    'cnic' => $mapped['cnic'],
                    'ntn' => $mapped['ntn'],
                    'city_name' => $city->name,
                    'area_id' => $area->id,
                    'stn' => null,
                    'spo_id' => $sale_man,
                ]
            );

        }
        return 0;
    }


}
