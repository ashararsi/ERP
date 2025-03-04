<?php

namespace App\Helpers;

use App\Models\Branches;
use App\Models\Company;
use Auth;
use Session;

class PermissionCheck
{
    /**
     * This function formats the currency as per the currency format in account settings
     *
     * $input format is xxxxxxx.xx
     */
    static function check_branch()
    {
        $company_session = Session::get('company_session');
        $branch_session = Session::get('branch_session');
        $branchs = Branches::where('company_id', $company_session)->get();
        $count_b = 0;
        $user_b_id = auth()->user()->branch_id;

        $branchs_array = [];

        if (!$branch_session) {
            foreach ($branchs as $item) {
                if (Auth::user()->isAbleTo('Branch_' . $item->id)) {
                    $count_b = $count_b + 1;
                    $branchs_array[] = $item->id;
                }
            }

            if ($count_b == 0) {
                $branchs_array[] = $user_b_id;
            }
        } else {
            $branchs_array[] = $branch_session;
        }

        return $branchs_array;

    }

    static function check_branch_search()
    {
        $company_ids = self::check_company();
        $user_b_id = auth()->user()->branch_id;
        if ($user_b_id == 4) {
            $branchs = Branches::get();
        } else {
            $branchs = Branches::whereIn('company_id', $company_ids)->get();
        }

        $count_b = 0;

        $branchs_array = [];


        foreach ($branchs as $item) {
            if (Auth::user()->isAbleTo('Branch_' . $item->id)) {
                $count_b = $count_b + 1;
                $branchs_array[] = $item->id;
            }
        }

        if ($count_b == 0) {
            $branchs_array[] = $user_b_id;
        }


        return $branchs_array;

    }

    static function check_company()
    {
        $companies = Company::all();
        $count_c = 0;
        $user_b_id = auth()->user()->branch_id;
        $user_c_id = 0;

        $companys_array = [];

        if ($user_b_id) {
            $user_c_id = Branches::find($user_b_id)->company_id;
        }

        foreach ($companies as $company) {
            if (Auth::user()->isAbleTo('Company_' . $company->id)) {
                $count_c = $count_c + 1;
                $companys_array[] = $company->id;
            }
        }

        if ($count_c == 0) {
            $companys_array[] = $user_c_id;
        }

        return $companys_array;
    }

    static function branch_company()
    {
        //$branch_id=   auth()->user()->branch_id;
        //$branch= \App\Models\Branches::find($branch_id);
        //$Company=\App\Models\Company::find($branch->company_id);
        $company_session = Session::get('company_session');
        $branch_session = Session::get('branch_session');
        $companies = Company::all();
        $branchs = Branches::where('company_id', $company_session)->get();
        $count_c = 0;
        $count_b = 0;
        $user_b_id = auth()->user()->branch_id;
        $user_c_id = 0;
        if ($user_b_id) {
            $user_c_id = Branches::find($user_b_id)->company_id;
        }
        foreach ($companies as $company) {
            if (Auth::user()->isAbleTo('Company_' . $company->id)) {
                $count_c = $count_c + 1;
            }
        }

        foreach ($branchs as $item) {
            if (Auth::user()->isAbleTo('Branch_' . $item->id)) {

                $count_b = $count_b + 1;
            }
        }

        if ($count_c == 0) {
            Session::put('company_session', $user_c_id);
        }


        if ($count_b == 0) {
            Session::put('branch_session', $user_b_id);
        }

        $company_session = Session::get('company_session');
        $branch_session = Session::get('branch_session');
        if (!$company_session) {
            $company_session = 0;
        }
        if (!$branch_session) {
            $branch_session = 0;
        }

        return [
            'company_session' => $company_session,
            'branch_session' => $branch_session,
            'user_c_id' => $user_c_id,
            'user_b_id' => $user_b_id,
            'count_c' => $count_c,
            'count_b' => $count_b,
            'companies' => $companies,
            'branchs' => $branchs,
        ];

    }


    static function check_branch_company($coompny_id = 0)
    {
        if ($coompny_id == 0) {
            $company_session = Session::get('company_session');
        } else {
            $company_session = $coompny_id;
        }

        $branchs = Branches::where('company_id', $company_session)->get();
        $count_b = 0;
        $user_b_id = auth()->user()->branch_id;

        $branchs_array = [];

        foreach ($branchs as $item) {
            if (Auth::user()->isAbleTo('Branch_' . $item->id)) {
                $count_b = $count_b + 1;
                $branchs_array[] = $item->id;
            }
        }

        if ($count_b == 0) {
            $branchs_array[] = $user_b_id;
        }

        return $branchs_array;

    }


}
