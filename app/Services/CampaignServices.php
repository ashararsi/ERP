<?php

namespace App\Services;

use Mail;
use App\Mail\SendMail;
use App\Models\CampaignDonors;
use App\Models\CampaignTeamMember;
use App\Models\Campaign;
use App\Models\CampaignProduct;

use App\Models\CampaignTickets;
use App\Models\Pages;
use App\Models\Message;
use App\Models\Transaction;
use App\Models\UserPurchasedTikets;
use Config;

use DataTables;
use Illuminate\Support\Str;
use Laravel\Ui\Tests\AuthBackend\AuthenticatesUsersTest;
use Carbon\Carbon;
class CampaignServices
{
    public function website_index($request)
    {

        $posts = Campaign::with(['user', 'teamMembers', 'campaignDonors'])
            ->withCount(['teamMembers', 'campaignDonors']) // Add counts
            ->orderBy('created_at', 'desc')
            ->paginate(10);


        return view('admin.campaign.index', compact('posts'));
    }

    public function dashboard($request)
    {
        $data = [];

        $c_ids = Campaign::where('user_id', auth()->id())->pluck('id')->toArray();

        $f_ids = Campaign::where('user_id', auth()->id())->where('type', 'Fundraising')->count();
        $t_ids = Campaign::where('user_id', auth()->id())->where('type', 'Ticket')->count();
        $data['f_count'] = $f_ids;
        $data['t_count'] = $t_ids;

        $c = Campaign::where('user_id', auth()->id())->with(['user', 'teamMembers', 'campaignDonors', 'campaign_tickets'])
            ->withCount(['teamMembers', 'campaignDonors']) // Add counts
            ->orderBy('created_at', 'desc')->count();

        $data['all_c'] = $c;
        $total_amount = Transaction::whereIn('campaigns_id', $c_ids)->sum('amount');
        $data['total_amount'] = $total_amount;
        $monthlyData = Transaction::whereIn('campaigns_id', $c_ids)
            ->where('created_at', '>=', Carbon::now()->subMonths(12)) // Last 12 months
            ->selectRaw('YEAR(created_at) as year, MONTH(created_at) as month, SUM(amount) as total_amount')
            ->groupBy('year', 'month')
            ->orderBy('year', 'desc')
            ->orderBy('month', 'desc')
            ->get();
        $formattedData = $monthlyData->map(function ($item) {
            return [
                'month' => Carbon::create($item->year, $item->month)->format('M Y'),
                'total_amount' => $item->total_amount
            ];
        });
        $data['monthly_data'] = $formattedData;

        return $data;

    }

    public function websiteshow($id)
    {
        $Campaign = Campaign::with(['user', 'teamMembers', 'campaignDonors'])->where('id', $id)->first();
        $donate = $this->donate_list($id);
        $ticket_list = $this->ticket_list($id);
        $Transaction = $this->transaction_list($id);

//        dd($ticket_list);
        return view('admin.campaign.view', compact('Campaign', 'donate', 'ticket_list', 'Transaction'));
    }

    public function donate_list($id)
    {
        return CampaignDonors::with('user', 'team')
            ->where('campaigns_id', $id)
            ->get();
    }

    public function transaction_list($id)
    {
        return Transaction::with('user')
            ->where('campaigns_id', $id)
            ->get();
    }

    public function ticket_list($id)
    {

        return UserPurchasedTikets::with('user', 'team')->where('campaign_id', $id)
            ->get();
    }

    public function getdata()
    {
//        return DataTables::of(Permission::query())->make(true);
        $data = Campaign::with('user')->orderBy('id', 'desc');
        return Datatables::of($data)->addIndexColumn()
            ->addColumn('action', function ($row) {
                $btn = ' <form  method="POST" onsubmit="return confirm(' . "'Are you sure you want to Delete this?'" . ');"  action="' . route("admin.campaign.destroy", $row->id) . '"> ';
                $btn = $btn . '<a href=" ' . route("admin.campaign.show", $row->id) . '"  class="ml-2"><i class="fas fa-eye"></i></a>';
                $btn = $btn . ' <a href="' . route("admin.campaign.edit", $row->id) . '" class="ml-2">  <i class="fas fa-edit"></i></a>';
                // $btn = $btn . '<button  type="submit" class="ml-2" ><i class="fas fa-trash"></i></button>';
                $btn = $btn . method_field('DELETE') . '' . csrf_field();
                $btn = $btn . ' </form>';
                return $btn;
            })->addColumn('user', function ($row) {
                return $row->user->name;
            })->addColumn('status', function ($row) {
                if ($row->status == 1) {
                    return 'Active';
                } else {
                    return 'Inactive';
                }
            })
            ->rawColumns(['action', 'user', 'status'])
            ->make(true);
    }

