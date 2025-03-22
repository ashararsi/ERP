<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\RolesServise;
use Illuminate\Support\Facades\Session;
use Gate;

class RolesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct(RolesServise $RolesServise)
    {
        $this->RolesServise = $RolesServise;
    }


    public function index()
    {
//        if (!Gate::allows('Role_Index')) {
//            return abort(503);
//        }
        return view('admin.roles.index');
    }

    public function getdata()
    {
        return $this->RolesServise->getdata();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
//        if (!Gate::allows('Role_Create')) {
//            return abort(503);
//        }
        try {
            $permissions = $this->RolesServise->create();
            return view('admin.roles.create', compact('permissions'));
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
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
            'name' => 'required|unique:roles|max:255',
        ]);
        try {
            $this->RolesServise->store($request);
            Session::flash('flash_message_sucess', 'Role Sucessfully Add!!!.');
            return redirect()->route('admin.roles.index');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        try {
            if (!Gate::allows('Role_Edit')) {
                return abort(503);
            }
            $permissions = $this->RolesServise->create();
            $AllowedPermissions = $this->RolesServise->AllowedPermissions($id);
            $AllowedPermissions = $AllowedPermissions->toArray();
            if (!$AllowedPermissions) {
                $AllowedPermissions = [];
            }
            $role = $this->RolesServise->edit($id);
            return view('admin.roles.edit', compact('role', 'permissions', 'AllowedPermissions'));
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
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
        try {
            $role = $this->RolesServise->update($request, $id);
            Session::flash('flash_message_sucess', 'Role  create Successfully!!!.');
            return redirect()->route('admin.roles.index');
        } catch (\Exception $e) {
            dd($e->getMessage());
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            if (!Gate::allows('Role_Delete')) {
                return abort(503);
            }
            $this->RolesServise->destroy($id);
            Session::flash('flash_message_sucess', 'Role Delete Successfully!!!.');
            return redirect()->route('admin.roles.index');
        } catch (\Exception $e) {

            return redirect()->back()->with('error', $e->getMessage());
        }
    }
}
