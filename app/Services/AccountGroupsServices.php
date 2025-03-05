<?php

namespace App\Services;

use App\Models\Branch;
use App\Models\Company;
use App\Models\Supplier;
use App\Models\AccountGroup;
use App\Models\Groups;
use DataTables;

use App\Helpers\CoreAccounts;
use App\Helpers\GroupsTree;
use Auth;

use Config;

class AccountGroupsServices
{
    public function index()
    {
        $parentGroups = new GroupsTree();
        $parentGroups->current_id = -1;
        $parentGroups->build(0);

        $parentGroups->toListView($parentGroups, -1);

         return $parentGroups->groupListView;
        return view('accounts.groups.index', compact('Groups'));
    }

    public function create()
    {

        $parentGroups = new GroupsTree();
        $parentGroups->current_id = -1;
        $parentGroups->build(0);

        $parentGroups->toListView($parentGroups, -1);

         return $parentGroups->groupListView;

    }

    public function suptlier_get()
    {
        return Supplier::all();
    }

    public function store($request)
    {
       return CoreAccounts::createGroup($request->all());


    }

    public function edit($id)
    {
        return Branch::findOrFail($id);

    }

    public function update($request, $id)
    {
        $validated = $request->all();
        $transaction = Company::find($id);
        if ($transaction) {
            $transaction->update($validated);
        }
        return $transaction;
    }

    public function destroy($id)
    {
        $Transaction = Branch::findOrFail($id);
        if ($Transaction) {
            $Transaction->delete();
        }
    }


    public function getdata($request)
    {
        $data = Branch::with('company')->select('*')->orderBy('id', 'desc');
        return Datatables::of($data)->addIndexColumn()
            ->addColumn('company', function ($row) {
                $btn =   $row->company->name ?? 'N/A';

                return $btn;
            })->addColumn('action', function ($row) {
                $btn = ' <form  method="POST" onsubmit="return confirm(' . "'Are you sure you want to Delete this?'" . ');"  action="' . route("admin.branches.destroy", $row->id) . '"> ';
                $btn = $btn . '<a href=" ' . route("admin.branches.show", $row->id) . '"  class="ml-2"><i class="fas fa-eye"></i></a>';
                $btn = $btn . ' <a href="' . route("admin.branches.edit", $row->id) . '" class="ml-2">  <i class="fas fa-edit"></i></a>';
                $btn = $btn . '<button  type="submit" class="ml-2" ><i class="fas fa-trash"></i></button>';
                $btn = $btn . method_field('DELETE') . '' . csrf_field();
                $btn = $btn . ' </form>';
                return $btn;
            })
            ->rawColumns(['action'])
            ->make(true);

    }
}
