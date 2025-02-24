<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\PageServices;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Gate;

class PageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function __construct(PageServices $PageServices)
    {
        $this->PageServices = $PageServices;
    }

    public function index()
    {
//        if (!Gate::allows('Page_index')) {
//            return abort(503);
//        }
        return view('admin.pages.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
//        if (!Gate::allows('Page_create')) {
//            return abort(503);
//        }
        return view('admin.pages.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required',
            'description' => 'required',
        ]);
        $this->PageServices->store($request);
        Session::flash('flash_message_sucess', 'Page  Save Successfully!!!.');
        return redirect()->route('admin.pages.index');
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $this->PageServices->edit($id);

        return view('admin.pages.view');

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
//        if (!Gate::allows('Page_edit')) {
//            return abort(503);
//        }
        $page = $this->PageServices->edit($id);
        return view('admin.pages.edit', compact('page'));

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
//        $validated = $request->validate([
//            'name' => 'required',
//            'descripiton' => 'required',
//        ]);
        $page = $this->PageServices->update($request,$id);

        Session::flash('flash_message_sucess', 'Page  Update Successfully!!!.');
        return redirect()->route('admin.pages.index');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
//        if (!Gate::allows('Page_Delete')) {
//            return abort(503);
//        }
        $this->PageServices->destroy($id);
        Session::flash('flash_message_sucess', 'Page  Delete Successfully!!!.');
        Session::flash('alert-class', 'bg-froly');
        return redirect()->route('admin.pages.index');

    }

    public function getdata()
    {
        return $this->PageServices->getdata();

    }
}
