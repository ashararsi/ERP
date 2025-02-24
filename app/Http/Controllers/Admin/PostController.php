<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\PostService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use gernalHelper;
class PostController extends Controller
{


    public function __construct(PostService $postService)
    {
        $this->post_service = $postService;

    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request )
    {
        return $this->post_service->web_index($request);
    }

    public function active($id)
    {
        $this->post_service->active($id);
        gernalHelper::logAction('Post', 'Publish', 'Post Publish successfully');
          return redirect()->route('admin.posts.index')->with('success', 'Post Publish successfully!');

    }

    public function deactive($id)
    {
         $this->post_service->deactive($id);
        gernalHelper::logAction('Post', 'UnPublish', 'Post UnPublish successfully');
         return redirect()->route('admin.posts.index')->with('success', 'Post UnPublish successfully!');

    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return $this->post_service->create();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $validator = Validator::make($request->all(), [

            'post_title' => 'required|max:255',
            'slug' => 'required|unique:posts,slug',
            'post_detail1' => 'required',
            'post_detail2' => 'required',
            'meta_title' => 'max:255',
            'meta_description' => 'max:255',

        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        $this->post_service->store($request);
        gernalHelper::logAction('Post', 'save', 'Post save successfully');
        return redirect()->route('admin.posts.index')->with('success', 'Post created successfully!');

    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        return $this->post_service->edit($id);

    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'category_id' => 'required',
            'post_title' => 'required|max:255',
            'post_detail1' => 'required',
            'image_alt_text' => 'max:255',
            'meta_title' => 'max:255',
            'meta_description' => 'max:255',
            'tags' => 'nullable|max:255',
            'keywords' => 'nullable|max:255',

        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        $this->post_service->update($request, $id);
        gernalHelper::logAction('Post', 'update', 'Post upate successfully');
        return redirect()->route('admin.posts.index')->with('success', 'Post update successfully!');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->post_service->destroy($id);
        gernalHelper::logAction('Post', 'delete', 'Post delete successfully');
        return redirect()->route('admin.posts.index')->with('success', 'Post delete successfully!');

    }

    public function getData(Request $request)
    {
        return $this->post_service->getdata();
    }

}
