<?php

namespace App\Helpers;

use App\Models\Groups;
use App\Models\Ledger;
use Config;

/**
 * Class to store the entire account tree with the details
 */
class AccountsListOther
{
	var $id = 0;
	var $name = '';
	var $code = '';
    var $level = '';
	var $filter = array();

	var $g_parent_id = 0;		/* Group specific */
	var $g_affects_gross = 0;	/* Group specific */
	var $l_group_id = 0;		/* Ledger specific */
	var $l_type = 0;		/* Ledger specific */
	var $l_reconciliation = 0;	/* Ledger specific */
	var $l_notes = '';		/* Ledger specific */

	var $op_total = 0;
	var $op_dr_total = 0;
	var $op_cr_total = 0;
	var $cl_dr_total = 0;
	var $cl_cr_total = 0;
	var $op_total_dc = 'd';
	var $dr_total = 0;
	var $cr_total = 0;
	var $cl_total = 0;
	var $cl_total_dc = 'd';
    var $p_op_total = 0;
	var $p_op_dr_total = 0;
	var $p_op_cr_total = 0;
	var $p_cl_dr_total = 0;
	var $p_cl_cr_total = 0;
	var $p_op_total_dc = 'd';
	var $p_dr_total = 0;
	var $p_cr_total = 0;
	var $p_cl_total = 0;
	var $p_cl_total_dc = 'd';

    var $qc_op_total = 0;
	var $qc_op_dr_total = 0;
	var $qc_op_cr_total = 0;
	var $qc_cl_dr_total = 0;
	var $qc_cl_cr_total = 0;
	var $qc_op_total_dc = 'd';
	var $qc_dr_total = 0;
	var $qc_cr_total = 0;
	var $qc_cl_total = 0;
	var $qc_cl_total_dc = 'd';

    var $qp_op_total = 0;
	var $qp_op_dr_total = 0;
	var $qp_op_cr_total = 0;
	var $qp_cl_dr_total = 0;
	var $qp_cl_cr_total = 0;
	var $qp_op_total_dc = 'd';
	var $qp_dr_total = 0;
	var $qp_cr_total = 0;
	var $qp_cl_total = 0;
	var $qp_cl_total_dc = 'd';
    
    var $yc_op_total = 0;
	var $yc_op_dr_total = 0;
	var $yc_op_cr_total = 0;
	var $yc_cl_dr_total = 0;
	var $yc_cl_cr_total = 0;
	var $yc_op_total_dc = 'd';
	var $yc_dr_total = 0;
	var $yc_cr_total = 0;
	var $yc_cl_total = 0;
	var $yc_cl_total_dc = 'd';

    var $yp_op_total = 0;
	var $yp_op_dr_total = 0;
	var $yp_op_cr_total = 0;
	var $yp_cl_dr_total = 0;
	var $yp_cl_cr_total = 0;
	var $yp_op_total_dc = 'd';
	var $yp_dr_total = 0;
	var $yp_cr_total = 0;
	var $yp_cl_total = 0;
	var $yp_cl_total_dc = 'd';



	var $children_groups = array();
    var $p_children_groups = array();
	var $children_ledgers = array();
    var $p_children_ledgers = array();

	var $counter = 0;

	var $only_opening = false;
	var $start_date = null;
	var $end_date = null;
    var $previous_month_start_date = null;
    var $previous_month_end_date = null;
    var $previous_quater_start_date = null;
    var $previous_quater_end_date = null;
    var $current_quater_start_date = null;
    var $current_quater_end_date = null;
    var $c_year_start = null;
    var $c_year_end= null;
    
    var $p_year_start = null;
    var $p_year_end= null;

