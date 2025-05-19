<?php

namespace App\Http\Controllers;

use App\Services\RecoverySheetService;
use Illuminate\Http\Request;
use PDF;

class RecoverySheetController extends Controller
{
    protected $service;

    public function __construct(RecoverySheetService $service)
    {
        $this->service = $service;
    }

    public function index()
    {
        $salesPersons = $this->service->getSalesPersons();
        return view('admin.recovery_sheet.index', compact('salesPersons'));
    }

    public function generate(Request $request)
    {
        $data = $this->service->generateData($request->all());

        $pdf = PDF::loadView('admin.recovery_sheet.pdf', [
            'customers' => $data['customers'],
            'salesPerson' => $data['salesPerson'],
            'start' => $data['start'],
            'end' => $data['end'],
        ]);

        return $pdf->stream('RecoverySheet_' . $data['salesPerson']->name . '.pdf');
    }

    public function getLocations(Request $request)
    {
        $salesPersonIds = $request->sales_person_ids;
        $data = $this->service->getLocations($salesPersonIds);

        return response()->json([
            'cities' => $data['cities'],
            'areas' => $data['areas'],
        ]);
    }

    public function listStoredFilters()
    {
        return view('admin.recovery_sheet.list_filters');
    }


    public function filtersData(Request $request)
    {
        return $this->service->getFiltersDataTable();
    }

        public function generateRecvoerySheet(Request $request)
    {
        $filters =    $request->query();
        $data = $this->service->generateData($request->all());

        $pdf = PDF::loadView('admin.recovery_sheet.pdf', [
            'customers' => $data['customers'],
            'salesPerson' => $data['salesPerson'],
            'start' => $data['start'],
            'end' => $data['end'],
        ]);

        return $pdf->stream('RecoverySheet_' . $data['salesPerson']->name . '.pdf');
    }
}
