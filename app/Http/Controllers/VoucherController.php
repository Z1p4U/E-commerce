<?php

namespace App\Http\Controllers;

use App\Http\Requests\Admin\StoreVoucherRequest;
use App\Http\Resources\ItemResource;
use App\Http\Resources\ProductResource;
use App\Http\Resources\VoucherResource;
use App\Models\Voucher;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class VoucherController extends Controller
{
    public function index(Request $request)
    {
        $date = $request->has('date') ? $request->date : now();

        $dailyVoucher = Voucher::WhereDate('created_at', $date)->get();
        $totalVoucher = $dailyVoucher->count('id');
        $total = $dailyVoucher->sum('total');

        $voucher = Voucher::WhereDate('created_at', $date)->latest("id")
            ->sortingQuery()
            ->paginationQuery();


        $data =  VoucherResource::collection($voucher);

        return response()->json([
            "daily_total_sale" => [
                "total_voucher" => $totalVoucher,
                "total" => $total,
            ],
            "data" => $data->resource,
        ], 200);
    }

    public function store(StoreVoucherRequest $request)
    {
        $payload = collect($request->validated());

        DB::beginTransaction();
        try {
            $characters = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
            $charactersLength = strlen($characters);
            $randomString = '';
            for ($i = 0; $i < 10; $i++) {
                $randomString .= $characters[rand(0, $charactersLength - 1)];
            };

            $payload['user_id'] = auth('api')->id();
            $payload['voucher_number'] = $randomString;
            $total = 0;
            $payload['total'] = $total;

            $voucher = Voucher::create($payload->toArray());

            DB::commit();

            return $this->success('Voucher created successfully', $voucher);
        } catch (Exception $e) {
            DB::rollback();

            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function show(string $id)
    {
        DB::beginTransaction();

        try {
            $voucher = Voucher::findOrFail($id);

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

    public function destroy(String $id)
    {
        DB::beginTransaction();
        try {
            $voucher = Voucher::findOrFail($id);

            $voucher->delete($id);
            DB::commit();

            return $this->success('Voucher deleted successfully', $voucher);
        } catch (ModelNotFoundException $e) {
            DB::rollback();
            $errorMessage = 'Voucher not found';

            return response()->json(['error' => $errorMessage], 404);
        } catch (Exception $e) {
            DB::rollback();

            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
