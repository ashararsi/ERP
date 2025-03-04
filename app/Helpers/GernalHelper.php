<?php

namespace App\Helpers;

use App\Models\Branches;
use App\Models\Company;
use App\Models\FinancialYear;
use App\Models\Months;
use Auth;
use Session;

class GernalHelper
{
    /**
     * This function formats the currency as per the currency format in account settings
     *
     * $input format is xxxxxxx.xx
     */

    static function monthdropdown()
    {
        $array_month = [];
        $html = " <option>Select Month</option>";
        $months = Months::orderBy('id', 'asc')->get();

        foreach ($months as $month) {

            $year_number = date('Y');
            $month_id = date('m');

            if ($month->id <= 6) {

                $year_number = $year_number + 1;
                if ($month_id < 7) {
                    $year_number = $year_number - 1;
                }

                // $html=$html."   <option value='".$month->id."-".$year_number."'>".$month->title ."-".$year_number."</option>";

            } else {
                $year_number = $year_number + 1;
                $year_number = $year_number - 1;
            }
            $html = $html . "   <option value='" . $month->id . "-" . $year_number . "'>" . $month->title . "-" . $year_number . "</option>";

            $array_month[] = $month->id . "-" . $year_number;
        }

        $title_m = '';
        $year_number = date('Y');
        $month_id = date('m');
        if ($month_id > 1) {
            $month_id = $month_id - 1;
        } else {
            $month_id = 12;
            $year_number = $year_number - 1;
        }
        $m_data = Months::find($month_id);

        if ($m_data) {
            $title_m = $m_data->title;
        }

        $check_date = $month_id . "-" . $year_number;
        if (!in_array($check_date, $array_month)) {
            $html = $html . " <option value='" . $month_id . "-" . $year_number . "'>" . $title_m . "-" . $year_number . "</option> <option value='13-2022'>July Teacher-2022</option>";

        }

        return $html;


    }

    static function get_financial_year()
    {
        $financial_year = array();
        if (isset(auth()->user()->roles[0])) {
            $role = auth()->user()->roles[0]->name;
            if ($role == 'accounts-manager' || $role == 'administrator') {
                $financial_year = FinancialYear::get();
            } else {
                $financial_year = FinancialYear::where('status', 1)->get();
            }
        }
        return $financial_year;
    }

}
