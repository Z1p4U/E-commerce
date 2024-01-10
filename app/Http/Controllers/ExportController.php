<?php

namespace App\Http\Controllers;

use App\Exports\ItemsExport;
use App\Http\Resources\ItemResource;
use App\Models\Item;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class ExportController extends Controller
{
    public function ExcelExport()
    {
        // $export = new ItemsExport();
        // return Excel::download($export, 'items.xlsx', \Maatwebsite\Excel\Excel::XLSX);

        $items = Item::all();
        $itemResources = ItemResource::collection($items);

        return Excel::download(new ItemsExport($itemResources), 'ItemsInExcel.xlsx');
    }

    public function CsvExport()
    {
        // $export = new ItemsExport();
        // return Excel::download($export, 'items.csv', \Maatwebsite\Excel\Excel::CSV, [
        //     'Content-Type' => 'text/csv',
        // ]);

        $items = Item::all();
        $itemResources = ItemResource::collection($items);

        return Excel::download(new ItemsExport($itemResources), 'ItemsInCsv.csv');
    }
}
