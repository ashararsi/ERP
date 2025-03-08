<?php

namespace App\Helpers;

use App\Models\Branch;
use App\Models\Company;
use App\Models\Entries;
use App\Models\EntryItems;
use App\Models\ErpFeeHead;
use App\Models\FeeHead;
use App\Models\FinancialYear;
use App\Models\Groups;
use App\Models\Ledger;
use App\Models\Student;
use App\Models\StaffSalaries;
use App\Helpers\Currency;
use Validator;
use Config;
use DB;
use Illuminate\Support\Facades\Auth;
use Session;

//use App\Rules\BranchIdMatch;
use Illuminate\Validation\ValidationException;


class CoreAccounts
{

    /*
     * Generate leading numbers and put before provided number
     *
     * @param: (int) $number
     * @return (int) $number
      */


    static function generateNumber($number)
    {
        return sprintf('%06d', $number);
    }

    static function generateItemcode($chr, $number)
    {
        $code = sprintf('%06d', $number);
        return $code . $chr;
    }

    /*
     * Generate leading numbers and put before provided number
     *
     * @param: (int) $number
     * @return (int) $number
      */
    static function generateCode($number)
    {
        return sprintf('%04d', $number);
    }

    /*
     * Generate ledger numbers
     *
     * @param: (int) $number
     * @return (int) $number
      */
    static function generateLedgerNumber($companyId, $group_id, $groupNumber)
    {
        //dd($ledgerNumber);
        //return $companyId . '-' . $groupNumber . '-' . sprintf('%04d',$ledgerNumber);
        return $groupNumber . '-' . sprintf('%04d', (Ledger::where(['company_id' => $companyId, 'group_id' => $group_id])->count()));
    }

    /**
     * Perform a decimal level calculations on two numbers
     *
     * Multiply the float by 100, convert it to integer,
     * Perform the integer operation and then divide the result
     * by 100 and return the result
     *
     * @param1 float number 1
     * @param2 float number 2
     * @op string operation to be performed
     * @return float result of the operation
     */

    static function calculate($param1 = 0, $param2 = 0, $op = '')
    {
        $decimal_places = Currency::_decimal_places();

        $param1 = number_format((float)$param1, $decimal_places, '.', '');
        $param2 = number_format((float)$param2, $decimal_places, '.', '');

        if (extension_loaded('bcmath')) {
            switch ($op) {
                case '+':
                    return bcadd($param1, $param2, $decimal_places);
                    break;
                case '-':
                    return bcsub($param1, $param2, $decimal_places);
                    break;
                case '==':
                    if (bccomp($param1, $param2, $decimal_places) == 0) {
                        return TRUE;
                    } else {
                        return FALSE;
                    }
                    break;
                case '!=':
                    if (bccomp($param1, $param2, $decimal_places) == 0) {
                        return FALSE;
                    } else {
                        return TRUE;
                    }
                    break;
                case '<':
                    if (bccomp($param1, $param2, $decimal_places) == -1) {
                        return TRUE;
                    } else {
                        return FALSE;
                    }
                    break;
                case '>':
                    if (bccomp($param1, $param2, $decimal_places) == 1) {
                        return TRUE;
                    } else {
                        return FALSE;
                    }
                    break;
                case '>=':
                    $temp = bccomp($param1, $param2, $decimal_places);
                    if ($temp == 1 || $temp == 0) {
                        return TRUE;
                    } else {
                        return FALSE;
                    }
                    break;
                case 'n':
                    return bcmul($param1, -1, $decimal_places);
                    break;
                default:
                    die();
                    break;
            }
        } else {
            $result = 0;

            if ($decimal_places == 2) {
                $param1 = $param1 * 100;
                $param2 = $param2 * 100;
            } else if ($decimal_places == 3) {
                $param1 = $param1 * 1000;
                $param2 = $param2 * 1000;
            }

            $param1 = (int)round($param1, 0);
            $param2 = (int)round($param2, 0);
            switch ($op) {
                case '+':
                    $result = $param1 + $param2;
                    break;
                case '-':
                    $result = $param1 - $param2;
                    break;
                case '==':
                    if ($param1 == $param2) {
                        return TRUE;
                    } else {
                        return FALSE;
                    }
                    break;
                case '!=':
                    if ($param1 != $param2) {
                        return TRUE;
                    } else {
                        return FALSE;
                    }
                    break;
                case '<':
                    if ($param1 < $param2) {
                        return TRUE;
                    } else {
                        return FALSE;
                    }
                    break;
                case '>':
                    if ($param1 > $param2) {
                        return TRUE;
                    } else {
                        return FALSE;
                    }
                    break;
                case '>=':
                    if ($param1 >= $param2) {
                        return TRUE;
                    } else {
                        return FALSE;
                    }
                    break;
                case 'n':
                    $result = -$param1;
                    break;
                default:
                    die();
                    break;
            }

            if ($decimal_places == 2) {
                $result = $result / 100;
            } else if ($decimal_places == 3) {
                $result = $result / 100;
            }

            return $result;
        }
    }

    /**
     * Perform a calculate with Debit and Credit Values
     *
     * @param1 float number 1
     * @param2 char nuber 1 debit or credit
     * @param3 float number 2
     * @param4 float number 2 debit or credit
     * @return array() result of the operation
     */
    static function calculate_withdc_extend($param1, $param1_dc, $param2, $param2_dc)
    {
        $result = 0;
        $result_dc = 'd';
        if ($param1_dc == 'd' && $param2_dc == 'd') {
            $result = self::calculate($param1, $param2, '+');
            $result_dc = 'd';
        } else if ($param1_dc == 'c' && $param2_dc == 'c') {
            $result = self::calculate($param1, $param2, '+');
            $result_dc = 'c';
        } else {
            if (self::calculate($param1, $param2, '>')) {
                $result = self::calculate($param1, $param2, '-');
                $result_dc = $param1_dc;
            } else {
                $result = self::calculate($param2, $param1, '-');
                $result_dc = $param2_dc;
            }
        }

        return array('amount' => $result, 'dc' => $result_dc);
    }

