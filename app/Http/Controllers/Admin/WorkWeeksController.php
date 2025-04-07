<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Country;
use Illuminate\Http\Request;
use App\Services\WorkWeekServices;

class WorkWeeksController extends Controller
{
    protected $workWeekServices;

    /**
     * Constructor to initialize the service.
     */
    public function __construct(WorkWeekServices $WorkWeekServices)
    {
        $this->WorkWeekServices = $WorkWeekServices;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
//        $workWeeks = $this->WorkWeekServices->getAll();
        return view('admin.work_weeks.index');
    }

    /**
     * Fetch work week data (for AJAX or API).
     */


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $countries =Country::all();
        return view('admin.work_weeks.create',compact('countries'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $this->WorkWeekServices->store($request);
            return redirect()->route('admin.work-weeks.index')->with('success', 'Work week added successfully.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $workWeek = $this->WorkWeekServices->findById($id);
        return view('admin.work_weeks.show', compact('workWeek'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $workWeek = $this->WorkWeekServices->findById($id);
        return view('admin.work_weeks.edit', compact('workWeek'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try {
            $this->WorkWeekServices->update($request, $id);
            return redirect()->route('admin.work-weeks.index')->with('success', 'Work week updated successfully.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $this->WorkWeekServices->destroy($id);
            return redirect()->route('admin.work-weeks.index')->with('success', 'Work week deleted successfully.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
    public function getdata(Request $request)
    {
        return $this->WorkWeekServices->getdata($request);
    }
}
