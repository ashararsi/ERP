<?php

namespace App\Services;

use App\Models\Formulations;
use App\Models\WorkWeeks;
use App\Models\Batche;
use App\Models\Processe;
use App\Models\Unit;
use App\Models\User;

use App\Models\RawMaterials;
use DataTables;

use Config;
use Illuminate\Support\Facades\Auth;

class WorkWeekServices
{
    public function create()
    {
        return WorkWeeks::all();

    }


    public function store($request)
    {
        $data = $request->all();

        $data['updated_by'] = \auth()->id();



        $f = WorkWeeks::create($data);



    }

    public function edit($id)
    {
        return WorkWeeks::where('id', $id)->first();

    }

    public function update($request, $id)
    {
        $validated = $request->all();
        $transaction = WorkWeeks::find($id);
        if ($transaction) {
            $transaction->update($validated);
        }
        return $transaction;
    }

    public function destroy($id)
    {
        $Transaction = WorkWeeks::findOrFail($id);
        if ($Transaction) {
            $Transaction->delete();

        }
    }


    public function getdata($request)
    {
        $data = WorkWeeks::select('*')->orderBy('id', 'desc');
        return Datatables::of($data)->addIndexColumn()
            ->addColumn('action', function ($row) {
                $btn = ' <form  method="POST" onsubmit="return confirm(' . "'Are you sure you want to Delete this?'" . ');"  action="' . route("admin.work-weeks.destroy", $row->id) . '"> ';
                $btn = $btn . '<a href=" ' . route("admin.work-weeks.show", $row->id) . '"  class="ml-2"><i class="fas fa-eye"></i></a>';
                $btn = $btn . ' <a href="' . route("admin.work-weeks.edit", $row->id) . '" class="ml-2">  <i class="fas fa-edit"></i></a>';
                $btn = $btn . '<button  type="submit" class="ml-2" ><i class="fas fa-trash"></i></button>';
                $btn = $btn . method_field('DELETE') . '' . csrf_field();
                $btn = $btn . ' </form>';
                return $btn;
            })
            ->rawColumns(['action'])
            ->make(true);

    }
}