    static function calculate_withdc($param1, $param1_dc, $param2, $param2_dc)
    {
        $result = 0;
        $result_dc = 'd';
        if ($param1_dc == 'd' && $param2_dc == 'd') {
            $result = self::calculate($param1, $param2, '+');
            $result_dc = 'd';
        } else if ($param1_dc == 'c' && $param2_dc == 'c') {
            $result = self::calculate($param1, $param2, '+');
            $result_dc = 'c';
        } else {
            if (self::calculate($param1, $param2, '>')) {
                $result = self::calculate($param1, $param2, '-');
                $result_dc = $param1_dc;
            } else {
                $result = self::calculate($param2, $param1, '-');
                $result_dc = $param2_dc;
            }
        }

        return array('amount' => $result, 'dc' => $result_dc);
    }

    static function toCurrency($dc, $amount)
    {

        $decimal_places = Currency::_decimal_places();

        if (self::calculate($amount, 0, '==')) {
            return Currency::curreny_format(number_format(0, $decimal_places, '.', ''));
        }

        if ($dc == 'd') {
            if (self::calculate($amount, 0, '>')) {
                //     return 'Dr ' . Currency::curreny_format(number_format($amount, $decimal_places, '.', ''));
                return Currency::curreny_format(number_format($amount, $decimal_places, '.', ''));
            } else {
                //    return 'Cr ' . Currency::curreny_format(number_format(self::calculate($amount, 0, 'n'), $decimal_places, '.', ''));
                return Currency::curreny_format(number_format(self::calculate($amount, 0, 'n'), $decimal_places, '.', ''));
            }
        } else if ($dc == 'c') {
            if (self::calculate($amount, 0, '>')) {
                //    return  Currency::curreny_format(number_format($amount, $decimal_places, '.', ''));
                return Currency::curreny_format(number_format($amount, $decimal_places, '.', ''));
            } else {
                //    return 'Dr ' . Currency::curreny_format(number_format(self::calculate($amount, 0, 'n'), $decimal_places, '.', ''));
                return Currency::curreny_format(number_format(self::calculate($amount, 0, 'n'), $decimal_places, '.', ''));
            }
        } else if ($dc == 'x') {
            /* Dr for positive and Cr for negative value */
            if (self::calculate($amount, 0, '>')) {
                //   return 'Dr ' . Currency::curreny_format(number_format($amount, $decimal_places, '.', ''));
                return Currency::curreny_format(number_format($amount, $decimal_places, '.', ''));
            } else {
                //   return 'Cr ' . Currency::curreny_format(number_format(self::calculate($amount, 0, 'n'), $decimal_places, '.', ''));
                return Currency::curreny_format(number_format(self::calculate($amount, 0, 'n'), $decimal_places, '.', ''));
            }
        } else {
            return Currency::curreny_format(number_format($amount, $decimal_places, '.', ''));
        }
    }

    /*
     * Get Setting by config id
     *
     * @param: (int) $id
     * @return (array) $response
     */
    public static function getConfigSettingID($id)
    {
        if ($Setting = Settings::where(['id' => $id])->first()) {
            return array(
                'status' => true,
                'id' => $Setting->description,
                'error' => ''
            );
        } else {
            return array(
                'status' => false,
                'id' => false,
                'error' => 'Setting not found.'
            );
        }
    }

    /*
     * Get Group by setting based config id
     *
     * @param: (int) $id
     * @return (array) $response
     */
    public static function getConfigGroup($id)
    {
        //$response = self::getConfigSettingID($id);
        //if($response['status']) {
        \Log::info("-----------svhuhg------");
        \Log::info($id);
        if ($Group = Groups::where(['id' => $id])->first()) {

            return array(
                'status' => true,
                'group' => $Group,
                'error' => ''
            );
        }
        //}
        //unset($response['id']);
        $response['group'] = '';
        return $response;
    }

    /*
     * Generate Number in Accounting
     *
     * @param  ind  $id
     * @return mixed $respose
     */
    private static function generateLevelAndNumber($parent_id, $adittional_number = 0)
    {

        $ParentGroup = Groups::findOrFail($parent_id);
        return array(
            'number' => $ParentGroup->number . '-' . sprintf('%0' . (count(explode('-', $ParentGroup->number)) + 1) . 'd', (Groups::where(['parent_id' => $ParentGroup->id])->count() + ($adittional_number + 1))),
            'level' => ++$ParentGroup->level,
        );
    }

    /*
     * Verify Parent Group in Accounting
     *
     * @param  ind  $id
     * @return mixed $respose
     */
    private static function verifyGroupNumber($old_number, $new_number)
    {
        if (count(explode('-', $old_number)) == count(explode('-', $new_number))) {
            return true;
        } else {
            return false;
        }
    }

    /*
     * Create Group in Accounting
     *
     * @param  \App\Http\Requests\Admin\Groups\StoreUpdateRequest  $data
     * @return (array) $respose
     */
    public static function createGroup($data)
    {

        $rules = [
            'name' => 'required',
            'parent_id' => 'required',
        ];

        $validator = Validator::make($data, $rules);
        if ($validator->fails()) {
            return array(
                'status' => false,
                'error' => $validator
            );
        }

        if (!$Group = Groups::where(['id' => $data['parent_id']])->first()) {
            return array(
                'status' => false,
                'error' => 'Parent Group ID does not exists'
            );
        } else {
            if (isset($data['company_id'])) {
                $data['company_id'] = $data['company_id'];
            }
            if (isset($data['city_id'])) {
                $data['city_id'] = $data['city_id'];
            }
            if (isset($data['branch_id'])) {
                $data['branch_id'] = $data['branch_id'];
            }
            $data['created_by'] = Auth::user()->id;
            $data['updated_by'] = Auth::user()->id;
            $data['account_type_id'] = $Group->account_type_id;
            $data['parent_id'] = $Group->id;

            // Get Next Level and Next number to identify
            $levelAndNumber = self::generateLevelAndNumber($Group->id, 0);

            $data['number'] = $levelAndNumber['number'];
            $data['level'] = $levelAndNumber['level'];
            $Groups = Groups::create($data);
            return array(
                'status' => true,
                'error' => 'Group has been created',
                'id' => $Groups->id,
            );
        }
    }

