<?php

namespace App\Services;

use App\Models\Fundraise;

use Illuminate\Support\Str;


class  FundraisesService
{
    public function index($request)
    {
        $perPage = $request->get('per_page', 20);
        $posts = Fundraise::orderBy('created_at', 'desc')->paginate($perPage);
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

    public function store(Request $request)
    {

        $validatedData = $request->validate([
            'eventTitle' => 'required|string|max:255',
            'eventType' => 'nullable|string',
            'startDate' => 'nullable|date',
            'startTime' => 'nullable',
            'endTime' => 'nullable',
            'location' => 'nullable|string',
            'eventDescription' => 'nullable|string',
            'ticketPrice' => 'nullable|string',
            'fundraisingTitle' => 'nullable|string',
            'fundraisingCategory' => 'nullable|string',
            'fundraisingStartDate' => 'nullable|date',
            'fundraisingStartTime' => 'nullable',
            'fundraisingEndTime' => 'nullable',
            'fundraisingLocation' => 'nullable|string',
            'fundraisingDescription' => 'nullable|string',
            'campaignTitle' => 'nullable|string',
            'campaignDescription' => 'nullable|string',
            'fundraisingGoal' => 'nullable|numeric',
            'campaignStartDate' => 'nullable|date',
            'campaignStartTime' => 'nullable',
            'campaignEndTime' => 'nullable',
            'beneficiaryDetails' => 'nullable|string',
            'fundUsageDetails' => 'nullable|string',
            'donationImpactDetails' => 'nullable|string',
            'inspirationalMedia' => 'nullable|string',
            'campaignImportance' => 'nullable|string',
            'teamUniqueness' => 'nullable|string',
            'suggestedDonationAmounts' => 'nullable|string',
            'allowCustomDonation' => 'nullable|boolean',
            'recurringDonations' => 'nullable|boolean',
            'donorRewardsOption' => 'nullable|boolean',
            'rewardDescriptions' => 'nullable|string',
            'campaignContactPerson' => 'nullable|string',
            'fundraisingTeamMembers' => 'nullable|string',
            'fundraiserSpecificEvent' => 'nullable|string',
            'eventStartDate' => 'nullable|date',
            'eventLocation' => 'nullable|string',
            'fundraisingMilestones' => 'nullable|string',
            'isTaxDeductible' => 'nullable|boolean',
            'transparencyStatement' => 'nullable|string',
            'thankYouMessageOption' => 'nullable|boolean',
            'donorUpdatesOption' => 'nullable|boolean',
            'socialMediaLinks' => 'nullable|string',
            'socialMediaHashtags' => 'nullable|string',
            'campaignVisibility' => 'nullable|string',
            'donorPrivacySettings' => 'nullable|string',
            'bannerImage' => 'nullable|json',
        ]);

        $fundraise = Fundraise::create($validatedData);

        return $fundraise;

    }

    public function edit($id)
    {
        return   Fundraise::find($id);

    }

    public function update($request, $id)
    {

        $fundraise = Fundraise::find($id);
        return  $fundraise->update($request->all());

    }

    public function destroy($id)
    {
        $post = Fundraise::findOrFail($id);
        if ($post) {
            $post->delete();
        }
    }
}