	var $affects_gross = -1;

/**
 * Initializer
 */
	function AccountList()
	{
		return;
	}

/**
 * Setup which group id to start from
 */
function start($id)
	{
        if ($id == 0)
        {
			$this->id = 0;
			$this->name = "None";
		} else {
		    $where['id'] = $id;
            // Set Account Type ID
            if(isset($this->filter['account_type_id']) && $this->filter['account_type_id']) {
                $where['account_type_id'] = $this->filter['account_type_id'];
            }
            if(!$group = Groups::where($where)->first()) {
                return;
            }
            $group = $group->toArray();
			$this->id = $group['id'];
			$this->name = $group['name'];
			$this->code = null;
			$this->g_parent_id = $group['parent_id'];
			$this->g_affects_gross = 0;
		}

		$this->op_total = 0;
        $this->op_dr_total = 0;
        $this->op_cr_total = 0;
        $this->cl_dr_total = 0;
        $this->cl_cr_total = 0;
		$this->op_total_dc = 'd';
		$this->dr_total = 0;
		$this->cr_total = 0;
		$this->cl_total = 0;
		$this->cl_total_dc = 'd';

        $this->p_op_total = 0;
        $this->p_op_dr_total = 0;
        $this->p_op_cr_total = 0;
        $this->p_cl_dr_total = 0;
        $this->p_cl_cr_total = 0;
		$this->p_op_total_dc = 'd';
		$this->p_dr_total = 0;
		$this->p_cr_total = 0;
		$this->p_cl_total = 0;
		$this->p_cl_total_dc = 'd';
        
        
        $this->add_sub_ledgers();
        
        $this->add_sub_groups();
	}

/**
 * Find and add subgroups as objects
 */
	function add_sub_groups()
	{
		$conditions = array('Group.parent_id' => $this->id);

		/* Check if net or gross restriction is set */
		if ($this->affects_gross == 0) {
//			$conditions['Group.affects_gross'] = 0;
		}
		if ($this->affects_gross == 1) {
//			$conditions['Group.affects_gross'] = 1;
		}
		/* Reset is since its no longer needed below 1st level of sub-groups */
		$this->affects_gross = -1;

		/* If primary group sort by id else sort by name */
		if ($this->id == 0) {
            $child_group_q = Groups::where(['parent_id'=> $this->id])->OrderBy('id','asc')->get()->toArray();
		} else {
            $child_group_q = Groups::where(['parent_id'=> $this->id])->OrderBy('name','asc')->get()->toArray();
		}
       
		$counter = 0;
		foreach ($child_group_q as $row)
		{
			/* Create new AccountList object */
			$this->children_groups[$counter] = new AccountsListOther();
			$this->children_groups[$counter]->filter = $this->filter;
			/* Initial setup */
			$this->children_groups[$counter]->only_opening = $this->only_opening;
			$this->children_groups[$counter]->start_date = $this->start_date;
			$this->children_groups[$counter]->end_date = $this->end_date;
            $this->children_groups[$counter]->previous_month_start_date = $this->previous_month_start_date;
			$this->children_groups[$counter]->previous_month_end_date = $this->previous_month_end_date;

            $this->children_groups[$counter]->current_quater_start_date = $this->current_quater_start_date;
			$this->children_groups[$counter]->current_quater_end_date = $this->current_quater_end_date;
            $this->children_groups[$counter]->previous_quater_start_date = $this->previous_quater_start_date;
			$this->children_groups[$counter]->previous_quater_end_date = $this->previous_quater_end_date;

            $this->children_groups[$counter]->c_year_start = $this->c_year_start;
			$this->children_groups[$counter]->c_year_end = $this->c_year_end;
            $this->children_groups[$counter]->p_year_start = $this->p_year_start;
			$this->children_groups[$counter]->p_year_end = $this->p_year_end;


			$this->children_groups[$counter]->affects_gross = -1; /* No longer needed in sub groups */

			$this->children_groups[$counter]->start($row['id']);
			/* Calculating opening balance total for all the child groups */
			$temp1 = CoreAccounts::calculate_withdc(
				$this->op_total,
				$this->op_total_dc,
				$this->children_groups[$counter]->op_total,
				$this->children_groups[$counter]->op_total_dc
			);
            $temp1_p = CoreAccounts::calculate_withdc(
				$this->p_op_total,
				$this->p_op_total_dc,
				$this->children_groups[$counter]->p_op_total,
				$this->children_groups[$counter]->p_op_total_dc
			);
            $temp1_qc = CoreAccounts::calculate_withdc(
				$this->qc_op_total,
				$this->qc_op_total_dc,
				$this->children_groups[$counter]->qc_op_total,
				$this->children_groups[$counter]->qc_op_total_dc
			);
            $temp1_qp = CoreAccounts::calculate_withdc(
				$this->qp_op_total,
				$this->qp_op_total_dc,
				$this->children_groups[$counter]->qp_op_total,
				$this->children_groups[$counter]->qp_op_total_dc
			);
            $temp1_yc = CoreAccounts::calculate_withdc(
				$this->yc_op_total,
				$this->yc_op_total_dc,
				$this->children_groups[$counter]->yc_op_total,
				$this->children_groups[$counter]->yc_op_total_dc
			);
            $temp1_yp = CoreAccounts::calculate_withdc(
				$this->yp_op_total,
				$this->yp_op_total_dc,
				$this->children_groups[$counter]->yp_op_total,
				$this->children_groups[$counter]->yp_op_total_dc
			);
			
			$this->op_total = $temp1['amount'];
			$this->op_total_dc = $temp1['dc'];
            $this->p_op_total = $temp1_p['amount'];
			$this->p_op_total_dc = $temp1_p['dc'];
            $this->qc_op_total = $temp1_qc['amount'];
			$this->qc_op_total_dc = $temp1_qc['dc'];
            $this->yc_op_total = $temp1_qp['amount'];
			$this->yp_op_total_dc = $temp1_qp['dc'];
        $this->op_dr_total = CoreAccounts::calculate($this->op_dr_total, $this->children_groups[$counter]->op_dr_total, '+');
               $this->op_cr_total = CoreAccounts::calculate($this->op_cr_total, $this->children_groups[$counter]->op_cr_total, '+');
			$temp2 = CoreAccounts::calculate_withdc(
				$this->cl_total,
				$this->cl_total_dc,
				$this->children_groups[$counter]->cl_total,
				$this->children_groups[$counter]->cl_total_dc
			);
            $temp2_p = CoreAccounts::calculate_withdc(
				$this->p_cl_total,
				$this->p_cl_total_dc,
				$this->children_groups[$counter]->p_cl_total,
				$this->children_groups[$counter]->p_cl_total_dc
			);
            $temp2_qc = CoreAccounts::calculate_withdc(
				$this->qc_cl_total,
				$this->qc_cl_total_dc,
				$this->children_groups[$counter]->qc_cl_total,
				$this->children_groups[$counter]->qc_cl_total_dc
			);
            $temp2_qp = CoreAccounts::calculate_withdc(
				$this->qp_cl_total,
				$this->qp_cl_total_dc,
				$this->children_groups[$counter]->qp_cl_total,
				$this->children_groups[$counter]->qp_cl_total_dc
			);
            $temp2_yc = CoreAccounts::calculate_withdc(
				$this->yc_cl_total,
				$this->yc_cl_total_dc,
				$this->children_groups[$counter]->yc_cl_total,
				$this->children_groups[$counter]->yc_cl_total_dc
			);
            $temp2_yp = CoreAccounts::calculate_withdc(
				$this->yp_cl_total,
				$this->yp_cl_total_dc,
				$this->children_groups[$counter]->yp_cl_total,
				$this->children_groups[$counter]->yp_cl_total_dc
			);

			$this->cl_total = $temp2['amount'];
			$this->cl_total_dc = $temp2['dc'];
            $this->p_cl_total = $temp2_p['amount'];
			$this->p_cl_total_dc = $temp2_p['dc'];
			    $this->qc_cl_total = $temp2_qc['amount'];
			$this->qc_cl_total_dc = $temp2_qc['dc'];
			    $this->qp_cl_total = $temp2_qp['amount'];
			$this->qp_cl_total_dc = $temp2_qp['dc'];
			    $this->yc_cl_total = $temp2_yc['amount'];
			$this->yc_cl_total_dc = $temp2_yc['dc'];
			    $this->yp_cl_total = $temp2_yp['amount'];
			$this->yp_cl_total_dc = $temp2_yp['dc'];
//   if($this->children_groups[$counter]->cl_total_dc == 'd'){
    $this->cl_dr_total = CoreAccounts::calculate($this->cl_dr_total, $this->children_groups[$counter]->cl_dr_total, '+');
    //}else{
        $this->cl_cr_total = CoreAccounts::calculate($this->cl_cr_total, $this->children_groups[$counter]->cl_cr_total, '+');
  // }
			/* Calculate Dr and Cr total */
			$this->p_dr_total = CoreAccounts::calculate($this->dr_total, $this->children_groups[$counter]->dr_total, '+');
			$this->p_cr_total = CoreAccounts::calculate($this->cr_total, $this->children_groups[$counter]->cr_total, '+');
            //previous_month
            $this->p_cl_dr_total = CoreAccounts::calculate($this->p_cl_dr_total, $this->children_groups[$counter]->p_cl_dr_total, '+');
            //}else{
                $this->p_cl_cr_total = CoreAccounts::calculate($this->p_cl_cr_total, $this->children_groups[$counter]->p_cl_cr_total, '+');
          // }
                    /* Calculate Dr and Cr total */
                    $this->p_dr_total = CoreAccounts::calculate($this->p_dr_total, $this->children_groups[$counter]->p_dr_total, '+');
                    $this->p_cr_total = CoreAccounts::calculate($this->p_cr_total, $this->children_groups[$counter]->p_cr_total, '+');
                    //current_quater
                    $this->qc_cl_dr_total = CoreAccounts::calculate($this->qc_cl_dr_total, $this->children_groups[$counter]->qc_cl_dr_total, '+');
                    //}else{
                        $this->qc_cl_cr_total = CoreAccounts::calculate($this->qc_cl_cr_total, $this->children_groups[$counter]->qc_cl_cr_total, '+');
                  // }
                            /* Calculate Dr and Cr total */
                            $this->qc_dr_total = CoreAccounts::calculate($this->qc_dr_total, $this->children_groups[$counter]->qc_dr_total, '+');
                            $this->qc_cr_total = CoreAccounts::calculate($this->qc_cr_total, $this->children_groups[$counter]->qc_cr_total, '+');
                //previous quater
                $this->qp_cl_dr_total = CoreAccounts::calculate($this->qp_cl_dr_total, $this->children_groups[$counter]->qp_cl_dr_total, '+');
                //}else{
                    $this->qp_cl_cr_total = CoreAccounts::calculate($this->qp_cl_cr_total, $this->children_groups[$counter]->qp_cl_cr_total, '+');
              // }
                        /* Calculate Dr and Cr total */
                        $this->qp_dr_total = CoreAccounts::calculate($this->qp_dr_total, $this->children_groups[$counter]->qp_dr_total, '+');
                        $this->qp_cr_total = CoreAccounts::calculate($this->qp_cr_total, $this->children_groups[$counter]->qp_cr_total, '+');
            

			$counter++;
		}
	}

/**
 * Find and add subledgers as array items
 */
	function add_sub_ledgers()
	{
        $where = ['group_id'=> $this->id];
        // Set Account Type ID
        if(isset($this->filter['account_type_id']) && $this->filter['account_type_id']) {
          //  $where['account_type_id'] = $this->filter['account_type_id'];
        }
        
        if(!$child_ledger_q = Ledger::join('erp_branches','erp_branches.id','=','erp_ledgers.branch_id')->where('erp_branches.id',1)->select('erp_ledgers.*')->where($where)->OrderBy('name','asc')->get()) {
            return;
        }
            
        $child_ledger_q = $child_ledger_q->toArray();
		$counter = 0;
		foreach ($child_ledger_q as $row)
		{
		   
            //echo '<pre>';print_r($row);echo '</pre>';exit;
			$this->children_ledgers[$counter]['id'] = $row['id'];
			$this->children_ledgers[$counter]['name'] = $row['name'];
			$this->children_ledgers[$counter]['code'] = $row['number'];
			$this->children_ledgers[$counter]['l_group_id'] = $row['group_id'];
			$this->children_ledgers[$counter]['l_type'] = 0;
			$this->children_ledgers[$counter]['l_reconciliation'] = 1;
			$this->children_ledgers[$counter]['l_notes'] = '';
              
			/* If start date is specified dont use the opening balance since its not applicable */
//			if (is_null($this->start_date)) {
//				$this->children_ledgers[$counter]['op_total'] = $row['opening_balance'];
//				$this->children_ledgers[$counter]['op_total_dc'] = $row['balance_type'];
//			} else {
//				$this->children_ledgers[$counter]['op_total'] = 0.00;
//				$this->children_ledgers[$counter]['op_total_dc'] = $row['balance_type'];
//			}

			// New Always attach opening balance as well
            $this->children_ledgers[$counter]['op_total'] = $row['opening_balance'];
            $this->children_ledgers[$counter]['op_total_dc'] = $row['balance_type'];
            $this->children_ledgers[$counter]['p_op_total'] = $row['opening_balance'];
            $this->children_ledgers[$counter]['p_op_total_dc'] = $row['balance_type'];
            $this->children_ledgers[$counter]['qc_op_total'] = $row['opening_balance'];
            $this->children_ledgers[$counter]['qc_op_total_dc'] = $row['balance_type'];
            $this->children_ledgers[$counter]['qp_op_total'] = $row['opening_balance'];
            $this->children_ledgers[$counter]['qp_op_total_dc'] = $row['balance_type'];
            $this->children_ledgers[$counter]['yc_op_total'] = $row['opening_balance'];
            $this->children_ledgers[$counter]['yc_op_total_dc'] = $row['balance_type'];
            $this->children_ledgers[$counter]['yp_op_total'] = $row['opening_balance'];
            $this->children_ledgers[$counter]['yp_op_total_dc'] = $row['balance_type'];

       //     $this->children_ledgers[$counter]['op_total'] = $row['closing_balance'];
        //    $this->children_ledgers[$counter]['op_total_dc'] = $row['balance_type'];

			/* Calculating current group opening balance total */
			$temp3 = CoreAccounts::calculate_withdc(
				$this->op_total,
				$this->op_total_dc,
				$this->children_ledgers[$counter]['op_total'],
				$this->children_ledgers[$counter]['op_total_dc']
			);
            $temp3_p = CoreAccounts::calculate_withdc(
				$this->p_op_total,
				$this->p_op_total_dc,
				$this->children_ledgers[$counter]['p_op_total'],
				$this->children_ledgers[$counter]['p_op_total_dc']
			);
            $temp3_qc = CoreAccounts::calculate_withdc(
				$this->qc_op_total,
				$this->qc_op_total_dc,
				$this->children_ledgers[$counter]['qc_op_total'],
				$this->children_ledgers[$counter]['qc_op_total_dc']
			);
            $temp3_qp = CoreAccounts::calculate_withdc(
				$this->qp_op_total,
				$this->qp_op_total_dc,
				$this->children_ledgers[$counter]['qp_op_total'],
				$this->children_ledgers[$counter]['qp_op_total_dc']
			);
            $temp3_yc = CoreAccounts::calculate_withdc(
				$this->yc_op_total,
				$this->yc_op_total_dc,
				$this->children_ledgers[$counter]['yc_op_total'],
				$this->children_ledgers[$counter]['yc_op_total_dc']
			);
            $temp3_yp = CoreAccounts::calculate_withdc(
				$this->yp_op_total,
				$this->yp_op_total_dc,
				$this->children_ledgers[$counter]['yp_op_total'],
				$this->children_ledgers[$counter]['yp_op_total_dc']
			);
			$this->op_total = $temp3['amount'];
			$this->op_total_dc = $temp3['dc'];
            $this->p_op_total = $temp3_p['amount'];
			$this->p_op_total_dc = $temp3_p['dc'];
            $this->qc_op_total = $temp3_qc['amount'];
			$this->qc_op_total_dc = $temp3_qc['dc'];
            $this->qp_op_total = $temp3_qp['amount'];
			$this->qp_op_total_dc = $temp3_qp['dc'];
            $this->yc_op_total = $temp3_yc['amount'];
			$this->yc_op_total_dc = $temp3_yc['dc'];
            $this->yp_op_total = $temp3_yp['amount'];
			$this->yp_op_total_dc = $temp3_yp['dc'];
            

            if($row['balance_type'] == 'd'){
                $this->op_dr_total = CoreAccounts::calculate($this->op_dr_total, $row['opening_balance'], '+');
                
            }else{
                $this->op_cr_total = CoreAccounts::calculate($this->op_cr_total, $row['opening_balance'], '+');
            }
            if($row['balance_type'] == 'd'){
                $this->p_op_dr_total = CoreAccounts::calculate($this->p_op_dr_total, $row['opening_balance'], '+');
                
            }else{
                $this->p_op_cr_total = CoreAccounts::calculate($this->p_op_cr_total, $row['opening_balance'], '+');
            }
            if($row['balance_type'] == 'd'){
                $this->qc_op_dr_total = CoreAccounts::calculate($this->qc_op_dr_total, $row['opening_balance'], '+');
                
            }else{
                $this->qc_op_cr_total = CoreAccounts::calculate($this->qc_op_cr_total, $row['opening_balance'], '+');
            }
            if($row['balance_type'] == 'd'){
                $this->qp_op_dr_total = CoreAccounts::calculate($this->qp_op_dr_total, $row['opening_balance'], '+');
                
            }else{
                $this->qp_op_cr_total = CoreAccounts::calculate($this->qp_op_cr_total, $row['opening_balance'], '+');
            }

			if ($this->only_opening == true) {
				/* If calculating only opening balance */
				$this->children_ledgers[$counter]['dr_total'] = 0;
				$this->children_ledgers[$counter]['cr_total'] = 0;

				$this->children_ledgers[$counter]['cl_total'] =	$this->children_ledgers[$counter]['op_total'];
				$this->children_ledgers[$counter]['cl_total_dc'] =$this->children_ledgers[$counter]['op_total_dc'];
                    
			} else {
				$cl = Ledger::closingBalance(
					$row['id'],
					$this->start_date,
					$this->end_date,
                    $this->filter
				);

				$this->children_ledgers[$counter]['dr_total'] = $cl['dr_total'];
				$this->children_ledgers[$counter]['cr_total'] = $cl['cr_total'];

				$this->children_ledgers[$counter]['cl_total'] = $cl['amount'];
                // New Always attach opening balance as well
                $this->children_ledgers[$counter]['cl_total'] = ($this->children_ledgers[$counter]['op_total'] + $cl['amount']);
				$this->children_ledgers[$counter]['cl_total_dc'] = $cl['dc'];
                $temp5 = CoreAccounts::calculate_withdc(
                    $cl['amount'],
                    $cl['dc'],
                    $this->children_ledgers[$counter]['op_total'],
                    $this->children_ledgers[$counter]['op_total_dc']
                );
                $this->children_ledgers[$counter]['cl_total']  = $temp5['amount'];
                $this->children_ledgers[$counter]['cl_total_dc'] = $temp5['dc'];

			
			}
            if ($this->only_opening == true) {
				/* If calculating only opening balance */
				$this->children_ledgers[$counter]['p_dr_total'] = 0;
				$this->children_ledgers[$counter]['p_cr_total'] = 0;

				$this->children_ledgers[$counter]['p_cl_total'] =	$this->children_ledgers[$counter]['p_op_total'];
				$this->children_ledgers[$counter]['p_cl_total_dc'] =$this->children_ledgers[$counter]['p_op_total_dc'];
                    
			} else {
                
				$p_cl = Ledger::closingBalance(
					$row['id'],
					$this->previous_month_start_date,
					$this->previous_month_end_date,
                    $this->filter
				);
             
              
           
				$this->children_ledgers[$counter]['p_dr_total'] = $p_cl['dr_total'];
				$this->children_ledgers[$counter]['p_cr_total'] = $p_cl['cr_total'];

				$this->children_ledgers[$counter]['p_cl_total'] = $p_cl['amount'];
               
                // New Always attach opening balance as well
                $this->children_ledgers[$counter]['p_cl_total'] = ($this->children_ledgers[$counter]['p_op_total'] + $p_cl['amount']);
            
                $this->children_ledgers[$counter]['p_cl_total_dc'] = $p_cl['dc'];
               
                $temp5_p= CoreAccounts::calculate_withdc(
                    $p_cl['amount'],
                    $p_cl['dc'],
                    $this->children_ledgers[$counter]['p_op_total'],
                    $this->children_ledgers[$counter]['p_op_total_dc']
                );
              
                $this->children_ledgers[$counter]['p_cl_total']  = $temp5_p['amount'];
                $this->children_ledgers[$counter]['p_cl_total_dc'] = $temp5_p['dc'];

			
			}
            if ($this->only_opening == true) {
				/* If calculating only opening balance */
				$this->children_ledgers[$counter]['qc_dr_total'] = 0;
				$this->children_ledgers[$counter]['qc_cr_total'] = 0;

				$this->children_ledgers[$counter]['qc_cl_total'] =	$this->children_ledgers[$counter]['qc_op_total'];
				$this->children_ledgers[$counter]['qc_cl_total_dc'] =$this->children_ledgers[$counter]['qc_op_total_dc'];
                    
			} else {
                
				$qc_cl = Ledger::closingBalance(
					$row['id'],
					$this->current_quater_start_date,
					$this->current_quater_end_date,
                    $this->filter
				);
             
              
           
				$this->children_ledgers[$counter]['qc_dr_total'] = $qc_cl['dr_total'];
				$this->children_ledgers[$counter]['qc_cr_total'] = $qc_cl['cr_total'];

				$this->children_ledgers[$counter]['qc_cl_total'] = $qc_cl['amount'];
               
                // New Always attach opening balance as well
                $this->children_ledgers[$counter]['qc_cl_total'] = ($this->children_ledgers[$counter]['qc_op_total'] + $qc_cl['amount']);
            
                $this->children_ledgers[$counter]['qc_cl_total_dc'] = $qc_cl['dc'];
               
                $temp5_qc= CoreAccounts::calculate_withdc(
                    $qc_cl['amount'],
                    $qc_cl['dc'],
                    $this->children_ledgers[$counter]['qc_op_total'],
                    $this->children_ledgers[$counter]['qc_op_total_dc']
                );
              
                $this->children_ledgers[$counter]['qc_cl_total']  = $temp5_qc['amount'];
                $this->children_ledgers[$counter]['qc_cl_total_dc'] = $temp5_qc['dc'];

			
			}
            if ($this->only_opening == true) {
				/* If calculating only opening balance */
				$this->children_ledgers[$counter]['qp_dr_total'] = 0;
				$this->children_ledgers[$counter]['qp_cr_total'] = 0;

				$this->children_ledgers[$counter]['qp_cl_total'] =	$this->children_ledgers[$counter]['qp_op_total'];
				$this->children_ledgers[$counter]['qp_cl_total_dc'] =$this->children_ledgers[$counter]['qp_op_total_dc'];
                    
			} else {
                
				$qp_cl = Ledger::closingBalance(
					$row['id'],
					$this->previous_quater_start_date,
					$this->previous_quater_end_date,
                    $this->filter
				);
             
              
           
				$this->children_ledgers[$counter]['qp_dr_total'] = $qp_cl['dr_total'];
				$this->children_ledgers[$counter]['qp_cr_total'] = $qp_cl['cr_total'];

				$this->children_ledgers[$counter]['qp_cl_total'] = $qp_cl['amount'];
               
                // New Always attach opening balance as well
                $this->children_ledgers[$counter]['qp_cl_total'] = ($this->children_ledgers[$counter]['qp_op_total'] + $qp_cl['amount']);
            
                $this->children_ledgers[$counter]['qp_cl_total_dc'] = $qp_cl['dc'];
               
                $temp5_qp= CoreAccounts::calculate_withdc(
                    $qp_cl['amount'],
                    $qp_cl['dc'],
                    $this->children_ledgers[$counter]['qp_op_total'],
                    $this->children_ledgers[$counter]['qp_op_total_dc']
                );
              
                $this->children_ledgers[$counter]['qp_cl_total']  = $temp5_qp['amount'];
                $this->children_ledgers[$counter]['qp_cl_total_dc'] = $temp5_qp['dc'];

			
			}
            if ($this->only_opening == true) {
				/* If calculating only opening balance */
				$this->children_ledgers[$counter]['yc_dr_total'] = 0;
				$this->children_ledgers[$counter]['yc_cr_total'] = 0;

				$this->children_ledgers[$counter]['yc_cl_total'] =	$this->children_ledgers[$counter]['yc_op_total'];
				$this->children_ledgers[$counter]['yc_cl_total_dc'] =$this->children_ledgers[$counter]['yc_op_total_dc'];
                    
			} else {
                
				$yc_cl = Ledger::closingBalance(
					$row['id'],
					$this->c_year_start,
					$this->c_year_end,
                    $this->filter
				);
             
              
           
				$this->children_ledgers[$counter]['yc_dr_total'] = $yc_cl['dr_total'];
				$this->children_ledgers[$counter]['yc_cr_total'] = $yc_cl['cr_total'];

				$this->children_ledgers[$counter]['yc_cl_total'] = $yc_cl['amount'];
               
                // New Always attach opening balance as well
                $this->children_ledgers[$counter]['yc_cl_total'] = ($this->children_ledgers[$counter]['yc_op_total'] + $yc_cl['amount']);
            
                $this->children_ledgers[$counter]['yc_cl_total_dc'] = $yc_cl['dc'];
               
                $temp5_yc= CoreAccounts::calculate_withdc(
                    $yc_cl['amount'],
                    $yc_cl['dc'],
                    $this->children_ledgers[$counter]['yc_op_total'],
                    $this->children_ledgers[$counter]['yc_op_total_dc']
                );
              
                $this->children_ledgers[$counter]['yc_cl_total']  = $temp5_yc['amount'];
                $this->children_ledgers[$counter]['yc_cl_total_dc'] = $temp5_yc['dc'];

			
			}
            if ($this->only_opening == true) {
				/* If calculating only opening balance */
				$this->children_ledgers[$counter]['yp_dr_total'] = 0;
				$this->children_ledgers[$counter]['yp_cr_total'] = 0;

				$this->children_ledgers[$counter]['yp_cl_total'] =	$this->children_ledgers[$counter]['yp_op_total'];
				$this->children_ledgers[$counter]['yp_cl_total_dc'] =$this->children_ledgers[$counter]['yp_op_total_dc'];
                    
			} else {
                
				$yp_cl = Ledger::closingBalance(
					$row['id'],
					$this->p_year_start,
					$this->p_year_end,
                    $this->filter
				);
             
              
           
				$this->children_ledgers[$counter]['yp_dr_total'] = $yp_cl['dr_total'];
				$this->children_ledgers[$counter]['yp_cr_total'] = $yp_cl['cr_total'];

				$this->children_ledgers[$counter]['yp_cl_total'] = $yp_cl['amount'];
               
                // New Always attach opening balance as well
                $this->children_ledgers[$counter]['yp_cl_total'] = ($this->children_ledgers[$counter]['yp_op_total'] + $yp_cl['amount']);
            
                $this->children_ledgers[$counter]['yp_cl_total_dc'] = $yp_cl['dc'];
               
                $temp5_yp= CoreAccounts::calculate_withdc(
                    $yp_cl['amount'],
                    $yp_cl['dc'],
                    $this->children_ledgers[$counter]['yp_op_total'],
                    $this->children_ledgers[$counter]['yp_op_total_dc']
                );
              
                $this->children_ledgers[$counter]['yp_cl_total']  = $temp5_yp['amount'];
                $this->children_ledgers[$counter]['yp_cl_total_dc'] = $temp5_yp['dc'];

			
			}


			/* Calculating current group closing balance total */
			$temp4 = CoreAccounts::calculate_withdc(
				$this->cl_total,
				$this->cl_total_dc,
				$this->children_ledgers[$counter]['cl_total'],
				$this->children_ledgers[$counter]['cl_total_dc']
			);
			$this->cl_total = $temp4['amount'];
			$this->cl_total_dc = $temp4['dc'];
            $temp4_p = CoreAccounts::calculate_withdc(
				$this->p_cl_total,
				$this->p_cl_total_dc,
				$this->children_ledgers[$counter]['p_cl_total'],
				$this->children_ledgers[$counter]['p_cl_total_dc']
			);
			$this->p_cl_total = $temp4_p['amount'];
			$this->p_cl_total_dc = $temp4_p['dc'];
            $temp4_qc = CoreAccounts::calculate_withdc(
				$this->qc_cl_total,
				$this->qc_cl_total_dc,
				$this->children_ledgers[$counter]['qc_cl_total'],
				$this->children_ledgers[$counter]['qc_cl_total_dc']
			);
			$this->qc_cl_total = $temp4_qc['amount'];
			$this->qc_cl_total_dc = $temp4_qc['dc'];
            $temp4_qp = CoreAccounts::calculate_withdc(
				$this->qp_cl_total,
				$this->qp_cl_total_dc,
				$this->children_ledgers[$counter]['qp_cl_total'],
				$this->children_ledgers[$counter]['qp_cl_total_dc']
			);
			$this->qp_cl_total = $temp4_qp['amount'];
			$this->qp_cl_total_dc = $temp4_qp['dc'];
            $temp4_yc = CoreAccounts::calculate_withdc(
				$this->yc_cl_total,
				$this->yc_cl_total_dc,
				$this->children_ledgers[$counter]['yc_cl_total'],
				$this->children_ledgers[$counter]['yc_cl_total_dc']
			);
			$this->yc_cl_total = $temp4_yc['amount'];
			$this->yc_cl_total_dc = $temp4_yc['dc'];
            $temp4_yp = CoreAccounts::calculate_withdc(
				$this->yp_cl_total,
				$this->yp_cl_total_dc,
				$this->children_ledgers[$counter]['yp_cl_total'],
				$this->children_ledgers[$counter]['yp_cl_total_dc']
			);
			$this->yp_cl_total = $temp4_yp['amount'];
			$this->yp_cl_total_dc = $temp4_yp['dc'];
            if($temp5['dc'] == 'd'){
                $this->cl_dr_total = CoreAccounts::calculate($this->cl_dr_total, $temp5['amount'], '+');
            }else{
                $this->cl_cr_total = CoreAccounts::calculate($this->cl_cr_total, $temp5['amount'], '+');
            }
            if($temp5_p['dc'] == 'd'){
                $this->p_cl_dr_total = CoreAccounts::calculate($this->p_cl_dr_total, $temp5_p['amount'], '+');
            }else{
                $this->p_cl_cr_total = CoreAccounts::calculate($this->p_cl_cr_total, $temp5_p['amount'], '+');
            }
            if($temp5_qc['dc'] == 'd'){
                $this->qc_cl_dr_total = CoreAccounts::calculate($this->qc_cl_dr_total, $temp5_qc['amount'], '+');
            }else{
                $this->qc_cl_cr_total = CoreAccounts::calculate($this->qc_cl_cr_total, $temp5_qc['amount'], '+');
            }
            if($temp5_qp['dc'] == 'd'){
                $this->qp_cl_dr_total = CoreAccounts::calculate($this->qp_cl_dr_total, $temp5_qp['amount'], '+');
            }else{
                $this->qp_cl_cr_total = CoreAccounts::calculate($this->qp_cl_cr_total, $temp5_qp['amount'], '+');
            }
            if($temp5_yc['dc'] == 'd'){
                $this->yc_cl_dr_total = CoreAccounts::calculate($this->yc_cl_dr_total, $temp5_yc['amount'], '+');
            }else{
                $this->yc_cl_cr_total = CoreAccounts::calculate($this->yc_cl_cr_total, $temp5_yc['amount'], '+');
            }
            if($temp5_yp['dc'] == 'd'){
                $this->yp_cl_dr_total = CoreAccounts::calculate($this->yp_cl_dr_total, $temp5_yp['amount'], '+');
            }else{
                $this->yp_cl_cr_total = CoreAccounts::calculate($this->yp_cl_cr_total, $temp5_yp['amount'], '+');
            }
			/* Calculate Dr and Cr total */
			$this->dr_total = CoreAccounts::calculate($this->dr_total, $this->children_ledgers[$counter]['dr_total'], '+');
			$this->cr_total = CoreAccounts::calculate($this->cr_total, $this->children_ledgers[$counter]['cr_total'], '+');
            $this->p_dr_total = CoreAccounts::calculate($this->p_dr_total, $this->children_ledgers[$counter]['p_dr_total'], '+');
			$this->p_cr_total = CoreAccounts::calculate($this->p_cr_total, $this->children_ledgers[$counter]['p_cr_total'], '+');
            $this->qc_dr_total = CoreAccounts::calculate($this->qc_dr_total, $this->children_ledgers[$counter]['qc_dr_total'], '+');
			$this->qc_cr_total = CoreAccounts::calculate($this->qc_cr_total, $this->children_ledgers[$counter]['qc_cr_total'], '+');
            $this->qp_dr_total = CoreAccounts::calculate($this->qp_dr_total, $this->children_ledgers[$counter]['qp_dr_total'], '+');
			$this->qp_cr_total = CoreAccounts::calculate($this->qp_cr_total, $this->children_ledgers[$counter]['qp_cr_total'], '+');
            $this->yc_dr_total = CoreAccounts::calculate($this->yc_dr_total, $this->children_ledgers[$counter]['yc_dr_total'], '+');
			$this->yc_cr_total = CoreAccounts::calculate($this->yc_cr_total, $this->children_ledgers[$counter]['yc_cr_total'], '+');
            $this->yp_dr_total = CoreAccounts::calculate($this->yp_dr_total, $this->children_ledgers[$counter]['yp_dr_total'], '+');
			$this->yp_cr_total = CoreAccounts::calculate($this->yp_cr_total, $this->children_ledgers[$counter]['yp_cr_total'], '+');
			
            $counter++;
		}
	
	
	}