    public static function createCustomGroup($parent_head, $product_array, $StockCategory, $name, $parent_type)
    {

        for ($i = 1; $i <= count($parent_head); $i++) {
            //dd($parent_type);
            if ($i == 1) {
                $data['name'] = 'Stock-' . $name;
            } elseif ($i == 2) {
                $data['name'] = 'Sales-' . $name;
            } else {
                $data['name'] = 'COS-' . $name;
            }
            $data['parent_id'] = $parent_head[$i];
            $data['parent_type'] = $parent_type;
            $data['created_by'] = Auth::user()->id;
            $data['updated_by'] = Auth::user()->id;
            $data['account_type_id'] = 1;

            // Get Next Level and Next number to identify
            $levelAndNumber = self::generateLevelAndNumber($parent_head[$i], 0);

            $data['number'] = $levelAndNumber['number'];
            $data['level'] = $levelAndNumber['level'];
            $Groups = Groups::create($data);
            $last_record_id = Groups::all()->last()->id;
            $product_count = $last_record_id;
            foreach ($product_array as $key => $value) {
                $dataa['name'] = $value;
                $dataa['parent_id'] = $product_count;
                $dataa['parent_type'] = $key;
                $dataa['created_by'] = Auth::user()->id;
                $dataa['updated_by'] = Auth::user()->id;
                $dataa['account_type_id'] = 1;
                // Get Next Level and Next number to identify
                $levelAndNumber = self::generateLevelAndNumber($product_count, 0);
                $dataa['number'] = $levelAndNumber['number'];
                $dataa['level'] = $levelAndNumber['level'];
                $Groups = Groups::create($dataa);
                $last_record_id = Groups::all()->last()->id;
                $category_count = $last_record_id;
                foreach ($StockCategory as $index => $dat) {
                    $dataaa['name'] = $dat;
                    $dataaa['parent_id'] = $category_count;
                    $dataaa['parent_type'] = $index;
                    $dataaa['created_by'] = Auth::user()->id;
                    $dataaa['updated_by'] = Auth::user()->id;
                    $dataaa['account_type_id'] = 1;
                    // Get Next Level and Next number to identify
                    $levelAndNumber = self::generateLevelAndNumber($category_count, 0);

                    $dataaa['number'] = $levelAndNumber['number'];
                    $dataaa['level'] = $levelAndNumber['level'];
                    $Groups = Groups::create($dataaa);
                }
            }
        }
    }

    /*
     * Create Group in Accounting
     *
     * @param  \App\Http\Requests\Admin\Groups\StoreUpdateRequest  $data
     * @return (array) $respose
     */
    public static function updateGroup($data, $id)
    {
        $rules = [
            'name' => 'required',
            'parent_id' => 'required',
        ];

        $validator = Validator::make($data, $rules);
        if ($validator->fails()) {
            return array(
                'status' => false,
                'error' => $validator->errors()
            );
        }

        if (!$Group = Groups::where(['id' => $id])->first()) {
            return array(
                'status' => false,
                'error' => 'No Group ID found.'
            );
        }

        // Those Groups can't be moved who have child groups or Ledger associagted with it.
        if ((Groups::hasChildLedger($Group->id) || Groups::hasChildGroups($Group->id)) && $Group->parent_id != $data['parent_id']) {
            return array(
                'status' => false,
                'error' => 'Parent Group can not be changed due to one or more Group(s) / Ledger(s) are associated with."' . $Group->name . '" group.'
            );
        } else {
            if (!$ParentGroup = Groups::where(['id' => $data['parent_id']])->first()) {
                return array(
                    'status' => false,
                    'error' => 'Parent Group ID does not exists'
                );
            } else {
                $levelAndNumber = self::generateLevelAndNumber($ParentGroup->id);
                // Set Current Level
                $data['level'] = $levelAndNumber['level'];
                if (!self::verifyGroupNumber($Group->number, $levelAndNumber['number'])) {
                    $data['number'] = $levelAndNumber['number'];
                }
                $data['updated_by'] = Auth::user()->id;
                $data['account_type_id'] = $ParentGroup->account_type_id;

                $Group->update($data);

                return array(
                    'status' => true,
                    'error' => 'Group has been created'
                );
            }
        }
    }

    /*
     * Create Ledger in Accounting
     *
     * @param (array) $data
     * @return (array) $response
     */
    public static function createLedger($data)
    {
        $rules = [
            'name' => 'required',
            'group_id' => 'required',
            //'balance_type' => 'required',
            'opening_balance' => 'required|numeric',
        ];

        $validator = Validator::make($data, $rules);
        if ($validator->fails()) {
            return array(
                'status' => false,
                'error' => $validator->errors()
            );
        }

        $data['created_by'] = Auth::user()->id;

        // Get selected group
        if (!$Group = Groups::where(['id' => $data['group_id']])->first()) {
            return array(
                'status' => false,
                'error' => 'Group ID does not exists'
            );
        } else {

            // Get Default Company

            // $Companie = Company::findOrFail(Config::get('constants.accounts_company_id'));

            if ($data['balance_type']) {
                $balance_type = $data['balance_type'];
            } else {
                if ($Group->account_type_id == 1 || $Group->account_type_id == 3) {
                    $balance_type = 'd';
                } else {
                    $balance_type = 'c';
                }
            }

            $data['group_id'] = $Group->id;
            $data['group_number'] = $Group->number;
            $data['account_type_id'] = $Group->account_type_id;
            $data['balance_type'] = $balance_type;
            $Ledger = Ledger::create($data);
            $Ledger->update(['number' => CoreAccounts::generateLedgerNumber($Ledger->company_id, $Group->id, $Group->number)]);

            return array(
                'status' => true,
                'error' => 'Ledger has been created',
                'id' => $Ledger->id
            );
        }
    }

    /*
     * Create Ledger in Accounting
     *
     * @param (array) $data
     * @return (array) $response
     */
    public static function updateLedger($data, $id)
    {
        // dd($data);
        $rules = [
            'name' => 'required',
            'group_id' => 'required',
            //'balance_type' => 'required',
            'opening_balance' => 'required|numeric',
        ];

        $validator = Validator::make($data, $rules);
        if ($validator->fails()) {
            return array(
                'status' => false,
                'error' => $validator->errors()
            );
        }

        if (!$Ledger = Ledger::where(['id' => $id])->first()) {
            return array(
                'status' => false,
                'error' => 'No Ledger ID found.'
            );
        }

        $data['updated_by'] = Auth::user()->id;
        // Get selected group
        if (!$Group = Groups::where(['id' => $data['group_id']])->first()) {
            return array(
                'status' => false,
                'error' => 'Group ID does not exists'
            );
        } else {
            $data['group_id'] = $Group->id;
            $data['group_number'] = $Group->number;
            $data['account_type_id'] = $Group->account_type_id;
            //$data['opening_balance'] = $data['opening_balance'];

            $Ledger->update($data);

            return array(
                'status' => true,
                'error' => 'Ledger has been updated'
            );
        }
    }


