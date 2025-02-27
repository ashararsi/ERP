<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\CampaignServices;
use Illuminate\Http\Request;

class CampaignController extends Controller
{
    public function __construct(CampaignServices $CampaignServices)
    {
        $this->CampaignServices = $CampaignServices;
    }


    public function index(Request $request)
    {

        return $this->CampaignServices->website_index($request);


    }


    public function getdata()
    {
        return $this->CampaignServices->getdata();
    }

    public function show($id)
    {

        return $this->CampaignServices->websiteshow($id);

    }


}
