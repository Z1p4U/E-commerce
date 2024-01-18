<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\Admin\StoreVoucherRequest;
use App\Http\Resources\VoucherResource;
use App\Models\Voucher;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class VoucherController extends Controller
{
    public function index()
    {
        $voucher = Voucher::searchQuery()
            ->sortingQuery()
            ->paginationQuery();;

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

    public function dailyList(Request $request)
    {
        $date = $request->has('date') ? $request->date : now()->format('Y-m-d');

        $dailyVoucher = Voucher::WhereDate('created_at', $date)->get();
        $totalVoucher = $dailyVoucher->count('id');
        $total = $dailyVoucher->sum('total');

        $voucher = Voucher::WhereDate('created_at', $date)->latest("id")
            ->sortingQuery()
            ->paginationQuery();


        $data =  VoucherResource::collection($voucher);

        return response()->json([
            "Voucher Info" => [
                "date" => $date,
                "total_voucher" => $totalVoucher,
                "total_amount" => $total,
            ],
            "data" => $data->resource,
        ], 200);
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