    public static function createLcInventory($data)
    {

        //dd($data);
        $rules = [
            'voucher_date' => 'required',
            'entry_type_id' => 'required|numeric',
            'branch_id' => 'required|numeric',
            'employee_id' => 'required|numeric',
            'department_id' => 'sometimes|nullable|numeric',
            'narration' => 'required',
            'cr_total' => 'required',
            'diff_total' => 'required|numeric|min:0|max:0',
            'entry_items' => 'required',
        ];
        $rules['entry_items.ledger_id.1'] = 'required';
        $rules['entry_items.ledger_id.2'] = 'required';
        $rules['entry_items.dr_amount.2'] = 'required_if:entry_items.dr_amount,0|numeric';

        $validator = Validator::make($data, $rules);

        if ($validator->fails()) {
            return array(
                'status' => false,
                'error' => $validator->errors()
            );
        }
        $data['dr_total'] = $data['cr_total'];
        $data['created_by'] = Auth::user()->id;
        $data['updated_by'] = Auth::user()->id;
        $data['status'] = 0;
        //dd($data);
        $entry = Entries::create($data);
        $entry->update(array(
            'number' => CoreAccounts::generateNumber($entry->id),
        ));

        /*
         * Create Entry Items records associated to Etnry now
         */
        $entry_items = array();
        foreach ($data['entry_items']['counter'] as $key => $val) {
            $item = array(
                'status' => 0,
                'entry_type_id' => $data['entry_type_id'],
                'entry_id' => $entry->id,
                'voucher_date' => $data['voucher_date'],
                'ledger_id' => $data['entry_items']['ledger_id'][$val],
                'narration' => $data['narration'],
            );
            if ($key == '1') {
                $item['amount'] = $data['cr_total'];
                $item['dc'] = 'c';
            } else {
                $item['amount'] = $data['cr_total'];
                $item['dc'] = 'd';
            }
            $entry_items[] = $item;
        }
        //dd($entry_items);

        // EntryItems::insert($entry_items);
        //        foreach($entry_items as $value){
        //            $ledger_id = $value['ledger_id'];
        //            $Ledger = Ledger::where(['id' => $ledger_id])->get();
        //            $closing_balance = $Ledger[0]->closing_balance;
        //            if($value['dc']=='c'){
        //                $nclosebalnc = $closing_balance - $value['amount'];
        //                DB::table('Ledger')
        //                    ->where('id',$ledger_id)
        //                    ->update(['closing_balance' => $nclosebalnc]);
        //            }else{
        //                $nclosebalnc = $closing_balance + $value['amount'];
        //                DB::table('Ledger')
        //                    ->where('id',$ledger_id)
        //                    ->update(['closing_balance' => $nclosebalnc]);
        //            }
        //
        //        }


        return array(
            'status' => true,
            'error' => 'Ledger has been created'
        );
    }

    /*
  * Create LCEntry voucher in Accounting
  *
  * @param (array) $data
  * @return (array) $response
  */
    public static function createLcEntry($data)
    {
        // dd($data);
        $data['entry_items']['narration'][1] = $data['narration'];

        $rules = [
            'voucher_date' => 'required',
            'entry_type_id' => 'required|numeric',
            //'branch_id' => 'required|numeric',
            //'employee_id' => 'required|numeric',
            //'department_id' => 'sometimes|nullable|numeric',
            'narration' => 'required',
            'dr_total' => 'required|numeric|min:1|same:cr_total',
            'cr_total' => 'required|numeric|min:1|same:dr_total',
            'diff_total' => 'required|numeric|min:0|max:0',
            'entry_items' => 'required',
        ];

        if (isset($data['entry_items']) && count($data['entry_items'])) {
            $entry_items = $data['entry_items'];
            foreach ($entry_items['counter'] as $key => $val) {
                $rules['entry_items.ledger_id.' . $val] = 'required';
                $rules['entry_items.dr_amount.' . $val] = 'required_if:entry_items.cr_amount,0|numeric';
                $rules['entry_items.cr_amount.' . $val] = 'required_if:entry_items.dr_amount,0|numeric';
                $rules['entry_items.lc_duties.' . $val] = 'required';
                $rules['entry_items.narration.' . $val] = 'required';
            }
        }

        $validator = Validator::make($data, $rules);
        if ($validator->fails()) {
            return array(
                'status' => false,
                'error' => $validator->errors()
            );
        }

        $data['created_by'] = Auth::user()->id;
        $data['updated_by'] = Auth::user()->id;
        $data['employee_id'] = Auth::user()->id;
        $data['branch_id'] = Auth::user()->branch_id;
        $data['status'] = 0;
        //        $entry = Entries::create($data);
        //        $entry->update(array(
        //            'number' => CoreAccounts::generateNumber($entry->id),
        //        ));

        /*
         * Create Entry Items records associated to Etnry now
         */
        $entry_items = array();
        $lc_items = array();
        $lc_duties = array();
        foreach ($data['entry_items']['counter'] as $key => $val) {
            if ($val != 1) {
                $ComercialInvoiceModel = ComercialInvoiceModel::where('id', $data['entry_items']['ledger_id'][$val])->first();
                $lcID = Ledger::where(['parent_type' => $ComercialInvoiceModel->lcno])->first();
                $lc_items['duties'] = $data['entry_items']['lc_duties'][$val];
                $lc_items['ledgerLc_id'] = $ComercialInvoiceModel->lcno;
                $lc_items['Comercial_id'] = $ComercialInvoiceModel->id;
                $lc_items['created_by'] = Auth::user()->id;
                $lc_items['created_at'] = date('Y-m-d');
                $item['ledger_id'] = $lcID->id;
            }
            $item = array(
                'status' => 0,
                'entry_type_id' => $data['entry_type_id'],
                //'entry_id' => $entry->id,
                'voucher_date' => $data['voucher_date'],
                'ledger_id' => $data['entry_items']['ledger_id'][$val],
                'narration' => $data['entry_items']['narration'][$val],
            );
            if ($data['entry_items']['dr_amount'][$val]) {
                $item['amount'] = $data['entry_items']['dr_amount'][$val];
                $item['dc'] = 'd';
                $lc_items['amount'] = $item['amount'];
            } else {
                $item['amount'] = $data['entry_items']['cr_amount'][$val];
                $item['dc'] = 'c';
            }
            $entry_items[] = $item;
            if (!empty($lc_items)) {
                //$checkCosting = LcDutyModel::where('id',$lc_items)->first();
                //dd($checkCosting);
                $lc_duties[] = $lc_items;
            }
        }
        // $lc_duties = array_filter($lc_duties);
        EntryItems::insert($entry_items);
        LcDutyModel::insert($lc_duties);
        return array(
            'status' => true,
            'error' => 'Ledger has been created'
        );
    }