    static function toCodeWithName($code, $name) {
        if (strlen($code) <= 0) {
            return $name;
        } else {
            return '[' . $code . '] ' . $name;
        }
    }


    /**
     * Generate chart of accounts
     *
     * @param @account AccountList group account
     * @param @c int counter for number of level deep the account is
     * @param @THIS this $this CakePHP object passed inside function
     *
     * @return (void)
     */
    function generate_account_chart($account, $c = 0)
    {
        $html = '';

        $counter = $c;

        /* Print groups */
        if ($account->id != 0) {
            if ($account->id <= 4) {
                $html .= '<tr class="tr-group tr-root-group">';
            } else {
                $html .= '<tr class="tr-group">';
            }
            $html .= '<td><b>';
            $html .= $this->print_space($counter);
            $html .= self::toCodeWithName($account->code, $account->name);
            $html .= '</b></td>';

            $html .= '<td>Group</td>';

            $html .= '<td>';
            $html .= CoreAccounts::toCurrency($account->op_total_dc, $account->op_total);
            $html .= '</td>';

            $html .= '<td class="td-actions"></td>';
            $html .= '<td class="td-actions"></td>';

            $html .= '<td>';
            $html .= CoreAccounts::toCurrency($account->cl_total_dc, $account->cl_total);
            $html .= '</td>';

            /* If group id less than 4 dont show edit and delete links */
            $html .= '</tr>';
        }

        /* Print child ledgers */
        if (count($account->children_ledgers) > 0) {
            $counter++;
            foreach ($account->children_ledgers as $id => $data) {
                $html .= '<tr class="tr-ledger">';
                $html .= '<td class="td-ledger">';
                $html .= $this->print_space($counter);
                $html .= self::toCodeWithName($data['code'], $data['name']);
                $html .= '</td>';
                $html .= '<td>Ledger</td>';

                $html .= '<td>';
                $html .= CoreAccounts::toCurrency($data['op_total_dc'], $data['op_total']);
                $html .= '</td>';

                $html .= '<td class="td-actions">';
                $html .= '</td>';

                $html .= '<td class="td-actions">';
                $html .= '</td>';

                $html .= '<td>';
                $html .= CoreAccounts::toCurrency($data['cl_total_dc'], $data['cl_total']);
                $html .= '</td>';

                $html .= '</tr>';
            }
            $counter--;
        }

        /* Print child groups recursively */
        foreach ($account->children_groups as $id => $data) {
            $counter++;
            $html .= self::generate_account_chart($data, $counter);
            $counter--;
        }

        return $html;
    }

