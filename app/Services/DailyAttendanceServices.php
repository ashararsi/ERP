<?php

namespace App\Services;

use App\Models\Branch;
use App\Models\Company;
use App\Models\DailyAttendance;
use App\Models\Staff;
use App\Models\Supplier;
use App\Models\Unit;
use DataTables;
use Carbon\Carbon;


use Config;

class DailyAttendanceServices
{
    public function index($request)
    {
        $perPage = $request->get('per_page', 20);
        $posts = DailyAttendance::orderBy('created_at', 'desc')->paginate($perPage);
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

    public function create()
    {
        $data['Staff'] = Staff::all();
        $data['branches'] = Branch::all();
        return $data;
    }

    public function suptlier_get()
    {
        return DailyAttendance::all();
    }

    public function store($request)
    {


        return DailyAttendance::create($request->all());

    }

    public function edit($id)
    {
        return DailyAttendance::findOrFail($id);

    }

    public function update($request, $id)
    {
        $validated = $request->all();
        $transaction = DailyAttendance::find($id);
        if ($transaction) {
            $transaction->update($validated);
        }
        return $transaction;
    }

    public function destroy($id)
    {
        $Transaction = DailyAttendance::findOrFail($id);
        if ($Transaction) {
            $Transaction->delete();
        }
    }


    public function getBranches($id)
    {
        return DailyAttendance::where('company_id', $id)->get();
    }

    public function getdata($request)
    {
        $data = DailyAttendance::with('user')->select('*')->orderBy('id', 'desc');
        return Datatables::of($data)->addIndexColumn()
            ->addColumn('company', function ($row) {
                $btn = $row->company->name ?? 'N/A';
                return $btn;
            })->addColumn('user', function ($row) {
                $btn = $row->user->first_name ?? 'N/A';
                return $btn;
            })->addColumn('totalTime', function ($row) {
                $totalTime = '-';

                if ($row->time_in && $row->time_out) {
                    $in = Carbon::createFromFormat('H:i:s', $row->time_in);
                    $out = Carbon::createFromFormat('H:i:s', $row->time_out);
                    $diff = $in->diff($out);

                    $totalTime = $diff->h . ' hours';
                    if ($diff->i > 0) {
                        $totalTime .= ' ' . $diff->i . ' minutes';
                    }

                }
                return $totalTime;

            })->addColumn('user_email', function ($row) {
                $btn = $row->user->pemail ?? 'N/A';
                return $btn;
            })->addColumn('action', function ($row) {
                $btn = ' <form  method="POST" onsubmit="return confirm(' . "'Are you sure you want to Delete this?'" . ');"  action="' . route("admin.attendance.destroy", $row->id) . '"> ';
                $btn = $btn . '<a href=" ' . route("admin.attendance.show", $row->id) . '"  class="ml-2"><i class="fas fa-eye"></i></a>';
                $btn = $btn . ' <a href="' . route("admin.attendance.edit", $row->id) . '" class="ml-2">  <i class="fas fa-edit"></i></a>';
                $btn = $btn . '<button  type="submit" class="ml-2" ><i class="fas fa-trash"></i></button>';
                $btn = $btn . method_field('DELETE') . '' . csrf_field();
                $btn = $btn . ' </form>';
                return $btn;
            })
            ->rawColumns(['action'])
            ->make(true);

    }
}
