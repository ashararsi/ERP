<?php

namespace App\Services;

use App\Models\Formulations;
use App\Models\FormulationDetail;
use App\Models\Batche;
use App\Models\Processe;
use App\Models\User;

use App\Models\RawMaterials;
use DataTables;

use Config;

class ProcessesServices
{
    public function create()
    {
        return Processe::all();
    }

    public function getusers()
    {
        $suppliers = User::whereHas('roles', function ($query) {
            $query->where('name', 'supplier');
        })->get();


        $qaUsers = User::whereHas('roles', function ($query) {
            $query->where('name', 'QA');
        })->get();
        return ['suppliers' => $suppliers, 'qaUsers' => $qaUsers];
    }
    public function getprocess()
    {
      return  $suppliers = Processe::get();
    }

    public function index($request)
    {
        $perPage = $request->get('per_page', 20);
        $posts = Processe::orderBy('created_at', 'desc')->paginate($perPage);
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
        if ($request->hasfile('image')) {
            $file = $request->file('image');
            $filenameWithExt = $file->getClientOriginalName();
            $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
            $filename = preg_replace("/[^A-Za-z0-9 ]/", '', $filename);
            $filename = preg_replace("/\s+/", '-', $filename);
            $extension = $file->getClientOriginalExtension();
            $fileNameToStore = $filename . '_' . time() . '.' . $extension;
            $destinationPath = 'dist/processes';
            $file->move($destinationPath, $fileNameToStore);
            $data['image'] = $destinationPath . '/' . $fileNameToStore;
        }

        Processe::create($data);




    }

    public function edit($id)
    {
        return Processe::where('id', $id)->first();

    }

    public function update($request, $id)
    {
        $validated = $request->all();
        $transaction = Processe::find($id);
        if ($request->hasfile('image')) {
            $file = $request->file('image');
            $filenameWithExt = $file->getClientOriginalName();
            $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
            $filename = preg_replace("/[^A-Za-z0-9 ]/", '', $filename);
            $filename = preg_replace("/\s+/", '-', $filename);
            $extension = $file->getClientOriginalExtension();
            $fileNameToStore = $filename . '_' . time() . '.' . $extension;
            $destinationPath = 'dist/processes';
            $file->move($destinationPath, $fileNameToStore);
            $validated['image'] = $destinationPath . '/' . $fileNameToStore;
        }
        if ($transaction) {
            $transaction->update($validated);

        }
        return $transaction;
    }

    public function destroy($id)
    {
        $Transaction = Processe::findOrFail($id);
        if ($Transaction) {
            $Transaction->delete();

        }
    }


    public function getdata($request)
    {
        $data = Processe::select('*')->orderBy('id', 'desc');
        return Datatables::of($data)->addIndexColumn()
            ->addColumn('action', function ($row) {
                $btn = ' <form  method="POST" onsubmit="return confirm(' . "'Are you sure you want to Delete this?'" . ');"  action="' . route("admin.processes.destroy", $row->id) . '"> ';
                $btn = $btn . '<a href=" ' . route("admin.processes.show", $row->id) . '"  class="ml-2"><i class="fas fa-eye"></i></a>';
                $btn = $btn . ' <a href="' . route("admin.processes.edit", $row->id) . '" class="ml-2">  <i class="fas fa-edit"></i></a>';
                $btn = $btn . '<button  type="submit" class="ml-2" ><i class="fas fa-trash"></i></button>';
                $btn = $btn . method_field('DELETE') . '' . csrf_field();
                $btn = $btn . ' </form>';
                return $btn;
            })
            ->rawColumns(['action'])
            ->make(true);

    }
}
