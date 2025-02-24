<?php

namespace App\Services;

use Config;
use App\Models\Pages;
use DataTables;

class PageServices
{

    public function index()
    {

    }

    public function apiResponce($status = 1, $method = 'POST', $message = '', $data = [])
    {
        $response = [
            'status' => $status,
            'method' => $method,
            'message' => $message,
            'response' => $data
        ];
        return $response;
    }

    public function about()
    {
        return Pages::where('name', 'About')->first();
    }

    public function contect()
    {
        return Pages::where('name', 'Contect')->first();
    }


    public function getdata()
    {
//        return DataTables::of(Permission::query())->make(true);
        $data = Pages::orderBy('id', 'desc');
        return Datatables::of($data)->addIndexColumn()
            ->addColumn('action', function ($row) {
                $btn = ' <form  method="POST" onsubmit="return confirm(' . "'Are you sure you want to Delete this?'" . ');"  action="' . route("admin.pages.destroy", $row->id) . '"> ';
                $btn = $btn . '<a href=" ' . route("admin.pages.show", $row->id) . '"  class="ml-2"><i class="fas fa-eye"></i></a>';
                $btn = $btn . ' <a href="' . route("admin.pages.edit", $row->id) . '" class="ml-2">  <i class="fas fa-edit"></i></a>';
               // $btn = $btn . '<button  type="submit" class="ml-2" ><i class="fas fa-trash"></i></button>';
                $btn = $btn . method_field('DELETE') . '' . csrf_field();
                $btn = $btn . ' </form>';
                return $btn;
            })
            ->rawColumns(['action'])
            ->make(true);
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
            $destinationPath = 'dist/pages';
            $file->move($destinationPath, $fileNameToStore);
            $data['image'] = $destinationPath . '/' . $fileNameToStore;;
        }

        Pages::create($data);
    }

    public function edit($id)
    {
        return Pages::findOrFail($id);
    }

    public function update($request, $id)
    {
        $Page = Pages::find($id);
        $Page->name = $request->name;
        $Page->meta_title = $request->meta_title;
        $Page->meta_description = $request->meta_description;
        $Page->description = $request->description;
//        $Page->text = $request->text;

        if ($request->hasfile('image')) {
            $file = $request->file('image');
            $filenameWithExt = $file->getClientOriginalName();
            $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
            $filename = preg_replace("/[^A-Za-z0-9 ]/", '', $filename);
            $filename = preg_replace("/\s+/", '-', $filename);
            $extension = $file->getClientOriginalExtension();
            $fileNameToStore = $filename . '_' . time() . '.' . $extension;
            $destinationPath = 'dist/pages';
            $file->move($destinationPath, $fileNameToStore);
            $Page->image = $destinationPath . '/' . $fileNameToStore;;
        }
        $Page->save();
    }

    public function destroy($id)
    {
        $Page = Pages::findOrFail($id);
        if ($Page)
            $Page->delete();

    }
}
