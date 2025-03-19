<?php

namespace App\Services;

use App\Models\Country;

use DataTables;

use Config;

class CountryServices
{
    public function create()
    {

    }

    public function index($request)
    {
        $perPage = $request->get('per_page', 20);
        $posts = Country::orderBy('created_at', 'desc')->paginate($perPage);
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

    public function store($request)
    {
        $data = $request->all();
//        $data['parent_id'] = ($request->parent_id == 0) ? null : $request->parent_id;
        return Country::create($data);

    }

    public function edit($id)
    {
        return Country::findOrFail($id);

    }

    public function update($request, $id)
    {
        $validated = $request->all();
        $transaction = Country::find($id);
        if ($transaction) {
            $transaction->update($validated);
        }
        return $transaction;
    }

    public function destroy($id)
    {
        $Transaction = Country::findOrFail($id);
        if ($Transaction) {
            $Transaction->delete();
        }
    }


    public function getdata($request)
    {
        $data = Country::select('*')->orderBy('id', 'desc');
        return Datatables::of($data)->addIndexColumn()
            ->addColumn('action', function ($row) {
                $btn = ' <form  method="POST" onsubmit="return confirm(' . "'Are you sure you want to Delete this?'" . ');"  action="' . route("admin.country.destroy", $row->id) . '"> ';
                $btn = $btn . '<a href=" ' . route("admin.country.show", $row->id) . '"  class="ml-2"><i class="fas fa-eye"></i></a>';
                $btn = $btn . ' <a href="' . route("admin.country.edit", $row->id) . '" class="ml-2">  <i class="fas fa-edit"></i></a>';
                $btn = $btn . '<button  type="submit" class="ml-2" ><i class="fas fa-trash"></i></button>';
                $btn = $btn . method_field('DELETE') . '' . csrf_field();
                $btn = $btn . ' </form>';
                return $btn;
            })
            ->rawColumns(['action'])
            ->make(true);

    }
}
