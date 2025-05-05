<?php

use Yajra\DataTables\Facades\DataTables;

if (!function_exists('generateDataTable')) {
    /**
     * Generate a common DataTable.
     */
    function generateDataTable($query, string $routePrefix)
    {
        return DataTables::of($query)
            ->addIndexColumn()
            ->addColumn('action', function ($row) use ($routePrefix) {
                $confirm = "return confirm('Are you sure you want to Delete this?')";
                $btn  = '<form method="POST" onsubmit="' . $confirm . '" action="' . route("$routePrefix.destroy", $row->id) . '">';
                $btn .= '<a href="' . route("$routePrefix.show", $row->id) . '" class="ml-2"><i class="fas fa-eye"></i></a>';
                $btn .= '<a href="' . route("$routePrefix.edit", $row->id) . '" class="ml-2"><i class="fas fa-edit"></i></a>';
                $btn .= '<button type="submit" class="ml-2"><i class="fas fa-trash"></i></button>';
                $btn .= method_field('DELETE') . csrf_field();
                $btn .= '</form>';
                return $btn;
            })
            ->rawColumns(['action'])
            ->make(true);
    }
}
