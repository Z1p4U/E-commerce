<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\Website\StoreVoucherRecordRequest;
use App\Http\Resources\VoucherResource;
use App\Models\Item;
use App\Models\Voucher;
use App\Models\VoucherRecord;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class VoucherRecordController extends Controller
{
    public function showRecordBasedOnVoucherNumber(Request $request)
    {
        $vouchers = Voucher::where("voucher_number", $request->voucher_number)->first();

        if (is_null($vouchers)) {
            return response()->json([
                "message" => "There is no Voucher."
            ]);
        }

        $voucherResource = new VoucherResource($vouchers);

        return $this->success("Voucher", $voucherResource);
    }
}
