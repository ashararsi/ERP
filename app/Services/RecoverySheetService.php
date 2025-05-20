<?php

namespace App\Services;

use App\Models\Area;
use App\Models\City;
use App\Models\Customer;
use App\Models\RecoverySheetFilter;
use App\Models\User;
use App\Models\UserLocationAssignment;
use Carbon\Carbon;
use DataTables;
use Termwind\Components\Dd;

class RecoverySheetService
{
    public function getSalesPersons()
    {
        return User::with('roles')
            ->select('id', 'email', 'name')
            ->orderBy('id', 'desc')
            ->whereHas('roles', function ($query) {
                $query->where('name', 'Spo');
            })->get();
    }

    public function generateData(array $filters)
    {
       
        $this->storeFilters($filters);
        // dd($filters);
        $customers = $this->fetchFilteredCustomers($filters);

        $salesPerson = User::find($filters['sales_person_id']);

        $start = Carbon::parse($filters['start_date'])->startOfDay();
        $end = Carbon::parse($filters['end_date'])->endOfDay();

        return compact('customers', 'salesPerson', 'start', 'end');
    }

    private function storeFilters(array $filters): void
    {
        // dd($filters);
        $cities = $filters['city_id'] ?? [];
        $areas = $filters['area_id'] ?? [];

        sort($cities);
        sort($areas);

        $citiesJson = json_encode(array_map('intval', $cities));
        $areasJson = json_encode(array_map('intval', $areas));

        $existingFilter = RecoverySheetFilter::where('sales_person_id', $filters['sales_person_id'])
            ->where('start_date', $filters['start_date'])
            ->where('end_date', $filters['end_date'])
            // ->where('cities', $citiesJson)
            // ->where('areas', $areasJson)
            ->first();

            // dd($existingFilter);

        if ($existingFilter) {
            return;
        }

        $lastSerial = RecoverySheetFilter::max('serial_no') ?? 0;
        $serialNo = $lastSerial + 1;
        RecoverySheetFilter::create([
            'serial_no' => $serialNo,
            'sales_person_id' => $filters['sales_person_id'],
            'start_date' => $filters['start_date'],
            'end_date' => $filters['end_date'],
            'cities' => $citiesJson,
            'areas' => $areasJson,
        ]);
    }


    public function fetchFilteredCustomers(array $filters)
    {
        $start = Carbon::parse($filters['start_date'])->startOfDay();
        $end = Carbon::parse($filters['end_date'])->endOfDay();

        $query = Customer::where('spo_id', $filters['sales_person_id']);

        if (!empty($filters['cities']) && !(count($filters['cities']) === 1 && $filters['cities'][0] === '0')) {
            $query->whereIn('city_id', $filters['cities']);
        }

        if (!empty($filters['areas']) && is_array($filters['areas'])) {
            $query->whereIn('area_id', $filters['areas']);
        }

        $customers = $query->with(['salesOrders' => function ($query) use ($start, $end) {
            $query->whereBetween('order_date', [$start, $end])->with('payments');
        }])->get();

        return $customers->filter(fn($customer) => $this->hasPendingPayments($customer));
    }

    public function hasPendingPayments($customer): bool
    {
        foreach ($customer->salesOrders as $order) {
            $totalPaid = $order->payments->sum('amount');
            if ($order->net_total > $totalPaid) {
                return true;
            }
        }
        return false;
    }


    public function getLocations($salesPersonIds)
    {
        $assignments = UserLocationAssignment::where('user_id', $salesPersonIds)->get();

        $cityIds = $assignments->pluck('city_id')->unique()->filter();
        $areaIds = $assignments->pluck('area_id')->unique()->filter();

        $cities = City::whereIn('id', $cityIds)->get(['id', 'name']);
        $areas = Area::whereIn('id', $areaIds)->get(['id', 'name']);

        return compact('cities', 'areas');
    }

    public function getFiltersDataTable()
    {
        $filters = RecoverySheetFilter::query()->with('salesPerson');

        return DataTables::of($filters)
            ->addColumn('date_range', function ($row) {
                return $row->start_date . ' to ' . $row->end_date;
            })
            ->addColumn('cities', function ($row) {
                $cityIds = json_decode($row->cities, true) ?? [];
                return City::whereIn('id', $cityIds)->pluck('name')->implode(', ');
            })
            ->addColumn('areas', function ($row) {
                $areaIds = json_decode($row->areas, true) ?? [];
                return Area::whereIn('id', $areaIds)->pluck('name')->implode(', ');
            })
            
            ->addColumn('sales_person', function ($row) {
                return $row->salesPerson->name ?? 'N/A';
            })
            // ->addColumn('customer_count', function ($row) {
            //     $filterArray = [
            //         'sales_person_id' => $row->sales_person_id,
            //         'start_date' => $row->start_date,
            //         'end_date' => $row->end_date,
            //         'cities' => json_decode($row->cities, true),
            //         'areas' => json_decode($row->areas, true),
            //     ];
            //     return $this->fetchFilteredCustomers($filterArray)->count();
            // })
            ->addColumn('action', function ($row) {
                $params = http_build_query([
                    'start_date' => $row->start_date,
                    'end_date' => $row->end_date,
                    'sales_person_id' => $row->sales_person_id,
                    'cities' => json_decode($row->cities, true),
                    'areas' => json_decode($row->areas, true),
                ]);
            
                $url = route('admin.recovery_sheets_data.generate') . '?' . $params;
            
                return '<a href="' . $url . '" target="_blank" class="btn btn-sm btn-primary">Generate PDF</a>';
            })
            ->rawColumns(['cities', 'areas','action'])
            ->make(true);
    }
}