    /**
     * Generate Ledger Statement Table
     *
     * @param $account AccountList group account
     * @param @c int counter for number of level deep the account is
     *
     * @return $html return table rows
     *
     */
    function generateLedgerStatement($account, $c = 0)
    {
        //echo '<pre>';print_r($account);echo'</pre>';exit;
        $counter = $c;

        $html = '';

        /* Print groups */
//        if($account->filter['account_type_id'] >= 5) {
//            if ($account->id != 0) {
//                if (in_array($account->id, Config::get('constants.accounts_main_heads'))) {
//                    $html .= '<tr class="tr-group tr-root-group">';
//                } else {
//                    $html .= '<tr class="tr-group">';
//                }
//                $html .= '<td class="td-group">';
//                $html .= $this->print_space($counter);
//                $html .= self::toCodeWithName($account->code, $account->name);
//                $html .= '</td>';
//
//                $html .= '<td>Group</td>';
//
//                $html .= '<td align="right">';
//                $html .= CoreAccounts::toCurrency($account->op_total_dc, $account->op_total);
//                $html .= '</td>';
//
//                $html .= '<td align="right">' . CoreAccounts::toCurrency('d', $account->dr_total) . '</td>';
//
//                $html .= '<td align="right">' . CoreAccounts::toCurrency('c', $account->cr_total) . '</td>';
//
//                if ($account->cl_total_dc == 'd') {
//                    $html .= '<td align="right">' . CoreAccounts::toCurrency('d', $account->cl_total) . '</td>';
//                } else {
//                    $html .= '<td align="right">' . CoreAccounts::toCurrency('c', $account->cl_total) . '</td>';
//                }
//
//                $html .= '</tr>';
//            }
//
//        /* Print child ledgers */
//            if (count($account->children_ledgers) > 0) {
//                $counter++;
//                foreach ($account->children_ledgers as $id => $data) {
//                    $html .= '<tr>';
//                    $html .= '<td>';
//                    $html .= $this->print_space($counter);
//                    $html .= self::toCodeWithName($data['code'], $data['name']);
//                    $html .= '</td>';
//                    $html .= '<td>Ledger</td>';
//
//                    $html .= '<td align="right">';
//                    $html .= CoreAccounts::toCurrency($data['op_total_dc'], $data['op_total']);
//                    $html .= '</td>';
//
//                    $html .= '<td align="right">' . CoreAccounts::toCurrency('d', $data['dr_total']) . '</td>';
//
//                    $html .= '<td align="right">' . CoreAccounts::toCurrency('c', $data['cr_total']) . '</td>';
//
//                    if ($data['cl_total_dc'] == 'd') {
//                        $html .= '<td align="right">' . CoreAccounts::toCurrency('d', $data['cl_total']) . '</td>';
//                    } else {
//                        $html .= '<td align="right">' . CoreAccounts::toCurrency('c', $data['cl_total']) . '</td>';
//                    }
//
//                    $html .= '</tr>';
//                }
//                $counter--;
//            }
//    }else{
           if($account->filter['account_type_id'] >= $account->level) {
                if ($account->id != 0) {
                    if (in_array($account->id, Config::get('constants.accounts_main_heads'))) {
                        $html .= '<tr class="tr-group tr-root-group">';
                    } else {
                        $html .= '<tr class="tr-group">';
                    }
                    $html .= '<td class="td-group" style = "background:#d3ffd3; font-weight:700;">';
                    $html .= $this->print_space($counter);
                    $html .= self::toCodeWithName($account->code, $account->name);
                    $html .= '</td>';

                    $html .= '<td style = "background:#d3ffd3;font-weight:700;">Group</td>';
                        if($account->op_total_dc == 'd'){
                            $html .= '<td align="right" style = "background:#d3ffd3;font-weight:700;">';
                            $html .= CoreAccounts::toCurrency($account->op_total_dc, $account->op_total);
                            $html .= '</td>';
                            $html .= '<td align="right" style = "background:#d3ffd3;font-weight:700;">0.00</td>';
                        }else{
                            $html .= '<td align="right" style = "background:#d3ffd3;font-weight:700;">0.00</td>';
                            $html .= '<td align="right" style = "background:#d3ffd3;font-weight:700;">';
                            $html .= CoreAccounts::toCurrency($account->op_total_dc, $account->op_total);
                            $html .= '</td>';
                        }
//                    $html .= '<td align="right">'. CoreAccounts::toCurrency('d', $account->op_dr_total).'</td>';
//                    $html .= '<td align="right">'. CoreAccounts::toCurrency('c', $account->op_cr_total).'</td>';

                    $html .= '<td align="right" style = "background:#d3ffd3;font-weight:700;">' . CoreAccounts::toCurrency('d', $account->dr_total) . '</td>';

                    $html .= '<td align="right" style = "background:#d3ffd3;font-weight:700;">' . CoreAccounts::toCurrency('c', $account->cr_total) . '</td>';
//                    $html .= '<td align="right">' . CoreAccounts::toCurrency('d', $account->cl_dr_total) . '</td>';
//                    $html .= '<td align="right">' . CoreAccounts::toCurrency('c', $account->cl_cr_total) . '</td>';
                    if ($account->cl_total_dc == 'd') {
                        $html .= '<td align="right" style = "background:#d3ffd3;font-weight:700;">' . CoreAccounts::toCurrency('d', $account->cl_total) . '</td>';
                        $html .= '<td align="right" style = "background:#d3ffd3;font-weight:700;" style = "background:#d3ffd3;">0.00</td>';
                    } else {
                        $html .= '<td align="right" style = "background:#d3ffd3;font-weight:700;">0.00</td>';
                        $html .= '<td align="right" style = "background:#d3ffd3;font-weight:700;">' . CoreAccounts::toCurrency('c', $account->cl_total) . '</td>';
                    }
                    $html .= '</tr>';
               }
       //    if($account->filter['account_type_id'] >= 7) {
                if (count($account->children_ledgers) > 0) {
                   
                    $counter++;
                    foreach ($account->children_ledgers as $id => $data) {
                        $html .= '<tr>';
                        $html .= '<td>';
                        $html .= $this->print_space($counter);
                        $html .= self::toCodeWithName($data['code'], $data['name']);
                        $html .= '</td>';
                        $html .= '<td>Ledger</td>';

                        if($data['op_total_dc'] == 'd'){
                            $html .= '<td align="right">';
                            $html .= CoreAccounts::toCurrency($data['op_total_dc'], $data['op_total']);
                            $html .= '</td>';
                            $html .= '<td align="right">0.00</td>';
                        }else{
                            $html .= '<td align="right">0.00</td>';
                            $html .= '<td align="right">';
                            $html .= CoreAccounts::toCurrency($data['op_total_dc'], $data['op_total']);
                            $html .= '</td>';
                        }

//                        $html .= '<td align="right">';
//                        $html .= CoreAccounts::toCurrency($data['op_total_dc'], $data['op_total']);
//                        $html .= '</td>';

                        $html .= '<td align="right">' . CoreAccounts::toCurrency('d', $data['dr_total']) . '</td>';

                        $html .= '<td align="right">' . CoreAccounts::toCurrency('c', $data['cr_total']) . '</td>';

                        if ($data['cl_total_dc'] == 'd') {
                            $html .= '<td align="right">' . CoreAccounts::toCurrency('d', $data['cl_total']) . '</td>';
                            $html .= '<td align="right">0.00</td>';
                        } else {
                            $html .= '<td align="right">0.00</td>';
                            $html .= '<td align="right">' . CoreAccounts::toCurrency('c', $data['cl_total']) . '</td>';
                        }

                        $html .= '</tr>';
                    }
                    $counter--;
                }
          //  }
        }

        /* Print child groups recursively */
        foreach ($account->children_groups as $id => $data) {
            $counter++;
            $html .= self::generateLedgerStatement($data, $counter);
            $counter--;
        }

        return $html;
    }