    public function getdata_transaction()
    {

        $data = Transaction::with('user')->orderBy('id', 'desc');
        return Datatables::of($data)->addIndexColumn()
            ->addColumn('user', function ($row) {
                return $row->user->name;
            })
            ->rawColumns(['user'])
            ->make(true);
    }

    public function index($request)
    {
        $perPage = $request->get('per_page', 20);
//        $posts = Campaign::with('user', 'teamMembers')->orderBy('created_at', 'desc')->paginate($perPage);
        $posts = Campaign::where('user_id', auth()->id())->with(['user', 'teamMembers', 'campaignDonors', 'campaign_tickets'])
            ->withCount(['teamMembers', 'campaignDonors']) // Add counts
            ->orderBy('created_at', 'desc')
            ->paginate($perPage);
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


    // public function store($request)
    // {
    //     $slug = Str::slug($request->eventTitle);

    //     // Ensure the slug is unique
    //     $originalSlug = $slug;
    //     $counter = 1;

    //     while (Campaign::where('slug', $slug)->exists()) {
    //         $slug = $originalSlug . '-' . $counter;
    //         $counter++;
    //     }

    //     $startTime=null;
    //     if($request->startTime){
    //       $startTime= $request->startTime;
    //     }

    //     if($request->eventStartTime){
    //       $startTime=  $request->eventStartTime;
    //     }

    //       if($request->fundraisingStartTime){
    //       $startTime=  $request->fundraisingStartTime;
    //     }

    //     if( $request->startDate ){
    //       $eventStartTime=  $request->startDate ;
    //     }
    //     if($request->fundraisingStartTime){
    //       $eventStartTime=$request->fundraisingStartTime;
    //     }

    //     if($request->eventStartDate){
    //          $eventStartTime=$request->eventStartDate;
    //     }

    //     $endTime="";
    //     if($request->endTime){
    //         $endTime= $request->endTime;

    //     }
    //      if( $request->eventEndTime){
    //         $endTime=  $request->eventEndTime;

    //     }
    //     if( $request->fundraisingEndTime){
    //         $endTime=  $request->fundraisingEndTime;

    //     }
    //     $location="";
    //     if($request->eventLocation){
    //       $location= $request->eventLocation;

    //     }
    //     if($request->location){
    //       $location= $request->location;

    //     }
    //     if($request->fundraisingLocation){
    //       $location= $request->fundraisingLocation;

    //     }


    //     $data = [
    //         'type' => $request->type,
    //         'campaign_name' => $request->campaign_name,
    //         'slug' => $slug,
    //         'eventTitle' => $request->eventTitle,
    //         'eventStartDate'=>$request->eventStartDate,
    //         'eventStartTime'=>$request->eventStartTime,
    //         'eventEndTime'=>$request->eventEndTime,
    //         'eventType' => $request->eventType,
    //         'startDate' => $eventStartTime,
    //         'startTime' => $startTime,
    //         'endTime' => $endTime,
    //         'location' =>  $location,
    //         'eventDescription' => $request->eventDescription,
    //         'ticketPrice' => $request->ticketPrice,
    //         'generalAdmission' => $request->generalAdmission,
    //         'referredAdmission' => $request->referredAdmission,
    //         'vipAdmission' => $request->vipAdmission,
    //         'ticketsAvailability' => $request->ticketsAvailability,
    //         'campaignTitle' => $request->campaignTitle,
    //         'campaignDescription' => $request->campaignDescription,
    //         'fundraisingGoal' => $request->fundraisingGoal,
    //         'campaignStartDate' => $request->campaignStartDate,
    //         'campaignStartTime' => $request->campaignStartTime,
    //         'campaignEndTime' => $request->campaignEndTime,
    //         'beneficiaryDetails' => $request->beneficiaryDetails,
    //         'fundUsageDetails' => $request->fundUsageDetails,
    //         'donationImpactDetails' => $request->donationImpactDetails,
    //         'inspirationalMedia' => $request->inspirationalMedia,
    //         'campaignImportance' => $request->campaignImportance,
    //         'teamUniqueness' => $request->teamUniqueness,
    //         'suggestedDonationAmounts' => json_encode($request->suggestedDonationAmounts),
    //         'allowCustomDonation' => $request->allowCustomDonation,
    //         'recurringDonations' => $request->recurringDonations,
    //         'donorRewardsOption' => $request->donorRewardsOption,
    //         'rewardDescriptions' => $request->rewardDescriptions,
    //         'campaignContactPerson' => $request->campaignContactPerson,
    //         'fundraisingTeamMembers' => $request->fundraisingTeamMembers,
    //         'fundraisingMilestones' => $request->fundraisingMilestones,
    //         'isTaxDeductible' => $request->isTaxDeductible,
    //         'transparencyStatement' => $request->transparencyStatement,
    //         'thankYouMessageOption' => $request->thankYouMessageOption,
    //         'donorUpdatesOption' => $request->donorUpdatesOption,
    //         'socialMediaLinks' => $request->socialMediaLinks,
    //         'socialMediaHashtags' => $request->socialMediaHashtags,
    //         'campaignVisibility' => $request->campaignVisibility,
    //         'donorPrivacySettings' => $request->donorPrivacySettings,
    //         'bannerImage' => $request->bannerImage,
    //         'user_id' => auth()->id(),
    //     ];
    //     $campaign = Campaign::create($data);
    //     $c_data = [
    //         'campaigns_id' => $campaign->id, 'user_id' => auth()->id(), 'price' => $request->ticketPrice, 'qty' => 500
    //     ];
    //     CampaignTickets::create($c_data);
    //     return $campaign;
    // }
    public function store($request)
    {
        // Generate a unique slug


        // Determine common properties with fallback
        $startTime = $request->startTime ?? $request->eventStartTime ?? $request->fundraisingStartTime;
        $fundraisingStartDate = $request->startDate ?? $request->fundraisingStartDate ?? $request->eventStartDate;
        $endTime = $request->endTime ?? $request->eventEndTime ?? $request->fundraisingEndTime;
        $location = $request->eventLocation ?? $request->location ?? $request->fundraisingLocation;

        // Set titles with fallback
        $fundraisingTitle = $request->fundraisingTitle ?? $request->eventTitle;
        $campaignName = $request->campaign_name ?? $fundraisingTitle;

        $campaignDescription = $request->campaignDescription ?? $request->eventDescription ?? $request->fundraisingDescription;


        $slug = Str::slug($fundraisingTitle);
        $originalSlug = $slug;
        $counter = 1;

        while (Campaign::where('slug', $slug)->exists()) {
            $slug = "{$originalSlug}-{$counter}";
            $counter++;
        }
        // Prepare data for campaign creation
        $data = [
            'type' => $request->type,
            'campaign_name' => $campaignName,
            'slug' => $slug,
            'eventTitle' => $fundraisingTitle,
            'eventStartDate' => $request->eventStartDate,
            'eventStartTime' => $request->eventStartTime,
            'eventEndTime' => $request->eventEndTime,
            'eventType' => $request->eventType,
            'startDate' => $fundraisingStartDate,
            'EndDate' => $request->EndDate,
            'startTime' => $startTime,
            'endTime' => $endTime,
            'location' => $location,
            'eventLocation' => $location,
            'eventDescription' => $campaignDescription,
            'campaignDescription' => $campaignDescription,
            'ticketPrice' => $request->ticketPrice,
            'generalAdmission' => $request->generalAdmission,
            'referredAdmission' => $request->referredAdmission,
            'vipAdmission' => $request->vipAdmission,
            'ticketsAvailability' => $request->ticketsAvailability,
            'campaignTitle' => $request->campaignTitle,

            'fundraisingGoal' => $request->fundraisingGoal,
            'campaignStartDate' => $request->campaignStartDate,
            'campaignStartTime' => $request->campaignStartTime,
            'campaignEndTime' => $request->campaignEndTime,
            'beneficiaryDetails' => $request->beneficiaryDetails,
            'fundUsageDetails' => $request->fundUsageDetails,
            'donationImpactDetails' => $request->donationImpactDetails,
            'inspirationalMedia' => $request->inspirationalMediaImage,
            'campaignImportance' => $request->campaignImportance,
            'teamUniqueness' => $request->teamUniqueness,
            'suggestedDonationAmounts' => json_encode($request->suggestedDonationAmounts),
            'allowCustomDonation' => $request->allowCustomDonation,
            'recurringDonations' => $request->recurringDonations,
            'donorRewardsOption' => $request->donorRewardsOption,
            'rewardDescriptions' => $request->rewardDescriptions,
            'campaignContactPerson' => $request->campaignContactPerson,
            'fundraisingTeamMembers' => $request->fundraisingTeamMembers,
            'fundraisingMilestones' => $request->fundraisingMilestones,
            'isTaxDeductible' => $request->isTaxDeductible,
            'transparencyStatement' => $request->transparencyStatement,
            'thankYouMessageOption' => $request->thankYouMessageOption,
            'donorUpdatesOption' => $request->donorUpdatesOption,
            'socialMediaLinks' => $request->socialMediaLinks,
            'socialMediaHashtags' => $request->socialMediaHashtags,
            'campaignVisibility' => $request->campaignVisibility,
            'donorPrivacySettings' => $request->donorPrivacySettings,
            'preferredAdmission' => $request->preferredAdmission,
            'bannerImage' => $request->bannerImage,
            'fundraiserSpecificEvent' => $request->fundraiserSpecificEvent,
            'donationPlan' => $request->donationPlan,
            'generalAdmissionseats' => $request->generalAdmissionseats,
            'preferredAdmissionseats' => $request->preferredAdmissionseats,
            'vipAdmissionseats' => $request->vipAdmissionseats,


            'user_id' => auth()->id(),
        ];

        // Create campaign
        $campaign = Campaign::create($data);

        // Create campaign ticket
        CampaignTickets::create([
            'campaigns_id' => $campaign->id,
            'user_id' => auth()->id(),
            'price' => $request->ticketPrice,
            'qty' => 500,
        ]);

        return $campaign;
    }


    public function edit($id)
    {
        return $post = Campaign::with('user', 'teamMembers')->where('id', $id)->first();

    }

    public function slug_get($slug)
    {
        return $post = Campaign::with('user', 'teamMembers')->where('slug', $slug)->first();

    }

    public function update($request, $id)
    {
        $data = [
            'type' => $request->type,
            'campaign_name' => $request->campaign_name,
            'slug' => Str::slug($request->campaign_name),
            'eventTitle' => $request->eventTitle,
            'eventType' => $request->eventType,
            'startDate' => $request->startDate,
            'startTime' => $request->startTime,
            'endTime' => $request->endTime,
            'location' => $request->location,
            'eventDescription' => $request->eventDescription,
            'ticketPrice' => $request->ticketPrice,
            'generalAdmission' => $request->generalAdmission,
            'referredAdmission' => $request->referredAdmission,
            'vipAdmission' => $request->vipAdmission,
            'ticketsAvailability' => $request->ticketsAvailability,
            'campaignTitle' => $request->campaignTitle,
            'campaignDescription' => $request->campaignDescription,
            'fundraisingGoal' => $request->fundraisingGoal,
            'campaignStartDate' => $request->campaignStartDate,
            'campaignStartTime' => $request->campaignStartTime,
            'campaignEndTime' => $request->campaignEndTime,
            'beneficiaryDetails' => $request->beneficiaryDetails,
            'fundUsageDetails' => $request->fundUsageDetails,
            'donationImpactDetails' => $request->donationImpactDetails,
            'inspirationalMedia' => $request->inspirationalMediaImage,
            'campaignImportance' => $request->campaignImportance,
            'teamUniqueness' => $request->teamUniqueness,
            'suggestedDonationAmounts' => $request->suggestedDonationAmounts,
            'allowCustomDonation' => $request->allowCustomDonation,
            'recurringDonations' => $request->recurringDonations,
            'donorRewardsOption' => $request->donorRewardsOption,
            'rewardDescriptions' => $request->rewardDescriptions,
            'campaignContactPerson' => $request->campaignContactPerson,
            'fundraisingTeamMembers' => $request->fundraisingTeamMembers,
            'fundraisingMilestones' => $request->fundraisingMilestones,
            'isTaxDeductible' => $request->isTaxDeductible,
            'transparencyStatement' => $request->transparencyStatement,
            'thankYouMessageOption' => $request->thankYouMessageOption,
            'donorUpdatesOption' => $request->donorUpdatesOption,
            'socialMediaLinks' => $request->socialMediaLinks,
            'socialMediaHashtags' => $request->socialMediaHashtags,
            'campaignVisibility' => $request->campaignVisibility,
            'donorPrivacySettings' => $request->donorPrivacySettings,
            'bannerImage' => $request->bannerImage,
            'user_id' => auth()->id(),
        ];

        return $campaign = Campaign::where('id', $id)->update($data);
    }

    public function destroy($id)
    {
        $post = Campaign::findOrFail($id);
        if ($post) {
            $post->delete();
        }
    }


    public function assgin_member($request)
    {
        $ids = $request->user_ids;
        $campaigns_id = $request->campaigns_id;
        foreach ($ids as $id) {
            $data = [
                'user_id' => $id,
                'campaigns_id' => $campaigns_id,
            ];
            $check = CampaignTeamMember::where('campaigns_id', $campaigns_id)->where('user_id', $id)->first();
            if (!$check)
                CampaignTeamMember::created([$data]);
        }
    }

    public function assgin_donor($request)
    {

        $ids = $request->user_ids;
        $campaigns_id = $request->campaigns_id;
        foreach ($ids as $id) {
            $data = [
                'user_id' => $id,
                'campaigns_id' => $campaigns_id,
            ];
            CampaignDonors::created([$data]);
        }
    }

    public function campaign_team_url($slug, $u_id)
    {
//            Campaign::where('slug',$slug)->where('')->get();
        $Campaign = Campaign::where('slug', $slug)->firstOrFail();


    }


    public function productindex($request)
    {

        $campaign_id = $request->campaign_id;
        if ($campaign_id) {
            $perPage = $request->get('per_page', 20);

            $product = CampaignProduct::where('campaign_id', $campaign_id)->with(['campaign_detail'])
                ->orderBy('created_at', 'desc')
                ->paginate($perPage);
            return response()->json([
                'data' => $product->items(),
                'current_page' => $product->currentPage(),
                'last_page' => $product->lastPage(),
                'per_page' => $product->perPage(),
                'total' => $product->total(),
                'next_page_url' => $product->nextPageUrl(),
                'prev_page_url' => $product->previousPageUrl(),
            ]);
        } else {
            return "Campaign ID Required";
        }

    }

    public function productstore($request)
    {

        $data = [
            'name' => $request->name,
            'set_pricing' => $request->set_pricing,
            'image' => $request->image,
            'campaign_id' => $request->campaign_id,
            'description' => $request->description,
        ];
        $campaign_product = CampaignProduct::create($data);

        return $campaign_product;
    }

    public function productupdate($request, $id)
    {

        $data = [
            'name' => $request->name,
            'set_pricing' => $request->set_pricing,
            'image' => $request->image,
            'campaign_id' => $request->campaign_id,
            'description' => $request->description,
        ];
        $campaign_product = CampaignProduct::where('id', $id)->update($data);

        return $campaign_product;
    }

    public function productshow($id)
    {

        $campaign_product = CampaignProduct::find($id);

        return $campaign_product;
    }

    public function productedit($id)
    {

        $campaign_product = CampaignProduct::find($id);

        return $campaign_product;
    }

    public function productdestroy($id)
    {

        $campaign_product = CampaignProduct::find($id);

        $campaign_product->delete();
        return 'Delete Product';
    }

    public function mail($request)
    {
        $message = "";
        if ($request->message) {
            $message = $request->message;
        }
        if ($request->text) {
            $message = $request->text;
        }
        $email = $request->email ?? 'ashararsi2@gmail.com';
        $video_link = $request->video_link ?? '';
        $data = [
            'email' => $email,
            'text' => $message,
            'type' => 'text',
            'user_id' => auth()->id(),
            'video_link' => $request->video_link,
            'campaigns_id' => $request->campaigns_id,
        ];
        //   Message::create([$data]);

        Mail::to($email)->send(new SendMail($message, $video_link));

//        $campaign_product = CampaignProduct::find($id);
//
//        $campaign_product->delete();
//        return 'Delete Product';
    }

}
