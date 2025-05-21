<?php
namespace App\Services;

use App\Models\Bilty;
use App\Models\SalesOrder;
use Illuminate\Http\Request;

class BiltyServices
{
    protected Bilty $model;

    public function __construct(Bilty $model)
    {
        $this->model = $model;
    }

    public function store(Request $request): Bilty
    {
        $bilty = $this->model->create($request->only([
            'goods_name', 'place', 'bilty_no', 'bilty_date',
            'courier_date', 'receipt_no', 'cartons', 'fare'
        ]));

        if ($request->has('invoice_ids')) {
            SalesOrder::whereIn('id', $request->invoice_ids)->update(['bilty_id' => $bilty->id]);
        }

        return $bilty;
    }

    public function update(Request $request, Bilty $bilty): Bilty
    {
        $bilty->update($request->only([
            'goods_name', 'place', 'bilty_no', 'bilty_date',
            'courier_date', 'receipt_no', 'cartons', 'fare'
        ]));

        SalesOrder::where('bilty_id', $bilty->id)->update(['bilty_id' => null]);

        if ($request->has('invoice_ids')) {
            SalesOrder::whereIn('id', $request->invoice_ids)->update(['bilty_id' => $bilty->id]);
        }

        return $bilty;
    }

    public function delete(Bilty $bilty): void
    {
        SalesOrder::where('bilty_id', $bilty->id)->update(['bilty_id' => null]);
        $bilty->delete();
    }

    public function getData()
    {
        $data = $this->model::orderBy('id', 'desc');
        return generateDataTable($data, 'admin.bilties');
    }
}
