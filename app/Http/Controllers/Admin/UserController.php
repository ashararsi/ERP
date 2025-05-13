<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use App\Services\UserServise;
use Illuminate\Support\Facades\Session;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use App\Helpers\GernalHelper;
use App\Models\Area;
use App\Models\City;
use App\Models\Company;
use Gate;
class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function __construct(UserServise $UserServise)
    {
        $this->UserServise = $UserServise;
    }

    public function index()
    {
//        if (!Gate::allows('User_Index')) {
//            return abort(503);
//        }

        return view('admin.Users.index');
    }

    public function getdata(Request $request)
    {
        return $this->UserServise->getdata($request);

    }

    public function user_deactive($id)
    {
           $this->UserServise->user_deactive($id);
        GernalHelper::logAction('User', 'Deactive', 'user Deactive successfully');
        Session::flash('flash_message_sucess', 'User    Deactive Successfully  !!!.');
        Session::flash('alert-class', 'alert-success');
        return redirect()->route('admin.users.index');
    } public function user_active($id)
    {
           $this->UserServise->user_active($id);
        GernalHelper::logAction('User', 'Active', 'user Active successfully');
        Session::flash('flash_message_sucess', 'User    Active Successfully  !!!.');
        Session::flash('alert-class', 'alert-success');
        return redirect()->route('admin.users.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
//        if (!Gate::allows('User_create')) {
//            return abort(503);
//        }
        $companies = Company::all();
        $areas = Area::all();
        $cities = City::all();
       $roles= $this->UserServise->create();
       return view('admin.Users.create', compact('roles', 'companies', 'areas', 'cities'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|min:3|max:50',
            'email' => 'required|unique:users,email',
            'role' => 'required',
            'password' => 'required|confirmed|min:6',
            'profile' => 'mimes:jpeg,jpg,png,gif'
        ]);

        $this->UserServise->store($request);
        GernalHelper::logAction('User', 'Save', 'user save successfully');

          Session::flash('flash_message_sucess', 'User Successfully Add!!!.');
        Session::flash('alert-class', 'alert-success');
        return redirect()->route('admin.users.index');

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
//        if (!Gate::allows('User_Edit')) {
//            return abort(503);
//        }
        $User= User::findOrFail($id);



        $roles= $this->UserServise->create();
        $user = $this->UserServise->edit($id);
        return view('admin.Users.edit', compact('user','roles' ));
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
        $this->validate($request, [
            'name' => 'required|min:3|max:50',
            'email' => 'email|required',

            'password' => 'confirmed',
            'profile' => 'mimes:jpeg,jpg,png,gif|max:10000'
        ]);
        $user = $this->UserServise->update($request, $id);
        GernalHelper::logAction('User', 'Update', 'user Update successfully');

        Session::flash('flash_message_sucess', 'User Update Successfully !!!.');
        Session::flash('alert-class', 'alert-success');
        return redirect()->route('admin.users.index');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
//        if (!Gate::allows('User_Delete')) {
//            return abort(503);
//        }
        $user = $this->UserServise->destroy($id);
        GernalHelper::logAction('User', 'Delete', 'user Delete successfully');

        Session::flash('flash_message_sucess', 'User  Delete Successfully!!!.');
        Session::flash('alert-class', 'bg-froly');
        return redirect()->route('admin.users.index');
    }
}
