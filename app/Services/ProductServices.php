<?php

namespace App\Services;

use App\Imports\ProductImport;
use App\Models\Packing;
use App\Models\Product;

use App\Models\Unit;
use App\Models\User;

use App\Models\RawMaterials;
use DataTables;

use Config;
use Maatwebsite\Excel\Facades\Excel;

class ProductServices
{
    public function create()
    {
        return Unit::all();
    }
    public function packing()
    {
        return Packing::all();
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

    public function index($request)
    {
        $perPage = $request->get('per_page', 20);
        $posts = Product::orderBy('created_at', 'desc')->paginate($perPage);
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
//        $data['parent_id'] = ($request->parent_id == 0) ? null : $request->parent_id;
        return Product::create($data);

    }

    public function edit($id)
    {
        return Product::findOrFail($id);

    }

    public function update($request,$id)
    {
        $product = Product::findOrFail($id);

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '_' . $image->getClientOriginalName();
            $image->move(public_path('uploads/products'), $imageName);
            $product->image = 'uploads/products/' . $imageName;
        }

        $product->update([
            'name' => $request->name,
            'product_code' => $request->product_code,
            'unit_id' => $request->unit_id,
            'quantity' => $request->quantity,
            'price' => $request->price,
            'packing_id' => $request->packing_id,
            'description' => $request->description,
        ]);

        return $product;
    }


    public function destroy($id)
    {
        $product = Product::findOrFail($id);
        // dd($product);
        if ($product) {
            $product->delete();
        }
    }


    public function getdata($request)
    {
        $data = Product::select('*')->orderBy('id', 'desc');
        return Datatables::of($data)->addIndexColumn()
            ->addColumn('action', function ($row) {
                $btn = ' <form  method="POST" onsubmit="return confirm(' . "'Are you sure you want to Delete this?'" . ');"  action="' . route("admin.products.destroy", $row->id) . '"> ';
                $btn = $btn . '<a href=" ' . route("admin.products.show", $row->id) . '"  class="ml-2"><i class="fas fa-eye"></i></a>';
                $btn = $btn . ' <a href="' . route("admin.products.edit", $row->id) . '" class="ml-2">  <i class="fas fa-edit"></i></a>';
                $btn = $btn . '<button  type="submit" class="ml-2" ><i class="fas fa-trash"></i></button>';
                $btn = $btn . method_field('DELETE') . '' . csrf_field();
                $btn = $btn . ' </form>';
                return $btn;
            })->addColumn('image', function ($row) {

                return '<img src="' . asset($row->image) . '" border="0" width="40" class="img-rounded" align="center" />';
            })
            ->rawColumns(['action','image'])
            ->make(true);

    }

    public function importdata($request)
    {
        return Excel::import(new ProductImport(), $request->file('excel_file')); 
    }
}
