<?php

namespace App\Services;

use App\Models\Post;

use App\Models\PostCategory;
use Config;

use DataTables;
use Illuminate\Support\Str;
use Laravel\Ui\Tests\AuthBackend\AuthenticatesUsersTest;

class PostService
{

    public function create()
    {

        return view('admin.post.create');
    }

    public function web_index()
    {
        return view('admin.post.index');
    }
    public function index(Request $request)
    {
        $perPage = $request->get('per_page', 20);
        $posts = Post::orderBy('created_at', 'desc')->paginate($perPage);
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
        if ($request->hasfile('image_banner')) {
            $file = $request->file('image_banner');
            $filenameWithExt = $file->getClientOriginalName();
            $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
            $filename = preg_replace("/[^A-Za-z0-9 ]/", '', $filename);
            $filename = preg_replace("/\s+/", '-', $filename);
            $extension = $file->getClientOriginalExtension();
            $fileNameToStore = $filename . '_' . time() . '.' . $extension;
            $destinationPath = 'dist/post';
            $file->move($destinationPath, $fileNameToStore);
            $data['image_banner'] = $destinationPath . '/' . $fileNameToStore;
        }

        if ($request->hasfile('small_image')) {
            $file = $request->file('small_image');
            $filenameWithExt = $file->getClientOriginalName();
            $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
            $filename = preg_replace("/[^A-Za-z0-9 ]/", '', $filename);
            $filename = preg_replace("/\s+/", '-', $filename);
            $extension = $file->getClientOriginalExtension();
            $fileNameToStore = $filename . '_' . time() . '.' . $extension;
            $destinationPath = 'dist/post';
            $file->move($destinationPath, $fileNameToStore);
            $data['small_image'] = $destinationPath . '/' . $fileNameToStore;
        }
        $data['user_id'] = auth()->id();
        $data['slug'] = Str::slug($request->slug);
        return Post::create($data);
    }

    public function edit($id)
    {
        return $post = Post::findOrFail($id);

    }

    public function update($request, $id)
    {
        $data = $request->all();
        if ($request->hasfile('image_banner')) {
            $file = $request->file('image_banner');
            $filenameWithExt = $file->getClientOriginalName();
            $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
            $filename = preg_replace("/[^A-Za-z0-9 ]/", '', $filename);
            $filename = preg_replace("/\s+/", '-', $filename);
            $extension = $file->getClientOriginalExtension();
            $fileNameToStore = $filename . '_' . time() . '.' . $extension;
            $destinationPath = 'dist/post';
            $file->move($destinationPath, $fileNameToStore);
            $data['image_banner'] = $destinationPath . '/' . $fileNameToStore;
        }
        if ($request->hasfile('small_image')) {
            $file = $request->file('small_image');
            $filenameWithExt = $file->getClientOriginalName();
            $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
            $filename = preg_replace("/[^A-Za-z0-9 ]/", '', $filename);
            $filename = preg_replace("/\s+/", '-', $filename);
            $extension = $file->getClientOriginalExtension();
            $fileNameToStore = $filename . '_' . time() . '.' . $extension;
            $destinationPath = 'dist/post';
            $file->move($destinationPath, $fileNameToStore);
            $data['small_image'] = $destinationPath . '/' . $fileNameToStore;
        }
        $data['user_id'] = auth()->id();
        return Post::find($id)->update($data);
    }

    public function destroy($id)
    {
        $post = Post::findOrFail($id);
        if ($post) {
            $post->delete();
        }
    }
    public function getdata()
    {

        $data = Post::with('user')->orderBy('id', 'desc');
        return Datatables::of($data)->addIndexColumn()
            ->addColumn('user', function ($row) {
                return $row->user->name;
            })
            ->addColumn('status', function ($row) {
                return ($row->status==1) ?  'Publish':'Draft';
            })->addColumn('publish', function ($row) {
                $btn = ' ';
                if($row->status==0){
                    $btn = $btn . ' <a href="' . route("admin.posts.publish", $row->id) . '" class="ml-2"><i class="fas fa-toggle-off"></i> </a>';
                }
                else
                {
                    $btn = $btn . ' <a href="' . route("admin.posts.unpublish", $row->id) . '" class="ml-2"> <i class="fas fa-toggle-on"></i> </a>';
                }
                return $btn;
            })
            ->addColumn('action', function ($row) {
                $btn = ' <form  method="POST" onsubmit="return confirm(' . "'Are you sure you want to Delete this?'" . ');"  action="' . route("admin.posts.destroy", $row->id) . '"> ';
                $btn = $btn . '<a href=" ' . route("admin.posts.show", $row->id) . '"  class="ml-2"><i class="fas fa-eye"></i></a>';
                $btn = $btn . ' <a href="' . route("admin.posts.edit", $row->id) . '" class="ml-2">  <i class="fas fa-edit"></i></a>';
                $btn = $btn . '<button  style="border:none;" type="submit" class="ml-2" ><i class="fas fa-trash"></i></button>';
                $btn = $btn . method_field('DELETE') . '' . csrf_field();
                $btn = $btn . ' </form>';
                return $btn;
            })
            ->rawColumns(['action','publish'])
            ->make(true);
    }

}