    /**
     * Generate Balance Sheet with Ledgers
     *
     * @param $account AccountList group account
     * @param @c int counter for number of level deep the account is
     *
     * @return $html return table rows
     *
     */
    function generateBalanceSheetWithLedgers($account, $c = 0, $dc_type)
    {
        $html = '';

        $counter = $c;
        if (!in_array($account->id, Config('constants.accounts_main_heads')))
        {
            if ($dc_type == 'd' && $account->cl_total_dc == 'c' && CoreAccounts::calculate($account->cl_total, 0, '!=')) {
                $html .= '<tr class="tr-group dc-error">';
            } else if ($dc_type == 'c' && $account->cl_total_dc == 'd' && CoreAccounts::calculate($account->cl_total, 0, '!=')) {
                $html .= '<tr class="tr-group dc-error">';
            } else {
                $html .= '<tr class="tr-group">';
            }

            $html .= '<td class="td-group">';
            $html .= $this->print_space($counter);
            $html .= self::toCodeWithName($account->code, $account->name);
            $html .= '</td>';

            $html .= '<td class="text-right" align="right">';
            $html .= CoreAccounts::toCurrency($account->cl_total_dc, $account->cl_total);
            $html .= $this->print_space($counter);
            $html .= '</td>';

            $html .= '</tr>';
        }
        foreach ($account->children_groups as $id => $data)
        {
            $counter++;
            $html .= self::generateBalanceSheetWithLedgers($data, $counter, $dc_type);
            $counter--;
        }
        if (count($account->children_ledgers) > 0)
        {
            $counter++;
            foreach ($account->children_ledgers as $id => $data)
            {
                if ($dc_type == 'd' && $data['cl_total_dc'] == 'c' && CoreAccounts::calculate($data['cl_total'], 0, '!=')) {
                    $html .= '<tr class="tr-ledger dc-error">';
                } else if ($dc_type == 'c' && $data['cl_total_dc'] == 'd' && CoreAccounts::calculate($data['cl_total'], 0, '!=')) {
                    $html .= '<tr class="tr-ledger dc-error">';
                } else {
                    $html .= '<tr class="tr-ledger">';
                }

                $html .= '<td class="td-ledger">';
                $html .= $this->print_space($counter);
                $html .= self::toCodeWithName($data['code'], $data['name']);
                $html .= '</td>';

                $html .= '<td class="text-right" align="right">';
                $html .= CoreAccounts::toCurrency($data['cl_total_dc'], $data['cl_total']);
                $html .= $this->print_space($counter);
                $html .= '</td>';

                $html .= '</tr>';
            }
            $counter--;
        }

        return $html;
    }


