<?php

namespace App\Services;

use App\Models\ApiLog;
use App\Models\ContactUS;

use Config;

use DataTables;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
use Laravel\Ui\Tests\AuthBackend\AuthenticatesUsersTest;
use PHPUnit\Exception;
use Tymon\JWTAuth\Facades\JWTAuth;

class ContactUsServices
{

    public function create()
    {

        return view('admin.post.create');
    }

    public function web_index()
    {
        return view('admin.post.index');
    }

    public function index($request)
    {
        $perPage = $request->get('per_page', 20);
        $posts = ContactUs::orderBy('created_at', 'desc')->paginate($perPage);
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
        if (auth()) {
            $data['user_id'] = auth()->id();
        } else {
            $data['user_id'] = null; // Optional, if you want a fallback
        }
        return ContactUs::create($data);
    }

    public function edit($id)
    {
        return $post = ContactUs::findOrFail($id);

    }

    public function update($request, $id)
    {
        $data = $request->all();

        return ContactUs::find($id)->update($data);
    }

    public function destroy($id)
    {
        $post = ContactUs::findOrFail($id);
        if ($post) {
            $post->delete();
        }
    }

    public function getdata()
    {

        $data = ContactUs::orderBy('id', 'desc');
        return Datatables::of($data)->addIndexColumn()
            ->addColumn('action', function ($row) {
                $btn = ' <form  method="POST" onsubmit="return confirm(' . "'Are you sure you want to Delete this?'" . ');"  action="' . route("admin.posts.destroy", $row->id) . '"> ';
                $btn = $btn . '<a href=" ' . route("admin.posts.show", $row->id) . '"  class="ml-2"><i class="fas fa-eye"></i></a>';
                $btn = $btn . ' <a href="' . route("admin.posts.edit", $row->id) . '" class="ml-2">  <i class="fas fa-edit"></i></a>';
                $btn = $btn . '<button  style="border:none;" type="submit" class="ml-2" ><i class="fas fa-trash"></i></button>';
                $btn = $btn . method_field('DELETE') . '' . csrf_field();
                $btn = $btn . ' </form>';
                return $btn;
            })
            ->rawColumns(['action', 'publish'])
            ->make(true);
    }

    public function getIntegratedAppGroups(Request $request)
    {
        $user = Auth::user();
        $token = JWTAuth::fromUser($user);
        $category = $request->category;
        $app_name = $request->appName;
        $response = null;
        $api_url = null;

        try {
            if ($category === 'custom') {
                $data = ['company_id' => $user->company_id];

                switch ($app_name) {
                    case 'microsoft-entra-id';
                        $api_url = config('constants.MICROSOFT_ENTRA_INTEGRATIONS_URL') . 'groups';
                        $apiLogInsert = [
                            'company_id' => $user->company_id,
                            'user_id' => $user->id,
                            'api_url' => $api_url,
                            'payload' => json_encode($data),
                            'response' => null,
                            'type' => 1,
                            'created_at' => date('Y-m-d H:i:s'),
                            'updated_at' => date('Y-m-d H:i:s')
                        ];
                        $logId = ApiLog::insertGetId($apiLogInsert);
                        $response = Http::withHeaders([
                            'token' => $token,
                        ])->post($api_url, $data);
                        break;

                    case 'google-workspace';
                        $api_url_sync = config('constants.GOOGLE_WORKSPACE_INTEGRATIONS_URL') . 'company/' . $user->company_id . '/groups/sync';
                        $response = Http::withHeaders([
                            'token' => $token,
                        ])->post($api_url_sync);
                        $api_url = config('constants.GOOGLE_WORKSPACE_INTEGRATIONS_URL') . 'company/' . $user->company_id . '/groups';
                        $apiLogInsert = [
                            'company_id' => $user->company_id,
                            'user_id' => $user->id,
                            'api_url' => $api_url,
                            'payload' => json_encode($data),
                            'response' => null,
                            'type' => 1,
                            'created_at' => date('Y-m-d H:i:s'),
                            'updated_at' => date('Y-m-d H:i:s')
                        ];
                        $logId = ApiLog::insertGetId($apiLogInsert);
                        $response = Http::withHeaders([
                            'token' => $token,
                        ])->get($api_url, $data);
                        break;


                    case'jamf';

                        break;
                    case 'okta';

                        break;
                }


                $theResponse = $response->json();

                ApiLog::where('id', $logId)->update(['response' => json_encode($theResponse)]);
                if ($response->successful()) {
                    $responseData = $response->json();
                    $filteredData = [];
                    switch ($app_name) {
                        case 'microsoft-entra-id';
                            $filteredData['results'] = collect($responseData['value'])->map(function ($item) {
                                return [
                                    'id' => $item['id'],
                                    'name' => $item['displayName'] ?? 'N/A'
                                ];
                            });
                            break;
                        case 'google-workspace';

                            $filteredData['results'] = collect($responseData['groups'])->map(function ($item) {
                                return [
                                    'id' => $item['groupId'],
                                    'name' => $item['name'] ?? 'N/A'
                                ];
                            });
                            break;
                        case'jamf';

                            break;
                        case 'okta';

                            break;
                    }
//                    dd($responseData);
                    return response()->success(200, '', ['integrationGroups' => $filteredData]);
                }
            } else {
                $data = ['integration_app_id' => $request->id];
                $apiLogInsert = [
                    'company_id' => $user->company_id,
                    'user_id' => $user->id,
                    'api_url' => config('constants.INTEGRATIONS_URL') . '/api/merge/account-groups-details',
                    'payload' => json_encode($data),
                    'response' => null,
                    'type' => 1,
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s')
                ];
                $logId = ApiLog::insertGetId($apiLogInsert);
                $response = Http::withHeaders([
                    'token' => $token,
                ])->post(config('constants.INTEGRATIONS_URL') . '/api/merge/account-groups-details', $data);

                $theResponse = $response->json();
                ApiLog::where('id', $logId)->update(['response' => json_encode($theResponse)]);
                if ($response->successful()) {
                    $responseData = $response->json();
                    return response()->success(200, '', ['integrationGroups' => $responseData['integratedGroups']]);
                }
            }
        } catch (Exception $e) {
            return response()->error(500, $e->getMessage());
        }
    }

}