    /*
     * Create Entry in Accounting
     *
     * @param (array) $data
     * @return (array) $response
     */
    public static function createEntry($data)
    {

        $originalDate = $data['voucher_date'];
        $newDate = date("Y-m-d", strtotime($originalDate));
        $data['voucher_date'] = $newDate;
        $rules = [
            'financial_year' => 'required',
            'voucher_date' => 'required',
            'entry_type_id' => 'required|numeric',
            'company_id' => 'required|numeric',
            'narration' => 'required',
            'dr_total' => 'required|numeric|min:1|same:cr_total',
            'cr_total' => 'required|numeric|min:1|same:dr_total',
            'diff_total' => 'required|numeric|min:0|max:0',
            'entry_items' => 'required',
        ];

        if (isset($data['entry_items']) && count($data['entry_items'])) {
            $entry_items = $data['entry_items'];
            foreach ($entry_items['counter'] as $key => $val) {
                if ($key != '######') {
                    $rules['entry_items.ledger_id.' . $val] = 'required';
                    $rules['entry_items.dr_amount.' . $val] = 'required_if:entry_items.cr_amount,0|numeric';
                    $rules['entry_items.cr_amount.' . $val] = 'required_if:entry_items.dr_amount,0|numeric';
                    $rules['entry_items.narration.' . $val] = 'required';
                }
            }
        }

        $validator = Validator::make($data, $rules);

        if ($validator->fails()) {
            return array(
                'status' => false,
                'error' => $validator->errors()
            );
        }

        $data['created_by'] = Auth::user()->id;
        $data['updated_by'] = Auth::user()->id;
        $data['employee_id'] = Auth::user()->id;

        $data['branch_id'] = (Session::get('branch_session') ? Session::get('branch_session') : Auth::user()->branch_id);
        $v_number_series = CoreAccounts::getVouchertMaxId($data['entry_type_id'], $data['company_id'], $data['financial_year']);
        $data['company_id'] = (isset($data['company_id'])) ? $data['company_id'] : NULL;
        $data['number'] = str_pad($v_number_series, 6, '0', STR_PAD_LEFT);

        $data['status'] = 0;

        $entry = Entries::create($data);
        $entry_items = array();
        foreach ($data['entry_items']['counter'] as $key => $val) {
            if ($key != '######') {
                $item_ladger_id = $data['entry_items']['ledger_id'][$val];

                $item = array(
                    'status' => 0,
                    'entry_type_id' => $data['entry_type_id'],
                    'entry_id' => $entry->id,
                    'voucher_date' => $data['voucher_date'],
                    'ledger_id' => $data['entry_items']['ledger_id'][$val],
                    'narration' => $data['entry_items']['narration'][$val],
                    'instrument_number' => (isset($data['entry_items']['instrument_number'][$val])) ? $data['entry_items']['instrument_number'][$val] : NULL,
                    'vendor_id' => (isset($data['entry_items']['vendor_id'][$val])) ? $data['entry_items']['vendor_id'][$val] : NULL
                );
                if ($data['entry_items']['dr_amount'][$val]) {
                    $item['amount'] = $data['entry_items']['dr_amount'][$val];
                    $item['dc'] = 'd';
                } else {
                    $item['amount'] = $data['entry_items']['cr_amount'][$val];
                    $item['dc'] = 'c';
                }
                $entry_items[] = $item;
            }
        }

        EntryItems::insert($entry_items);
        return array(
            'status' => true,
            'error' => 'Ledger has been created',
            'entry' => $entry->id,
        );


    }

    public static function createFeeEntry($data)
    {
        $student_details = Student::find($data['students_id']);
        $data['created_by'] = Auth::user()->id;
        $data['updated_by'] = Auth::user()->id;
        $data['employee_id'] = Auth::user()->id;
        $data['branch_id'] = $data['branch_id'];
        $data['narration'] = $student_details->reg_no . ' ' . $student_details->first_name . ' ' . $student_details->last_name;
        $data['status'] = 0;
        $entry = Entries::create($data);
        $entry->update(array(
            'number' => CoreAccounts::generateNumber($entry->id),
        ));

        return $entry->id;
    }


    public static function updateFeeEntryAmount($data)
    {

        Entries::where(['id' => $data['entry_id']])->update(['dr_total' => $data['amount'], 'cr_total' => $data['amount']]);

        return $data['entry_id'];
    }

    public static function createFeeEntryItems($data)
    {

        //        $local_fee_head = FeeHead::find($data['fee_head_id']);
        $student_details = Student::find($data['students_id']);

        $fee_head = ErpFeeHead::find($data['fee_head_id']);

        $rec_ledger = Ledger::where([
            'group_id' => $fee_head->rec_group_id,
            'branch_id' => $data['branch_id']
        ])->first();

        $inc_ledger = Ledger::where([
            'group_id' => $fee_head->inc_group_id,
            'branch_id' => $data['branch_id']
        ])->first();

        /*
         * Create Entry Items records associated to Etnry now
         */
        $item = array(
            'status' => 0,
            'entry_type_id' => $data['entry_type_id'],
            'entry_id' => $data['entry_id'],
            'voucher_date' => $data['voucher_date'],
            'ledger_id' => @$rec_ledger->id,
            'narration' => $student_details->reg_no . ' ' . $student_details->first_name . ' ' . $student_details->last_name,
        );
        $item['amount'] = $data['dr_total'];
        $item['dc'] = 'd';

        $entry_item_d[] = $item;
        $entry_item_dr = EntryItems::insert($entry_item_d);
        $entry_item_dr_id = EntryItems::orderBy('id', 'desc')->first();
        $item = array(
            'status' => 0,
            'entry_type_id' => $data['entry_type_id'],
            'entry_id' => $data['entry_id'],
            'voucher_date' => $data['voucher_date'],
            'ledger_id' => @$inc_ledger->id,
            'narration' => $student_details->reg_no . ' ' . $student_details->first_name . ' ' . $student_details->last_name,
        );
        $item['amount'] = $data['cr_total'];
        $item['dc'] = 'c';
        $entry_item_c[] = $item;

        $entry_item_cr = EntryItems::insert($entry_item_c);
        $entry_item_cr_id = EntryItems::orderBy('id', 'desc')->first();

        $res = array(
            'entry_item_dr' => $entry_item_dr_id->id,
            'entry_item_cr' => $entry_item_cr_id->id
        );
        return $res;
    }


