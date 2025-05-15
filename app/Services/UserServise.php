<?php

namespace App\Services;


use App\Models\Campaign;
use App\Models\CampaignTeamMember;
use Config;
use Spatie\Permission\Models\Role;
use App\Models\User;
use App\Models\CoachMember;
use App\Models\UserLocationAssignment;
use DataTables;

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;


class UserServise
{

    public function index($request)
    {
        $perPage = $request->get('per_page', 20);


        // Query the users who are not in the excluded list, ordered by creation date
        $users = User::orderBy('created_at', 'desc')
            ->paginate($perPage);
        return response()->json([
            'data' => $users->items(), // The current page's items
            'current_page' => $users->currentPage(),
            'last_page' => $users->lastPage(),
            'per_page' => $users->perPage(),
            'total' => $users->total(),
            'next_page_url' => $users->nextPageUrl(),
            'prev_page_url' => $users->previousPageUrl(),
        ]);
    }

    public function apiindex()
    {
        return User::all();

    }

    public function create()
    {

        return Role::all();
    }

    public function store($request)
    {

        $roles = $request->role ? $request->role : [];

        $roles_arrayy = Role::whereIn('id', $roles)->pluck('name');

        $data = $request->all();
        $data['image'] = "dist/Profile/defualt.png";
        $fileNameToStore = null;
        $data['password'] = Hash::make($request->password);
        unset($data['role']);
        $user = User::create($data);
        $user->assignRole($roles_arrayy);
        $a = User::with('roles')->get();

        $this->createSpoUser($user, $request);
    }

    public function createSpoUser($user, $request)
    {
        UserLocationAssignment::create([
            'user_id' => $user->id,
            'company_id' => $request->company_id,
            'area_id' => $request->area_id,
            'city_id' => $request->city_id,
        ]);
    }

    public function user_deactive($id)
    {
        $user = User::find($id);
        if ($user) {
            $user->active = 0;
            $user->save();
        }
    }

    public function user_data($slug)
    {

        return $user = User::where('slug', $slug)->first();

    }

    public function user_active($id)
    {
        $user = User::find($id);
        if ($user) {
            $user->active = 1;
            $user->save();
        }

    }


    public function getdata($request)
    {

        $data = User::select('id', 'email', 'name', 'email_verified_at')->orderBy('id', 'desc');

        if ($request->role) {
            $data->whereHas('roles', function ($query) use ($request) { // Pass $request to closure
                $query->where('name', $request->role);
            });
        }

        return Datatables::of($data)->addIndexColumn()
            ->addColumn('status', function ($row) {
                return ($row->active == 1) ? 'Active' : 'Deactive';
            })->addColumn('email_verified_at', function ($row) {
                return ($row->email_verified_at) ? 'verified' : 'Not verified';
            })->addColumn('role', function ($row) {
                return $row->role->name ?? '';
            })
            ->addColumn('action', function ($row) {
                $a = $row->active;
                $admin = $row->is_admin;
                $btn = ' <form  method="POST" onsubmit="return confirm(' . "'Are you sure you want to Delete this?'" . ');"  action="' . route("admin.users.destroy", $row->id) . '"> ';
                $btn = $btn . '<a href=" ' . route("admin.users.show", $row->id) . '"  class="ml-2"><i class="fas fa-eye"></i></a>';
                $btn = $btn . ' <a href="' . route("admin.users.edit", $row->id) . '" class="ml-2">  <i class="fas fa-edit"></i></a>';
                $btn = $btn . '<button  type="submit" class="ml-2" ><i class="fas fa-trash"></i></button>';
                $btn = $btn . method_field('DELETE') . '' . csrf_field();
                $btn = $btn . ' </form>';
                return $btn;
            })
            ->rawColumns(['action', 'status', 'email_verified_at', 'role'])
            ->make(true);
    }

    public function edit($id)
    {
        return User::where('id', $id)->first();


    }

    public function update($request, $id)
    {
        $user = User::find($id);
        $data = $request->all();
//        $data['image']="dist/Profile/defualt.png";
        $fileNameToStore = null;

        if ($request->hasfile('profile')) {
            $file = $request->file('profile');
            $filenameWithExt = $file->getClientOriginalName();
            $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
            $filename = preg_replace("/[^A-Za-z0-9 ]/", '', $filename);
            $filename = preg_replace("/\s+/", '-', $filename);
            $extension = $file->getClientOriginalExtension();
            $fileNameToStore = $filename . '_' . time() . '.' . $extension;
            $destinationPath = 'dist/Profile';
            $file->move($destinationPath, $fileNameToStore);
            $user->image = $fileNameToStore;
        }
        if (isset($request->password) && $request->password != null)
            $user->password = Hash::make($request->password);
        $user->email = $request->email;
        $user->name = $request->name;
        $user->save();
        $roles = $request->input('role') ? $request->input('role') : [];
//        $user->syncRoles($roles);
        $a = User::with('roles')->get();

    }

    public function destroy($id)
    {
        $User = User::findOrFail($id);
        if ($User)
            $User->delete();

    }

}
