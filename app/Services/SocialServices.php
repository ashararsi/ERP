<?php

namespace App\Services;

use App\Models\SocailIcons;
use Config;
use DataTables;

class SocialServices
{


    public function getdata()
    {
//        return DataTables::of(Permission::query())->make(true);
        $data = SocailIcons::orderBy('id', 'desc');

        return Datatables::of($data)->addIndexColumn()
            ->addColumn('action', function ($row) {
                $btn = ' <form  method="POST" onsubmit="return confirm(' . "'Are you sure you want to Delete this?'" . ');"  action="' . route("admin.socials.destroy", $row->id) . '"> ';
                $btn = $btn . '<a href=" ' . route("admin.socials.show", $row->id) . '"  class="ml-2"><i class="fas fa-eye"></i></a>';
                $btn = $btn . ' <a href="' . route("admin.socials.edit", $row->id) . '" class="ml-2">  <i class="fas fa-edit"></i></a>';
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

        $data = $request->all();

        if ($request->hasfile('imgurl')) {
            $file = $request->file('imgurl');
            $filenameWithExt = $file->getClientOriginalName();
            $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
            $filename = preg_replace("/[^A-Za-z0-9 ]/", '', $filename);
            $filename = preg_replace("/\s+/", '-', $filename);
            $extension = $file->getClientOriginalExtension();
            $fileNameToStore = $filename . '_' . time() . '.' . $extension;
            $destinationPath = 'dist/all';
            $file->move($destinationPath, $fileNameToStore);
            $data['imgurl'] = 'dist/all' . $fileNameToStore;
        }


        return SocailIcons::create($data);

    }

    public function edit($id)
    {
        return SocailIcons::findOrFail($id);
    }

    public function update($request, $id)
    {
        $SocailIcons = SocailIcons::find($id);

        $data = $request->all();
        if ($request->hasfile('imgurl')) {
            $file = $request->file('imgurl');
            $filenameWithExt = $file->getClientOriginalName();
            $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
            $filename = preg_replace("/[^A-Za-z0-9 ]/", '', $filename);
            $filename = preg_replace("/\s+/", '-', $filename);
            $extension = $file->getClientOriginalExtension();
            $fileNameToStore = $filename . '_' . time() . '.' . $extension;
            $destinationPath = 'dist/all';
            $file->move($destinationPath, $fileNameToStore);
            $data['imgurl'] = $fileNameToStore;
        }

        return $SocailIcons->update($data);


    }

    public function destroy($id)
    {
        $SocailIcons = SocailIcons::findOrFail($id);
        if ($SocailIcons)
            $SocailIcons->delete();

    }


}
