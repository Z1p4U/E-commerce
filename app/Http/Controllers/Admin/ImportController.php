<?php

namespace App\Http\Controllers\Admin;

use App\Imports\ItemsImport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;

class ImportController extends Controller
{
    public function CsvImport(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'file' => 'required|mimes:csv,txt',
            ]);

            if ($validator->fails()) {
                return response()->json(['error' => $validator->errors()], 400);
            }

            // Import the Excel file and update prices
            $file = $request->file('file');
            Excel::import(new ItemsImport, $file);

            return response()->json(['message' => 'Updated successfully.']);
        } catch (\Exception $e) {

            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function ExcelImport(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'file' => 'required|mimes:xlsx,xls',
            ]);

            if ($validator->fails()) {
                return response()->json(['error' => $validator->errors()], 400);
            }

            // Import the Excel file and update prices
            $file = $request->file('file');


            Excel::import(new ItemsImport, $file);

            return response()->json(['message' => 'Updated successfully.']);
        } catch (\Exception $e) {

            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
