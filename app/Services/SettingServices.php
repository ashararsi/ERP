<?php

namespace App\Services;

use Config;
use App\Models\Settings;
use DataTables;

class SettingServices
{

    public function index()
    {

    }

    public function create()
    {

    }

    public function store($request)
    {

        $Settings = $request->all();
        $fileNameToStore = null;
        if ($request->hasfile('icons')) {
            $file = $request->file('icons');
            $filenameWithExt = $file->getClientOriginalName();
            $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
            $filename = preg_replace("/[^A-Za-z0-9 ]/", '', $filename);
            $filename = preg_replace("/\s+/", '-', $filename);
            $extension = $file->getClientOriginalExtension();
            $fileNameToStore = $filename . '_' . time() . '.' . $extension;
            $destinationPath = 'dist/Settingss';
            $file->move($destinationPath, $fileNameToStore);
            $Settings['icons'] = $destinationPath . '/' . $fileNameToStore;
        }
        if ($request->hasfile('image')) {
            $file = $request->file('image');
            $filenameWithExt = $file->getClientOriginalName();
            $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
            $filename = preg_replace("/[^A-Za-z0-9 ]/", '', $filename);
            $filename = preg_replace("/\s+/", '-', $filename);
            $extension = $file->getClientOriginalExtension();
            $fileNameToStore = $filename . '_' . time() . '.' . $extension;
            $destinationPath = 'dist/settings/image';
            $file->move($destinationPath, $fileNameToStore);
            $Settings['image'] = $destinationPath . '/' . $fileNameToStore;
        }


        $Settings = Settings::create($Settings);
    }

    public function getdata()
    {
        $data = Settings::get();
        return Datatables::of($data)->addIndexColumn()
            ->addColumn('action', function ($row) {
                $btn = ' <form  method="POST" onsubmit="return confirm(' . "'Are you sure you want to Delete this?'" . ');"  action="' . route("admin.settings.destroy", $row->id) . '"> ';
                $btn = $btn . '<a href=" ' . route("admin.settings.show", $row->id) . '"  class="ml-2"><i class="fas fa-eye"></i></a>';
                $btn = $btn . ' <a href="' . route("admin.settings.edit", $row->id) . '" class="ml-2">  <i class="fas fa-edit"></i></a>';
                $btn = $btn . '<button  type="submit" class="ml-2" ><i class="fas fa-trash"></i></button>';
                $btn = $btn . method_field('DELETE') . '' . csrf_field();
                $btn = $btn . ' </form>';
                return $btn;
            })
            ->rawColumns(['action'])
            ->make(true);
    }

    public function edit($id)
    {
        return Settings::find($id);
    }


    public function update($request, $id)
    {
//        dd($id);
        $Settings = Settings::find($id);
        if ($Settings) {
            $Settings->title = $request->title;
            $Settings->long_description = $request->long_description;
            $Settings->text = $request->text;
            $Settings->type = $request->type;
            $fileNameToStore = null;
            if ($request->hasfile('icons')) {
                $file = $request->file('icons');
                $filenameWithExt = $file->getClientOriginalName();
                $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
                $filename = preg_replace("/[^A-Za-z0-9 ]/", '', $filename);
                $filename = preg_replace("/\s+/", '-', $filename);
                $extension = $file->getClientOriginalExtension();
                $fileNameToStore = $filename . '_' . time() . '.' . $extension;
                $destinationPath = 'dist/Settingss';
                $file->move($destinationPath, $fileNameToStore);
                $Settings->icons = $destinationPath . '/' . $fileNameToStore;
            }
            $Settings->save();
        }
    }

    public function destroy($id)
    {
        $Settings = Settings::findOrFail($id);
        if ($Settings)
            $Settings->delete();
    }
}
