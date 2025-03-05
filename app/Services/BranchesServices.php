<?php

namespace App\Services;

use App\Models\Branch;
use App\Models\Company;
use App\Models\Supplier;
use App\Models\Unit;
use DataTables;

use Config;

class BranchesServices
{
    public function index($request)
    {
        $perPage = $request->get('per_page', 20);
        $posts = Company::orderBy('created_at', 'desc')->paginate($perPage);
        return response()->json([
            'data' => $posts->items(),
            'current_page' => $posts->currentPage(),
            'last_page' => $posts->lastPage(),
            'per_page' => $posts->perPage(),
            'total' => $posts->total(),
            'next_page_url' => $posts->nextPageUrl(),
            'prev_page_url' => $posts->previousPageUrl(),
        ]);
    }

    public function create()
    {
        return Company::all();
    }

    public function suptlier_get()
    {
        return Supplier::all();
    }

    public function store($request)
    {
        return Branch::create($request->all());

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


    public function getBranches($id)
    {
        return Branch::where('company_id', $id)->get();
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
