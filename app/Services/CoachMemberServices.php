<?php

namespace App\Services;

use App\Models\Campaign;
use App\Models\Transaction;
use App\Models\user;

use App\Models\Event;
use App\Models\CampaignTeamMember;
use App\Models\CampaignDonors;
use App\Models\CoachMember;
use Config;
use http\Url;
use Illuminate\Support\Facades\Hash;

use DataTables;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Laravel\Ui\Tests\AuthBackend\AuthenticatesUsersTest;

class  CoachMemberServices
{
    public function index($request)
    {
        $perPage = $request->get('per_page', 20);

        $coaches = User::where('role', 'coach')
            ->with('members.member')
            ->orderBy('created_at', 'desc')
            ->paginate($perPage);

        return [
            'data' => $coaches->items(),
            'current_page' => $coaches->currentPage(),
            'last_page' => $coaches->lastPage(),
            'per_page' => $coaches->perPage(),
            'total' => $coaches->total(),
            'next_page_url' => $coaches->nextPageUrl(),
            'prev_page_url' => $coaches->previousPageUrl(),
        ];
    }

    public function store(Request $request)
    {

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8',
        ]);

        $url = "";
        if ($request->input('avatar')) {
            // Get the base64 image string from the request
            $base64Image = $request->input('avatar');
            // Remove any data URI scheme if present
            if (preg_match('/^data:image\/(\w+);base64,/', $base64Image, $type)) {
                $base64Image = substr($base64Image, strpos($base64Image, ',') + 1);
            }

            // Decode the base64 string
            $imageData = base64_decode($base64Image);

            // Check if decoding was successful
            if ($imageData === false) {
                return ['error' => 'Invalid base64 string'];
            }
            // Create a unique filename
            $filename = 'images/' . Str::random(10) . '.png';

            // Save the decoded image to storage
            Storage::disk('public')->put($filename, $imageData);

            // Generate the URL
            $url = Storage::url($filename);

        }
        $user = User::create(
            [
                "email" => $request->input('email'),
                "first_name" => $request->first_name,
                "last_name" => $request->last_name,
                "company_id" => $request->company_id ?? 0,
                "phone_number" => $request->phone_number,
                "country" => $request->country,
                "city" => $request->city,
                "pincode" => $request->pincode,
                "address" => $request->address,
                "avatar" => $url,
                'role' => 'coach',
            ]);

        return $user;

    }

    public function edit($id)
    {
        return User::findOrFail($id);

    }

    public function addMember($request, $coachId)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
        ]);

        // Check if coach exists
        $coach = User::findOrFail($coachId);

        // Check if the user is not already assigned to this coach
        $existingMember = CoachMember::where('coach_id', $coachId)
            ->where('user_id', $request->user_id)
            ->first();

        if ($existingMember) {
            return response()->json(['message' => 'Member already assigned to this coach.'], 400);
        }

        // Assign member to coach
        $coachMember = CoachMember::create([
            'coach_id' => $coachId,
            'user_id' => $request->user_id,
        ]);

        $campaine = Campaign::where('user_id', $coachId)->first();
        if ($campaine) {
            $compaineteammember = CampaignTeamMember::create([
                'campaigns_id' => $campaine->id,
                'user_id' => $request->user_id,
                'total_donate' => 0,
                'campaigns_link' => url('/') . '/' . bcrypt($request->user_id),

            ]);

        }

        return $coachMember;
    }

    public function addMember_register($request)
    {
//        $request->validate([
//            'user_id' => 'required|exists:users,id',
//        ]);

//


        // Check if coach exists
        $coach = User::findOrFail(auth()->id());

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'phone_number' => $request->phone_number,
            'password' => Hash::make($request->password),
            'role' => 'team_member',
        ]);

        // Assign member to coach
        $coachMember = CoachMember::create([
            'coach_id' => auth()->id(),
            'user_id' => $user->id,
        ]);

        $campaine = Campaign::where('user_id', $coach->id)->where('status', 1)->first();
        if ($campaine) {
            $compaineteammember = CampaignTeamMember::create([
                'campaigns_id' => $campaine->id,
                'user_id' => $user->id,
                'total_donate' => 0,
                'campaigns_link' => url('/') . '/' . bcrypt($request->user_id),
            ]);
        }

        return $coachMember;
    }

    public function update($request, $id)
    {
        $user = User::find($id);
        $url = $user->avatar;
        if ($request->input('avatar')) {
            // Get the base64 image string from the request
            $base64Image = $request->input('avatar');
            // Remove any data URI scheme if present
            if (preg_match('/^data:image\/(\w+);base64,/', $base64Image, $type)) {
                $base64Image = substr($base64Image, strpos($base64Image, ',') + 1);
            }

            // Decode the base64 string
            $imageData = base64_decode($base64Image);

            // Check if decoding was successful
            if ($imageData === false) {
                return response()->json(['error' => 'Invalid base64 string'], 400);
            }
            // Create a unique filename
            $filename = 'images/' . Str::random(10) . '.png';

            // Save the decoded image to storage
            Storage::disk('public')->put($filename, $imageData);

            // Generate the URL
            $url = Storage::url($filename);

        }
        $user = $user->update(
            [
                "email" => $request->input('email'),
                "first_name" => $request->first_name,
                "last_name" => $request->last_name,
                "company_id" => $request->company_id ?? 0,
                "phone_number" => $request->phone_number,
                "country" => $request->country,
                "city" => $request->city,
                "pincode" => $request->pincode,
                "address" => $request->address,
                "avatar" => $url,
            ]);
        return $user;


    }

    public function removeMember($request, $coachId, $memberId)
    {
        $coach = User::findOrFail(auth()->id());

        $coachMember = CoachMember::where('coach_id', $coachId)
            ->where('user_id', $memberId)
            ->first();

        if (!$coachMember) {
            return ['message' => 'Member not assigned to this coach.'];
        }

        $coachMember->delete();
        return ['message' => 'Member removed from the coach successfully.'];
    }

    public function destroy($id)
    {
        $post = User::findOrFail($id);
        if ($post) {
            $post->delete();
        }
    }

    public function listMember($request)
    {
        $coachId = auth()->id();
        $users_ids = CoachMember::where('coach_id', $coachId)->pluck('user_id')->toArray();


        $perPage = $request->get('per_page', 20);

        $users = User::with('members.coach', 'members')->whereIn('id', $users_ids)
            ->orderBy('created_at', 'desc')
            ->paginate($perPage);
        return [
            'data' => $users->items(),
            'current_page' => $users->currentPage(),
            'last_page' => $users->lastPage(),
            'per_page' => $users->perPage(),
            'total' => $users->total(),
            'next_page_url' => $users->nextPageUrl(),
            'prev_page_url' => $users->previousPageUrl(),
        ];

    }

    public function donor_register($request)
    {
        $coach = User::findOrFail(auth()->id());
        if ($request->campaigns_id) {
            $campaine = Campaign::where('id', $request->campaigns_id)->first();
        } else {
            $campaine = Campaign::where('user_id', $coach->id)->where('status', 1)->latest('created_at')->first();
        }
        $user_check = User::where('email', $coach->email)->first();
        if (!$user_check) {
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
                'phone_number' => $request->phone_number,
                'password' => Hash::make($request->password),
                'role' => 'donor',
            ]);
            $CampaignDonors = CampaignDonors::where('user_id', $user->id)->first();
        } else {
            $user = $user_check->update([
                'name' => $request->name,
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
                'phone_number' => $request->phone_number,
                'password' => Hash::make($request->password),
                'role' => 'donor',
            ]);
            $CampaignDonors = CampaignDonors::where('user_id', $user_check->id)->first();
        }


        if (!$CampaignDonors) {
            CampaignDonors::create([
                'user_id' => $user->id,
                'campaigns_id' => $campaine->id,
                'total_donate' => 0,
            ]);
        }
        return $user;
    }

    public function donor_list($request)
    {
        $coach = User::findOrFail(auth()->id());
        $campaine = Campaign::where('user_id', $coach->id)->where('status', 1)->first();
        $ids = CampaignDonors::where('campaigns_id', $campaine->id)->pluck('user_id')->toArray();
        $perPage = $request->get('per_page', 20);

        $users = User::whereIn('id', $ids)
            ->orderBy('created_at', 'desc')
            ->paginate($perPage);
        return [
            'data' => $users->items(),
            'current_page' => $users->currentPage(),
            'last_page' => $users->lastPage(),
            'per_page' => $users->perPage(),
            'total' => $users->total(),
            'next_page_url' => $users->nextPageUrl(),
            'prev_page_url' => $users->previousPageUrl(),
        ];
    }

    public function campaign_donor_list($request)
    {
        $coach = User::findOrFail(auth()->id());
        $campaine = Campaign::where('id', $request->campaigns_id)->where('status', 1)->first();
        $ids = CampaignDonors::where('campaigns_id', $campaine->id)->pluck('user_id')->toArray();

        $perPage = $request->get('per_page', 20);

        $users = User::whereIn('id', $ids)
            ->orderBy('created_at', 'desc')
            ->paginate($perPage);
        $output = [];
        foreach ($users->items() as $key => $user) {
            $output[$key]['id'] = $user->id;
            $output[$key]['name'] = $user->first_name . ' ' . $user->last_name;
            $output[$key]['email'] = $user->email;
            $output[$key]['campaign_name'] = $campaine ->campaign_name;
            $output[$key]['created_at'] = $user->created_at;
            $output[$key]['status'] = $user->status;
            $t = Transaction::where('user_id', $user->id)->where('campaigns_id', $request->campaigns_id)->sum('amount');
            $output[$key]['total'] = $t;
        }


        return [
            'data' => $output,
            'current_page' => $users->currentPage(),
            'last_page' => $users->lastPage(),
            'per_page' => $users->perPage(),
            'total' => $users->total(),
            'next_page_url' => $users->nextPageUrl(),
            'prev_page_url' => $users->previousPageUrl(),
        ];
    }
}
