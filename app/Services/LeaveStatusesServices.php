<?php

namespace App\Services;

use App\Models\Formulations;
use App\Models\HrmLeaveStatuses;
use App\Models\Batche;
use App\Models\Processe;
use App\Models\Unit;
use App\Models\User;

use App\Models\RawMaterials;
use DataTables;

use Config;
use Illuminate\Support\Facades\Auth;

class LeaveStatusesServices
{
    public function create()
    {
        return HrmLeaveStatuses::all();

    }


    public function store($request)
    {
        $data = $request->all();

        $data['updated_by'] = \auth()->id();



        $f = HrmLeaveStatuses::create($data);



    }

    public function edit($id)
    {
        return HrmLeaveStatuses::where('id', $id)->first();

    }

    public function update($request, $id)
    {
        $validated = $request->all();
        $transaction = HrmLeaveStatuses::find($id);
        if ($transaction) {
            $transaction->update($validated);
        }
        return $transaction;
    }

    public function destroy($id)
    {
        $Transaction = HrmLeaveStatuses::findOrFail($id);
        if ($Transaction) {
            $Transaction->delete();

        }
    }


    public function getdata($request)
    {
        $data = HrmLeaveStatuses::select('*')->orderBy('id', 'desc');
        return Datatables::of($data)->addIndexColumn()
            ->addColumn('action', function ($row) {
                $btn = ' <form  method="POST" onsubmit="return confirm(' . "'Are you sure you want to Delete this?'" . ');"  action="' . route("admin.hrm-leave-statuses.destroy", $row->id) . '"> ';
                $btn = $btn . '<a href=" ' . route("admin.hrm-leave-statuses.show", $row->id) . '"  class="ml-2"><i class="fas fa-eye"></i></a>';
                $btn = $btn . ' <a href="' . route("admin.hrm-leave-statuses.edit", $row->id) . '" class="ml-2">  <i class="fas fa-edit"></i></a>';
                $btn = $btn . '<button  type="submit" class="ml-2" ><i class="fas fa-trash"></i></button>';
                $btn = $btn . method_field('DELETE') . '' . csrf_field();
                $btn = $btn . ' </form>';
                return $btn;
            })
            ->rawColumns(['action'])
            ->make(true);

    }
}
