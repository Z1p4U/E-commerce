<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreVoucherRecordRequest;
use App\Http\Requests\UpdateVoucherRecordRequest;
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

    public function store(StoreVoucherRecordRequest $request)
    {
        $item = Item::find($request->item_id);
        // if there is no stock show error
        if ($item->total_stock === 0) {
            return response()->json([
                "message" => "Out of stock"
            ]);
        }

        $payload = collect($request->validated());

        DB::beginTransaction();
        try {
            $record = VoucherRecord::create($payload->toArray());
            $cost = $request->quantity * $item->price; // product cost based on quantity
            $record->cost = $cost;

            //check available voucher
            $voucher = Voucher::where("id", $request->voucher_id)->first();
            if (is_null($voucher)) {
                return  $this->notFound('There is no voucher yet');
            };

            // updating voucher
            $voucher->total += $cost;
            $voucher->update();

            // updating item
            $item->total_stock -=  $request->quantity;
            $item->update();

            // save record
            $record->save();


            DB::commit();

            return $this->success('Your product is added to voucher.', $record);
        } catch (Exception $e) {
            DB::rollback();

            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function destroy(Request $request, string $id)
    {
        $recordedItem = VoucherRecord::where("voucher_id", $id)->where("item_id", $request->item_id)->first();
        $voucher = Voucher::where("id", $recordedItem->voucher_id)->first();
        $item = Item::find($request->item_id);

        if (is_null($recordedItem || $item || $voucher)) {
            return response()->json([
                "message" => "Not Found "
            ], 404);
        }

        //Update Voucher Total
        $cost = $recordedItem->item->price * $recordedItem->quantity;
        $voucher->total -= $cost;
        $voucher->update();

        //Update Item Stock
        $item->total_stock += $recordedItem->quantity;
        $item->update();

        $recordedItem->delete();

        return $this->success("Deletion Success");
    }
}
