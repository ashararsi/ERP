<?php

namespace App\Services;

use App\Models\Formulations;
use App\Models\HrmLeaveEntitlement;
use App\Models\HrmLeaveTypes;
use App\Models\Staff;
use App\Models\Batche;
use App\Models\Processe;
use App\Models\Unit;
use App\Models\User;

use App\Models\RawMaterials;
use DataTables;

use Config;
use Illuminate\Support\Facades\Auth;

class HrmLeaveEntitlementServices
{
    public function create()
    {
        $data['HrmLeaveTypes'] = HrmLeaveTypes::all();
        $data['Staff'] = Staff::all();
        return $data;

    }


    public function store($request)
    {
        $data = $request->all();

        $data['updated_by'] = \auth()->id();


        $f = HrmLeaveEntitlement::create($data);


    }

    public function edit($id)
    {
        return HrmLeaveEntitlement::where('id', $id)->first();

    }

    public function update($request, $id)
    {
        $validated = $request->all();
        $transaction = HrmLeaveEntitlement::find($id);
        if ($transaction) {
            $transaction->update($validated);
        }
        return $transaction;
    }

    public function destroy($id)
    {
        $Transaction = HrmLeaveEntitlement::findOrFail($id);
        if ($Transaction) {
            $Transaction->delete();

        }
    }


    public function getdata($request)
    {
        $data = HrmLeaveEntitlement::with('employee', 'LeaveType')->select('*')->orderBy('id', 'desc');
        return Datatables::of($data)->addIndexColumn()
            ->addColumn('employee', function ($row) {
                if( $row->employee)
                return $row->employee->first_name." ".$row->employee->last_name;
            }) ->addColumn('leave_type', function ($row) {
                if( $row->LeaveType)
                return $row->LeaveType->name;
            })->addColumn('action', function ($row) {
                $btn = ' <form  method="POST" onsubmit="return confirm(' . "'Are you sure you want to Delete this?'" . ');"  action="' . route("admin.leave-entitlement.destroy", $row->id) . '"> ';
                $btn = $btn . '<a href=" ' . route("admin.leave-entitlement.show", $row->id) . '"  class="ml-2"><i class="fas fa-eye"></i></a>';
                $btn = $btn . ' <a href="' . route("admin.leave-entitlement.edit", $row->id) . '" class="ml-2">  <i class="fas fa-edit"></i></a>';
                $btn = $btn . '<button  type="submit" class="ml-2" ><i class="fas fa-trash"></i></button>';
                $btn = $btn . method_field('DELETE') . '' . csrf_field();
                $btn = $btn . ' </form>';
                return $btn;
            })
            ->rawColumns(['action'])
            ->make(true);

    }
}
