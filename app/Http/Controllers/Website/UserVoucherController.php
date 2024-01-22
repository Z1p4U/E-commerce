<?php

namespace App\Http\Controllers\Website;

use App\Http\Resources\VoucherResource;
use App\Models\Item;
use App\Models\Voucher;
use App\Models\VoucherRecord;
use Attribute;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class UserVoucherController extends WebController
{
    public function index()
    {
        $userId = auth('api')->id();
        $voucher = Voucher::where('user_id', $userId)
            ->searchQuery()
            ->sortingQuery()
            ->paginationQuery();

        $totalVoucher = $voucher->count('id');
        $total = $voucher->sum('total');

        $data =  VoucherResource::collection($voucher);

        return response()->json([
            "all_time" => [
                "total_voucher" => $totalVoucher,
                "total" => $total,
            ],
            "data" => $data->resource,
        ], 200);
    }

    public function show(string $id)
    {
        DB::beginTransaction();

        try {
            $voucher = Voucher::findOrFail($id);

            if ($voucher->user_id != Auth::id()) {
                return $this->unauthorized("Not your voucher.");
            }

            $voucherResource = new VoucherResource($voucher);

            DB::commit();

            return $this->success('Voucher Detail', $voucherResource);
        } catch (ModelNotFoundException $e) {
            DB::rollback();
            $errorMessage = 'Voucher not found';

            return response()->json(['error' => $errorMessage], 404);
        } catch (Exception $e) {
            DB::rollback();

            return response()->json(['error' => $e->getMessage()], 500);
        }
    }


    // public function open(Request $request)
    // {
    //     $payload = collect($request->validated());
    //     $user = auth('api')->user();

    //     DB::beginTransaction();
    //     try {
    //         $characters = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
    //         $charactersLength = strlen($characters);
    //         $randomString = '';
    //         for ($i = 0; $i < 10; $i++) {
    //             $randomString .= $characters[rand(0, $charactersLength - 1)];
    //         };

    //         // $payload['user_id'] = auth('api')->id();
    //         // $payload['address'] = $user->address;
    //         // $payload['phone'] = $user->phone;
    //         // $payload['voucher_number'] = $randomString;
    //         $total = 0;
    //         // $payload['total'] = $total;

    //         $voucher = Voucher::create([
    //             'user_id' => auth('api')->id(),
    //             'address' => $user->address,
    //             'phone' => $user->phone,
    //             'voucher_number' => $randomString,
    //             'total' => $total,
    //         ]);

    //         DB::commit();

    //         return $this->success('Voucher created successfully', $voucher);
    //     } catch (Exception $e) {
    //         DB::rollback();

    //         return response()->json(['error' => $e->getMessage()], 500);
    //     }
    // }

    // public function removeFromCart(Request $request, string $id)
    // {
    //     $recordedItem = VoucherRecord::where("voucher_id", $id)->where("item_id", $request->item_id)->first();
    //     $voucher = Voucher::where("id", $recordedItem->voucher_id)->first();
    //     $item = Item::find($request->item_id);

    //     if (is_null($recordedItem || $item || $voucher)) {
    //         return response()->json([
    //             "message" => "Not Found "
    //         ], 404);
    //     }

    //     //Update Voucher Total
    //     $cost = $recordedItem->item->price * $recordedItem->quantity;
    //     $voucher->total -= $cost;
    //     $voucher->update();

    //     //Update Item Stock
    //     $item->total_stock += $recordedItem->quantity;
    //     $item->update();

    //     $recordedItem->delete();

    //     return $this->success("Deletion Success");
    // }
}
