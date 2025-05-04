<?php


namespace App\Services;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Datatables;

class CategoryService
{
    public function getAll()
    {
        return Category::latest()->get();
    }

    public function store(Request $request)
    {
        return DB::transaction(function () use ($request) {
            return Category::create([
                'name' => $request->name,
                'status' => 'active',
            ]);
        });
    }

    public function find($id)
    {
        return Category::findOrFail($id);
    }

    public function update(Request $request, $id)
    {
        return DB::transaction(function () use ($request, $id) {
            $category = Category::findOrFail($id);
            $category->update([
                'name' => $request->name,
                'status' => $request->status ?? $category->status,
            ]);
            return $category;
        });
    }

    public function delete($id)
    {
        return DB::transaction(function () use ($id) {
            $category = Category::findOrFail($id);
            $category->delete();
        });
    }

    public function getdata($request)
    {
        $data = Category::select('*')->orderBy('id', 'desc');
        return Datatables::of($data)->addIndexColumn()
            ->addColumn('action', function ($row) {
                $btn = ' <form  method="POST" onsubmit="return confirm(' . "'Are you sure you want to Delete this?'" . ');"  action="' . route("admin.categories.destroy", $row->id) . '"> ';
                $btn = $btn . '<a href=" ' . route("admin.categories.show", $row->id) . '"  class="ml-2"><i class="fas fa-eye"></i></a>';
                $btn = $btn . ' <a href="' . route("admin.categories.edit", $row->id) . '" class="ml-2">  <i class="fas fa-edit"></i></a>';
                $btn = $btn . '<button  type="submit" class="ml-2" ><i class="fas fa-trash"></i></button>';
                $btn = $btn . method_field('DELETE') . '' . csrf_field();
                $btn = $btn . ' </form>';
                return $btn;
            })
            ->rawColumns(['action'])
            ->make(true);

    }
}