    public static function createFeeTaxEntry($data)
    {

        $student_details = Student::find($data['students_id']);

        $rec_tax_ledger = Ledger::where([
            'group_id' => Config::get('constants.tax_236i_receiveable_group_id'),
            'branch_id' => $data['branch_id']
        ])->first();

        $pay_tax_ledger = Ledger::where([
            'group_id' => Config::get('constants.tax_236i_payable_group_id'),
            'branch_id' => $data['branch_id']
        ])->first();

        /*
         * Create Entry Items records associated to Etnry now
         */
        $item = array(
            'status' => 0,
            'entry_type_id' => $data['entry_type_id'],
            'entry_id' => $data['entry_id'],
            'voucher_date' => $data['voucher_date'],
            'ledger_id' => $rec_tax_ledger->id,
            'narration' => $student_details->reg_no . ' ' . $student_details->first_name . ' ' . $student_details->last_name,
        );
        $item['amount'] = $data['dr_total'];
        $item['dc'] = 'd';

        $entry_items_d[] = $item;
        EntryItems::insert($entry_items_d);
        $entry_item_dr_id = EntryItems::orderBy('id', 'desc')->first();
        $item = array(
            'status' => 0,
            'entry_type_id' => $data['entry_type_id'],
            'entry_id' => $data['entry_id'],
            'voucher_date' => $data['voucher_date'],
            'ledger_id' => $pay_tax_ledger->id,
            'narration' => $student_details->reg_no . ' ' . $student_details->first_name . ' ' . $student_details->last_name,
        );
        $item['amount'] = $data['cr_total'];
        $item['dc'] = 'c';
        $entry_items[] = $item;

        EntryItems::insert($entry_items);

        $entry_item_cr_id = EntryItems::orderBy('id', 'desc')->first();

        $res = array(
            'entry_item_dr' => $entry_item_dr_id->id,
            'entry_item_cr' => $entry_item_cr_id->id
        );
        return $res;
    }

    public static function updateFeeEntry($data)
    {

        if (!$Entrie = Entries::where(['id' => $data['entry_id']])->first()) {
            return array(
                'status' => false,
                'error' => 'No Entry ID found.'
            );
        } else {
            $data['updated_by'] = Auth::user()->id;
            $data['cr_total'] = $data['cr_total'];
            $data['dr_total'] = $data['dr_total'];
            $Entrie->update($data);
        }
        EntryItems::where(['id' => $data['entry_id']])->update(['amount' => $data['dr_total']]);
        EntryItems::where(['id' => $data['entry_id']])->update(['amount' => $data['cr_total']]);

        return $data['entry_id'];
    }

    public static function getBankLedger($data)
    {

        $Ledger = Ledger::where([
            'group_id' => Config::get('constants.account_bank_balance_group_id'),
            'branch_id' => $data['branch_id']
        ])->get();

        return $Ledger;
    }

    public static function createFeeBankPaymentEntry($data)
    {
        $student_details = Student::find($data['students_id']);
        $data['created_by'] = Auth::user()->id;
        $data['updated_by'] = Auth::user()->id;
        $data['employee_id'] = Auth::user()->id;
        $data['branch_id'] = $data['branch_id'];
        $data['narration'] = $student_details->reg_no . ' ' . $student_details->first_name . ' ' . $student_details->last_name;
        $data['status'] = 0;
        $entry = Entries::create($data);
        $entry->update(array(
            'number' => CoreAccounts::generateNumber($entry->id),
        ));
        return $entry->id;
    }

    public static function createFeeBankPaymentEntryItems($data)
    {

        $student_details = Student::find($data['students_id']);

        $fee_head = ErpFeeHead::find($data['fee_head_id']);

        $rec_ledger = Ledger::where([
            'group_id' => $fee_head->rec_group_id,
            'branch_id' => $data['branch_id']
        ])->first();

        /*
         * Create Entry Items records associated to Etnry now
         */
        $item = array(
            'status' => 0,
            'entry_type_id' => $data['entry_type_id'],
            'entry_id' => $data['entry_id'],
            'voucher_date' => $data['voucher_date'],
            'ledger_id' => @$rec_ledger->id,
            'narration' => $student_details->reg_no . ' ' . $student_details->first_name . ' ' . $student_details->last_name,
        );
        $item['amount'] = $data['dr_total'];
        $item['dc'] = 'c';

        $entry_items_d[] = $item;
        EntryItems::insert($entry_items_d);
        $entry_item_cr_id = EntryItems::orderBy('id', 'desc')->first();

        $item = array(
            'status' => 0,
            'entry_type_id' => $data['entry_type_id'],
            'entry_id' => $data['entry_id'],
            'voucher_date' => $data['voucher_date'],
            'ledger_id' => $data['bank_ledger_id'],
            'narration' => $student_details->reg_no . ' ' . $student_details->first_name . ' ' . $student_details->last_name,
        );
        $item['amount'] = $data['cr_total'];
        $item['dc'] = 'd';
        $entry_items[] = $item;

        EntryItems::insert($entry_items);
        $entry_item_dr_id = EntryItems::orderBy('id', 'desc')->first();

        $res = array(
            'entry_item_dr' => $entry_item_dr_id->id,
            'entry_item_cr' => $entry_item_cr_id->id
        );
        return $res;
    }