    /**
     * Generate Balance Sheet
     *
     * @param $account AccountList group account
     * @param @c int counter for number of level deep the account is
     *
     * @return $html return table rows
     *
     */
    function generateSheet($account, $c = 0, $dc_type)
    {

     
        
        $html = '';
        $counter = $c;
        $array = array(1, 2, 3, 4);
        
        if (!in_array($account->id, $array))
        {
          
            if ($dc_type == 'd' && $account->cl_total_dc == 'c' && CoreAccounts::calculate($account->cl_total, 0, '!=')) {
                $html .= '<tr class="tr-group dc-error">';
            } else if ($dc_type == 'c' && $account->cl_total_dc == 'd' && CoreAccounts::calculate($account->cl_total, 0, '!=')) {
                $html .= '<tr class="tr-group dc-error">';
            } else {
                $html .= '<tr class="tr-group">';
            }
           
            $html .= '<td class="td-group">';
            $html .= $this->print_space($counter);
            $html .= self::toCodeWithName($account->code, $account->name);
            $html .= '</td>';

            if(count($account->children_groups)) {
                $html .= '<td class="text-right" align="right"></td>';
                 $html .= '<td class="text-right" align="right"></td>';
                  $html .= '<td class="text-right" align="right"></td>';
                 $html .= '<td class="text-right" align="right"></td>';
                  $html .= '<td class="text-right" align="right"></td>';
                 $html .= '<td class="text-right" align="right"></td>';
            } else {
                $html .= '<td class="text-right" align="right">';
                $html .= CoreAccounts::toCurrency($account->cl_total_dc, $account->cl_total);
                $html .= '</td>';
                $html .= '<td class="text-right" align="right">';
                $html .= CoreAccounts::toCurrency($account->p_cl_total_dc, $account->p_cl_total);
                $html .= '</td>';
                $html .= '<td class="text-right" align="right">';
                $html .= CoreAccounts::toCurrency($account->qc_cl_total_dc, $account->qc_cl_total);
                $html .= '</td>';
                $html .= '<td class="text-right" align="right">';
                $html .= CoreAccounts::toCurrency($account->qp_cl_total_dc, $account->qp_cl_total);
                $html .= '</td>';
                $html .= '<td class="text-right" align="right">';
                $html .= CoreAccounts::toCurrency($account->yc_cl_total_dc, $account->yc_cl_total);
                $html .= '</td>';
                $html .= '<td class="text-right" align="right">';
                $html .= CoreAccounts::toCurrency($account->yp_cl_total_dc, $account->yp_cl_total);
                $html .= '</td>';
                
            }
         
            $html .= '</tr>';
         
        }
        if(count($account->children_groups)) {
            foreach ($account->children_groups as $id => $data)
            {
                $counter++;
              
                $html .= self::generateSheet($data, $counter, $dc_type);
                $counter--;
            }

            if (!in_array($account->id, $array)) {
                $html .= '<tr class="tr-group">';
                $html .= '<td class="total-bg-filled" style ="background:#dcd6d6;font-weight:700;">' . $this->print_space($counter) . 'Total of ' . self::toCodeWithName($account->code, $account->name) . '</td>';
                $html .= '<td class="text-right total-bg-filled" style="background:#dcd6d6;font-weight:700;border-top: 1px solid black !important;" align="right">';
                $html .= CoreAccounts::toCurrency($account->cl_total_dc, $account->cl_total);
                $html .= '</td>';
                $html .= '<td class="text-right total-bg-filled" style="border-top: 1px solid black !important;background:#dcd6d6;font-weight:700;" align="right">';
                $html .= CoreAccounts::toCurrency($account->p_cl_total_dc, $account->p_cl_total);
                $html .= '</td>';
                $html .= '<td class="text-right total-bg-filled" style="border-top: 1px solid black !important;background:#dcd6d6;font-weight:700;" align="right">';
                $html .= CoreAccounts::toCurrency($account->qc_cl_total_dc, $account->qc_cl_total);
                $html .= '</td>';
                $html .= '<td class="text-right total-bg-filled" style="border-top: 1px solid black !important;background:#dcd6d6;font-weight:700;" align="right">';
                $html .= CoreAccounts::toCurrency($account->qp_cl_total_dc, $account->qp_cl_total);
                $html .= '</td>';
                $html .= '<td class="text-right total-bg-filled" style="border-top: 1px solid black !important;background:#dcd6d6;font-weight:700;" align="right">';
                $html .= CoreAccounts::toCurrency($account->yc_cl_total_dc, $account->yc_cl_total);
                $html .= '</td>';
                $html .= '<td class="text-right total-bg-filled" style="border-top: 1px solid black !important;background:#dcd6d6;font-weight:700;" align="right">';
                $html .= CoreAccounts::toCurrency($account->yp_cl_total_dc, $account->yp_cl_total);
                $html .= '</td>';
                $html .= '</tr>';
            }
        }

        return $html;
    }

    function print_space($count)
    {
        $html = '';
        for ($i = 1; $i <= $count; $i++) {
            $html .= '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
        }
        return $html;
    }

    static function printSpace($count)
    {
        $html = '';
        for ($i = 1; $i <= $count; $i++) {
            $html .= '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
        }
        return $html;
    }
}
