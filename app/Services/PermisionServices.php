<?php

namespace App\Services;

use Config;
use Spatie\Permission\Models\Permission;
use DataTables;

class PermisionServices
{

    public function index()
    {
        $data = Permission::select('id', 'name')->get();
    }

    public function apiindex()
    {
        return Permission::all();
    }

    public function create()
    {
        return Permission::where('main', 1)->get();
    }

    public function getdata()
    {
//        return DataTables::of(Permission::query())->make(true);
        $data = Permission::select('id', 'name', 'main')->orderBy('id', 'desc');
        return Datatables::of($data)->addIndexColumn()
            ->addColumn('main', function ($row) {
                $btn = ($row->main == 1) ? 'Main' : "-";

                return $btn;
            })
            ->rawColumns(['main'])
            ->addColumn('action', function ($row) {
                $btn = ' <form  method="POST" onsubmit="return confirm(' . "'Are you sure you want to Delete this?'" . ');"  action="' . route("admin.permissions.destroy", $row->id) . '"> ';
                $btn = $btn . '<a href=" ' . route("admin.permissions.show", $row->id) . '"  class="ml-2"><i class="fas fa-eye"></i></a>';
                $btn = $btn . ' <a href="' . route("admin.permissions.edit", $row->id) . '" class="ml-2">  <i class="fas fa-edit"></i></a>';
                $btn = $btn . '<button  type="submit" class="ml-2" ><i class="fas fa-trash"></i></button>';
                $btn = $btn . method_field('DELETE') . '' . csrf_field();
                $btn = $btn . ' </form>';
                return $btn;
            })
            ->rawColumns(['action'])
            ->make(true);
    }

    public function store($request)
    {

        $parrent_id = $request->parrent ?? 0;
        $main = ($request->main == "main") ? 1 : 0;
        return Permission::create(['name' => $request->name, 'guard_name' => 'web', 'main' => $main, 'parrent_id' => $parrent_id]);

    }

    public function edit($id)
    {
        return Permission::findOrFail($id);
    }

    public function update($request, $id)
    {
        $Permission = Permission::find($id);
        $Permission->name = $request->name;
        $Permission->save();
        return $Permission;

    }

    public function destroy($id)
    {
        $Permission = Permission::findOrFail($id);
        if ($Permission)
            $Permission->delete();

    }
}
