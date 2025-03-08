<?php

namespace App\Services;

use App\Models\Branch;
use App\Models\Branches;
use App\Models\Company;
use App\Models\Groups;
use App\Models\Ledger;

use DataTables;

use App\Helpers\CoreAccounts;
use App\Helpers\GroupsTree;
use Auth;

use Config;
use Illuminate\Http\Request;

class LedgerServices
{
    public function index()
    {
        $parentGroups = new GroupsTree();
        $parentGroups->current_id = -1;
        $parentGroups->build(0);

        $parentGroups->toListView($parentGroups, -1);

        return $parentGroups->groupListView;
        return view('accounts.groups.index', compact('Groups'));
    }

    public function getbranches()
    {
        return Branch::get();

    }

    public function getgroups()
    {
        return GroupsTree::buildOptions(GroupsTree::buildTree(Groups::OrderBy('id', 'asc')->get()->toArray()), old('group_id'));

    }

    public function create()
    {

        $parentGroups = new GroupsTree();
        $parentGroups->current_id = -1;
        $parentGroups->build(0);

        $parentGroups->toListView($parentGroups, -1);

        return $parentGroups->groupListView;

    }

    public function suptlier_get()
    {
        return Supplier::all();
    }

    public function store($request)
    {
//        return CoreAccounts::createGroup($request->all());

        $input = $request->all();

        $err = 0;
        $ledger_name = $input['name'];

        $branch = $request->branch_id;
        $input['branch_id'] = $request->branch_id;

        $branch_name = Branch::where('id', $request->branch_id)->value('name');
        $name = $ledger_name . '(' . $branch_name . ')';
        $input['group_id'] = $request->group_id;
        $input['name'] = $name;
        $company_id = Branch::whereId($branch)->value('company_id');
        $input['company_id'] = $company_id;

        $group_level = Groups::where('id', $input['group_id'])->value('level');

            self::getAllLedgersFromGroupId($input['group_id'], $input['name']);
            $response = CoreAccounts::createLedger($input);



        if ($response['status']) {
        } else {
            $err = 1;
        }


        if ($err == 1) {
            $request->flash();
            return redirect()->back()
                ->withErrors($response['error'])
                ->withInput();
        } else {

            return $response['id'];
//            return redirect()->route('admin.ledger.index')->with('success', 'New Ledger Added SuccessFully!');
        }
    }

    public function edit($id)
    {
        $ledger = Ledger::findOrFail($id);
        $branches = Branch::pluck('name', 'id');
        $groups = GroupsTree::buildOptions(GroupsTree::buildTree(Groups::OrderBy('id', 'asc')->get()->toArray()), $ledger->group_id);
        $company = Company::all()->pluck('name', 'id');
    $data = [
            'ledger' => $ledger,
            'branches' => $branches,
            'groups' => $groups,
            'company' => $company,
        ];
        return $data;



    }
    public function getAllLedgersFromGroupId($group_id, $ledger_name)
    {
        $all_ledgers = Ledger::where('group_id', '=', $group_id)->get();
        if (count($all_ledgers) > 0) {
            foreach ($all_ledgers as $singleLedger) {
                if ($singleLedger->name == $ledger_name) {
                    return redirect()->back()->with('success', 'Ledger with same name already exist!');
                }
            }
        }
    }

    public function getAllLedgersNotInGroups()
    {
        $array = array();
        $all_groups = Groups::pluck('id');
        $ledgers = Ledger::whereNotIn('group_id', $all_groups)->get();
        foreach ($ledgers as $ledger) {
            $array[$ledger->id] = [
                'number' => $ledger->number,
                'name' => $ledger->number . ' ' . $ledger->name,
                'opening_balance' => $ledger->opening_balance,
                'company_id' => $ledger->company_id,
                'branch_id' => $ledger->branch_id,
            ];
            $ledger->delete();
        }

        dd($array);
    }


    public function update($request, $id)
    {
        $data = $request->all();

        self::getAllLedgersFromGroupId($data['group_id'], $data['name']);

        $response = CoreAccounts::updateLedger($data, $id);

        if ($response['status']) {
            return redirect()->route('admin.ledger.index')->with('success', 'Record Updated SuccessFully!');
        } else {
            $request->flash();
            return redirect()->back()
                ->withErrors($response['error'])
                ->withInput();

            //echo 'Here I am'; exit;
        }
//        $Ledger = Ledger::findOrFail($id);
//
//        $data = $request->all();
//        $data['updated_by'] = Auth::user()->id;
//
//        // Get selected group
//        $Group = Groups::findOrFail($data['group_id']);
//
//        $data['group_number'] = $Group->number;
//        $data['account_type_id'] = $Group->account_type_id;
//        $data['number'] = CoreAccounts::generateLedgerNumber($Companie->id, $Group->number, $Ledger->id);
//
//        $Ledger->update($data);

    }

    public function destroy($id)
    {
        $Transaction = Ledger::findOrFail($id);
        if ($Transaction) {
            $Transaction->delete();
        }
    }


    public function getdata($request)
    {
        $data = Branch::with('company')->select('*')->orderBy('id', 'desc');
        return Datatables::of($data)->addIndexColumn()
            ->addColumn('company', function ($row) {
                $btn = $row->company->name ?? 'N/A';

                return $btn;
            })->addColumn('action', function ($row) {
                $btn = ' <form  method="POST" onsubmit="return confirm(' . "'Are you sure you want to Delete this?'" . ');"  action="' . route("admin.branches.destroy", $row->id) . '"> ';
                $btn = $btn . '<a href=" ' . route("admin.branches.show", $row->id) . '"  class="ml-2"><i class="fas fa-eye"></i></a>';
                $btn = $btn . ' <a href="' . route("admin.branches.edit", $row->id) . '" class="ml-2">  <i class="fas fa-edit"></i></a>';
                $btn = $btn . '<button  type="submit" class="ml-2" ><i class="fas fa-trash"></i></button>';
                $btn = $btn . method_field('DELETE') . '' . csrf_field();
                $btn = $btn . ' </form>';
                return $btn;
            })
            ->rawColumns(['action'])
            ->make(true);

    }

    public function ledger_already_created($request)
    {
        $query = $request->get('query');
        // Query your database or any data source to get matching results.
        $results = Ledger::where('name', 'like', '%' . $query . '%')->orderBy('id', 'desc')->get();

        $html = '';
        if ($query != null) {
            foreach ($results as $singleResult) {
                $html = $html . '<li class="list-group-item">' . $singleResult->number . " - " . $singleResult->name . '</li>';
            }
        }

        return $html;

    }
}
