<?php

namespace App\Services;

use App\Models\Formulations;
use App\Models\HrmLeaveTypes;
use App\Models\Batche;
use App\Models\Processe;
use App\Models\Unit;
use App\Models\User;

use App\Models\RawMaterials;
use DataTables;

use Config;
use Illuminate\Support\Facades\Auth;

class LeaveTypeServices
{
    public function create()
    {
        return HrmLeaveTypes::all();

    }


    public function store($request)
    {
        $data = $request->all();

        $data['updated_by'] = \auth()->id();



        $f = HrmLeaveTypes::create($data);



    }

    public function edit($id)
    {
        return HrmLeaveTypes::where('id', $id)->first();

    }

    public function update($request, $id)
    {
        $validated = $request->all();
        $transaction = HrmLeaveTypes::find($id);
        if ($transaction) {
            $transaction->update($validated);
        }
        return $transaction;
    }

    public function destroy($id)
    {
        $Transaction = HrmLeaveTypes::findOrFail($id);
        if ($Transaction) {
            $Transaction->delete();

        }
    }


    public function getdata($request)
    {
        $data = HrmLeaveTypes::select('*')->orderBy('id', 'desc');
        return Datatables::of($data)->addIndexColumn()
            ->addColumn('action', function ($row) {
                $btn = ' <form  method="POST" onsubmit="return confirm(' . "'Are you sure you want to Delete this?'" . ');"  action="' . route("admin.hrm-leave-types.destroy", $row->id) . '"> ';
                $btn = $btn . '<a href=" ' . route("admin.hrm-leave-types.show", $row->id) . '"  class="ml-2"><i class="fas fa-eye"></i></a>';
                $btn = $btn . ' <a href="' . route("admin.hrm-leave-types.edit", $row->id) . '" class="ml-2">  <i class="fas fa-edit"></i></a>';
                $btn = $btn . '<button  type="submit" class="ml-2" ><i class="fas fa-trash"></i></button>';
                $btn = $btn . method_field('DELETE') . '' . csrf_field();
                $btn = $btn . ' </form>';
                return $btn;
            })
            ->rawColumns(['action'])
            ->make(true);

    }
}
