<?php

namespace App\Http\Controllers\Website;

use App\Http\Requests\Website\PurchaseRequest;
use App\Http\Requests\Website\StoreVoucherRecordRequest;
use App\Http\Resources\CheckoutResource;
use App\Http\Resources\PhotoDetailResource;
use App\Http\Resources\VoucherResource;
use App\Models\Checkout;
use App\Models\Item;
use App\Models\Product;
use App\Models\User;
use App\Models\Voucher;
use App\Models\VoucherRecord;
use Illuminate\Http\Request;
use App\Rules\CheckItemQuantity;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class CheckoutController extends WebController
{
    public function addToCart(Request $request)
    {
        try {
            DB::beginTransaction();

            $user = auth('api')->user();
            $userId = auth('api')->id();
            // Collecting Item[] from request
            $itemIds = collect($request->items)->pluck("item_id");
            $itemList = Item::whereIn("id", $itemIds)->get(); // searching items
            $total = 0;

            foreach ($request->items as $item) {
                $currentItem = $itemList->find($item["item_id"]);
                if (is_null($currentItem)) {
                    return $this->notFound('There is no Item.');
                }

                $total += $item["quantity"] * ($currentItem->discount_price ? $currentItem->discount_price : $currentItem->price);
            }

            //creating voucher
            $characters = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
            $charactersLength = strlen($characters);
            $randomString = '';
            for ($i = 0; $i < 8; $i++) {
                $randomString .= $characters[rand(0, $charactersLength - 1)];
            }
            $voucher = Voucher::create([
                "voucher_number" => $randomString,
                'address' => $user->address,
                'phone' => $user->phone,
                "total" => $total,
                "user_id" => $userId,
            ]);

            $records = [];
            $request->validate([
                'items' => ['required', 'array', new CheckItemQuantity]
            ]);
            foreach ($request->items as $item) {

                $currentItem = $itemList->find($item["item_id"]);
                $records[] = [
                    "voucher_id" => $voucher->id,
                    "item_id" => $item["item_id"],
                    "quantity" => $item["quantity"],
                    "cost" => $item["quantity"] * ($currentItem->discount_price ? $currentItem->discount_price : $currentItem->price),
                    "created_at" => now(),
                    "updated_at" => now()
                ];

                Item::where("id", $item["item_id"])->update([
                    "total_stock" => $currentItem->total_stock - $item["quantity"]
                ]);
            }

            $voucherRecords = VoucherRecord::insert($records); // use database
            DB::commit();
            return response()->json([
                'message' => 'Checkout successfully',
                "data" => new VoucherResource($voucher)
            ]);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['message' => 'Transaction failed.', 'error' => $e->getMessage()], 500);
        }
    }

    public function purchase(PurchaseRequest $request, $id)
    {
        $payload = collect($request->validated());

        DB::beginTransaction();

        try {
            $user = auth('api')->user();
            $userId = auth('api')->id();
            $voucher = Voucher::findOrFail($id);
            if ($voucher->user_id != $user->id) {
                return $this->unauthorized("Not your voucher.");
            }

            $photo = $request->file('photo');
            $savedPhoto = $photo->store("public/photo/user");

            $payload['voucher_id'] = $voucher->id;
            $payload['user_id'] = $userId;
            $payload['photo'] = $savedPhoto;

            $checkout = Checkout::create($payload->toArray());

            $checkoutResource = new CheckoutResource($checkout);

            DB::commit();

            return $this->success('Purchased successfully', $checkoutResource);
        } catch (ModelNotFoundException $e) {
            DB::rollback();
            $errorMessage = 'Voucher not found';
            return response()->json(['error' => $errorMessage], 404);
        } catch (Exception $e) {
            DB::rollback();
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function singleItemCheckOut(StoreVoucherRecordRequest $request, $id)
    {
        $user = auth('api')->user();
        $userId = auth('api')->id();
        $item = Item::findOrFail($id);
        // if there is no stock show error
        if ($item->total_stock === 0) {
            return $this->notFound("Out of stock");
        }
        DB::beginTransaction();
        try {
            //creating voucher
            $characters = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
            $charactersLength = strlen($characters);
            $randomString = '';
            for ($i = 0; $i < 10; $i++) {
                $randomString .= $characters[rand(0, $charactersLength - 1)];
            };
            $total = 0;

            $voucher = Voucher::create([
                'user_id' => $userId,
                'address' => $user->address,
                'phone' => $user->phone,
                'voucher_number' => $randomString,
                'total' => $total,
            ]);

            //collecting payload and adding record to cart(voucher)
            $payload = collect($request->validated());
            $payload['voucher_id'] = $voucher->id;
            $payload['item_id'] = $item->id;

            $record = VoucherRecord::create($payload->toArray());
            $cost = $request->quantity * $item->price; // product cost based on quantity
            $record->cost = $cost;

            // updating voucher
            $voucher->total += $cost;
            $voucher->update();

            // updating item stock
            $item->total_stock -=  $request->quantity;
            $item->update();

            // save record
            $record->save();

            DB::commit();
            return $this->success('Your item is ready to check out', $record);
        } catch (ModelNotFoundException $e) {
            DB::rollback();
            $errorMessage = 'Item not found';

            return response()->json(['error' => $errorMessage], 404);
        } catch (Exception $e) {
            DB::rollback();

            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