    /*
     * Update Entry in Accounting
     *
     * @param (array) $data
     * @return (array) $response
     */
    public static function updateEntry($data, $id)
    {
        $rules = [
            'voucher_date' => 'required',
            'entry_type_id' => 'required|numeric',
            'company_id' => 'required',
            'branch_id' => 'required',
            //'employee_id' => 'required|numeric',
            //'department_id' => 'sometimes|nullable|numeric',
            'narration' => 'required',
            'dr_total' => 'required|numeric|min:1|same:cr_total',
            'cr_total' => 'required|numeric|min:1|same:dr_total',
            'diff_total' => 'required|numeric|min:0|max:0',
            'entry_items' => 'required',
        ];

        $originalDate = $data['voucher_date'];
        $newDate = date("Y-m-d", strtotime($originalDate));
        $data['voucher_date'] = $newDate;

        if (isset($data['branch_id_new'])) {
            $data['branch_id'] = $data['branch_id_new'];
        }

        if (isset($data['entry_items']) && count($data['entry_items'])) {
            $entry_items = $data['entry_items'];
            foreach ($entry_items['counter'] as $key => $val) {
                if ($key != '######') {
//                    $rules['entry_items.ledger_id.' . $val] = ['required', new BranchIdMatch($data['branch_id'])];
                    $rules['entry_items.dr_amount.' . $val] = 'required_if:entry_items.cr_amount,0|numeric';
                    $rules['entry_items.cr_amount.' . $val] = 'required_if:entry_items.dr_amount,0|numeric';
                }
            }
        }

        $validator = Validator::make($data, $rules);

        if ($validator->fails()) {
            return array(
                'status' => false,
                'error' => $validator->errors()
            );
        }

        if (!$Entrie = Entries::where(['id' => $id])->first()) {
            return array(
                'status' => false,
                'error' => 'No Ledger ID found.'
            );
        }

        $company_id = Branch::where('id', $data['branch_id'])->value('company_id');
        foreach ($data['entry_items']['counter'] as $key => $val) {
            if ($key != '######') {
                $ledger_id = $data['entry_items']['ledger_id'][$val];
                $ledger = Ledger::where('id', $ledger_id)->first();
                if (!$ledger) {
                    throw ValidationException::withMessages([
                        'entry_items.ledger_id' => "The entry items.ledger id.$key not found."
                    ]);
                }
                if ($ledger->company_id != $company_id) {
                    throw ValidationException::withMessages([
                        'entry_items.ledger_id' => "The entry items.ledger id.$key does not belong to the selected company."
                    ]);
                }
            }
        }

        $data['updated_by'] = Auth::user()->id;
        // $data['status'] = 0;
        $Entrie->update($data);

        /*
         * Create Entry Items records associated to Etnry now
         */
        // Delete old entries
        EntryItems::where(['entry_id' => $id])->delete();

        $entry_items = array();
        foreach ($data['entry_items']['counter'] as $key => $val) {
            if ($key != '######') {
                $item = array(
                    'status' => 0,
                    'entry_type_id' => $data['entry_type_id'],
                    'entry_id' => $id,
                    'voucher_date' => $data['voucher_date'],
                    'ledger_id' => $data['entry_items']['ledger_id'][$val],
                    'narration' => $data['entry_items']['narration'][$val],
                    'instrument_number' => (isset($data['entry_items']['instrument_number'][$val])) ? $data['entry_items']['instrument_number'][$val] : NULL,

                );
                if ($data['entry_items']['dr_amount'][$val]) {
                    $item['amount'] = $data['entry_items']['dr_amount'][$val];
                    $item['dc'] = 'd';
                } else {
                    $item['amount'] = $data['entry_items']['cr_amount'][$val];
                    $item['dc'] = 'c';
                }
                $entry_items[] = $item;
            }
        }

        EntryItems::insert($entry_items);

        return array(
            'status' => true,
            'error' => 'Ledger has been created'
        );
    }

    public static function monthlyExpense($data)
    {
        $Entrie = EntryItems::where(['entry_type_id' => 3])->where('voucher_date', 'like', '%' . $data . '%')->sum('amount');
        $Entrie = $Entrie / 2;
        \Log::info($Entrie);
        return $Entrie;
    }

    public static function monthlyExpenseBranchWise($date, $branch_id)
    {
        $data = Ledger::branchWiseExpense($date, $branch_id);
        return $data;
    }

    public static function monthlyExpenseBranchWiseAll($date)
    {
        $data = Ledger::branchWiseExpenseAll($date);
        return $data;
    }

    public static function monthlyIncomeBranchWise($data)
    {
    }

    public static function createJEntry($data)
    {

        $data['created_by'] = Auth::user()->id;
        $data['updated_by'] = Auth::user()->id;
        $data['employee_id'] = Auth::user()->id;
        $data['branch_id'] = Auth::user()->branch_id;
        $data['status'] = 0;
        $entry = Entries::create($data);
        $entry->update(array(
            'number' => CoreAccounts::generateNumber($entry->id),
        ));

        /*
         * Create Entry Items records associated to Etnry now
         */

        $entry_items = array();
        foreach ($data['entry_items'] as $key => $val) {
            $item = array(
                'status' => 0,
                'entry_type_id' => $data['entry_type_id'],
                'entry_id' => $entry->id,
                'voucher_date' => $data['voucher_date'],
                'ledger_id' => $data['entry_items'][$key]['ledger_id'],
                'narration' => $data['entry_items'][$key]['narration'],
            );
            if ($data['entry_items'][$key]['dr_amount']) {
                $item['amount'] = $data['entry_items'][$key]['dr_amount'];
                $item['dc'] = 'd';
            } else {
                $item['amount'] = $data['entry_items'][$key]['cr_amount'];
                $item['dc'] = 'c';
            }
            $entry_items[] = $item;
        }

        EntryItems::insert($entry_items);
        return array(
            'status' => true,
            'error' => 'Ledger has been created'
        );
    }

    //    public static function createSale($data)
    //    {
    //
    //
    //        $rules = [
    //            'sal_no' => 'required',
    //            'sal_date' => 'required|numeric',
    //            'valid_upto' => 'required|numeric',
    //        ];
    //
    //
    //        $validator = Validator::make($data, $rules);
    //
    //        if ($validator->fails()) {
    //            return array(
    //                'status' => false,
    //                'error' => $validator->errors()
    //            );
    //        }
    //
    //        $data['created_by'] = Auth::user()->id;
    //        $data['updated_by'] = Auth::user()->id;
    //        $data['status'] = 0;
    //
    //        $Sales = SalesModel::create($data);
    //        $Sales->update(array(
    //            'sal_no' => CoreAccounts::generateNumber($Sales->id),
    //        ));
    //    }
    public static function dr_cr_balance($amount = 0, $decimal = 0)
    {
        if ($amount > 0) {
            return number_format(abs($amount), $decimal) . ' DR';
        }
        if ($amount < 0) {
            return number_format(abs($amount), $decimal) . ' CR';
        } else {
            return 'Nill';
        }
    }

    public static function dr_cr_balance_inverse($amount = 0, $decimal = 0)
    {
        if ($amount > 0) {
            return number_format(abs($amount), $decimal) . ' CR';
        }
        if ($amount < 0) {
            return number_format(abs($amount), $decimal) . ' DR';
        } else {
            return 'Nill';
        }
    }

    public static function opening_balance($dt, $df, $ledger_id = 0)
    {

        $date_from = date('Y-m-d', strtotime($df));
        $date_to = date('Y-m-d', strtotime($dt));
        $dr = 0;
        $cr = 0;
        $ob = 0;
        $Ledger = Ledger::where('id', $ledger_id)->first(['opening_balance', 'balance_type']);
        if (isset($Ledger->balance_type) && $Ledger->balance_type == 'd') {
            $ob = $Ledger->opening_balance;
        }
        if (isset($Ledger->balance_type) && $Ledger->balance_type == 'c') {
            $ob = -($Ledger->opening_balance);
        }

        $Entries = EntryItems::where('ledger_id', $ledger_id)->where('voucher_date', '>=', $date_to)->where('voucher_date', '<=', $date_from)->get();

        foreach ($Entries as $Ent) {
            if ($Ent->dc == 'd') {
                $dr += $Ent['amount'];
            }
            if ($Ent->dc == 'c') {
                $cr += $Ent['amount'];
            }
        }

        $balance = ($ob) + ($dr) - ($cr);
        return $balance;
    }

    public static function dr_cr_amount($df, $dt, $ledger_id)
    {
        $dr = 0;
        $cr = 0;
        $Entries = EntryItems::where('ledger_id', $ledger_id)->whereBetween('voucher_date', [$df, $dt])->get();
        foreach ($Entries as $Ent) {
            if ($Ent->dc == 'd') {
                $dr += $Ent['amount'];
            }
            if ($Ent->dc == 'c') {
                $cr += $Ent['amount'];
            }
        } //foreach
        $array = array($dr, $cr);
        return $array;
    }

    public static function getBalanceByGroupId($dt, $df, $groupId, $company_id = 1)
    {
        $total_bl = 0;
        $Groups = Groups::where('parent_id', $groupId)->orderBy('number')->get();
        if ($Groups->count() > 0) {
            foreach ($Groups as $Group) {
                $nestedGroups = Groups::where('parent_id', $Group->id)->orderBy('number')->get();
                if ($nestedGroups->count() > 0) {
                    self::getBalanceByGroupId($dt, $df, $Group->id, $company_id);
                } else {
                    $total_bl = 0;
                    $ledgers = Ledger::where('group_id', $groupId)->where('company_id', $company_id)->orderBy('number')->get();
                    foreach ($ledgers as $ledger) {
                        $total_bl += self::opening_balance($dt, $df, $ledger->id);
                    }
                }
            }
        } else {
            $total_bl = 0;
            $ledgers = Ledger::where('group_id', $groupId)->where('company_id', $company_id)->orderBy('number')->get();
            foreach ($ledgers as $ledger) {
                $total_bl += self::opening_balance($dt, $df, $ledger->id);
            }
        }

        return $total_bl;
    }

    static function excel_header()
    {
        $html = '<tr>
            <td colspan="6" width="33.33%" style="text-align: left;"><h4 style="margin-bottom: 10px;margin-top: 5px;font-size: 20px;">Educatum</h4>
                <p style="margin-bottom: 2px;font-size: 12px;margin-top: 2px;">Building # 66, Street # 7, H-8/4 Islamabad</p>
                <p style="margin-bottom: 2px;font-size: 12px;margin-top: 2px;">Phone : +111-724-111</p>
                <p style="margin-bottom: 2px;font-size: 12px;margin-top: 2px;">Email : info@rootsinternational.edu.pk</p>
            </td>
            <td width="33.33%" style="text-align: right;">
                <img src="' . url("public/uploads/logo.png") . '" width="80">
            </td>
        </tr>';
        return $html;
    }

    //====================================Accounts Group by balance===============
    static function balance_by_group($date = '', $account_type_id = 0)
    {
        $Ledger = DB::table('erp_groups')->join('erp_Ledger', 'erp_groups.id', '=', 'erp_Ledger.group_id')->where('erp_Ledger.account_type_id', $account_type_id)->get();
        $total = 0;
        foreach ($Ledger as $ledger) {
            $total += CoreAccounts::opening_balance('2021-01-15', $ledger->id);
        }
        return number_format($total, 2);
    }

    public $counter;

    //    static function increase

    public function getCounter()
    {
        return $this->counter;
    }

    public $val = 0;
    public $sVal = 0;

    public function group_balances($groupID)
    {
        $Groups = Groups::where('parent_id', $groupID)->get();
        if ($Groups->isNotEmpty()) {
            foreach ($Groups as $group) {
                $Ledger = Ledger::where('group_id', $group->id)->get();
                foreach ($Ledger as $Ledger) {
                    $ob = CoreAccounts::opening_balance('2021-01-15', $Ledger->id);
                    $this->val += $ob;
                }
                $this->group_balances($group->id);
            }
            return $this->val;
        } else {
            $Groups = Groups::where('id', $groupID)->get();
            foreach ($Groups as $group) {
                $this->sVal = 0;
                $Ledger = Ledger::where('group_id', $group->id)->get();
                foreach ($Ledger as $Ledger) {
                    $ob = CoreAccounts::opening_balance('2021-01-15', $Ledger->id);
                    $this->sVal += $ob;
                }
                //$this->group_balances($group->id);

            }
            return $this->sVal;
        }
    }

    //adil ---- new series
    static function getVouchertMaxId($type, $company_id, $financial_year = 0)
    {
        if ($financial_year == 0 || $financial_year == null) {
            $financial_year = FinancialYear::where('status', 1)->value('id');
        }

        $parent_data = Entries::where('entry_type_id', $type)->where('financial_year', $financial_year)
            ->where('company_id', $company_id)->max('number');
        if ($parent_data > 0) {
            $parent_id = $parent_data + 1;
        } else {
            $parent_id = 1;
        }
        return $parent_id;
    }

    static function countDigit($n)
    {
        if ($n / 10 == 0)
            return 1;
        return 1 + countDigit((int)($n / 10));
    }
}
