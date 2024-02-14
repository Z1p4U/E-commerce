<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\Admin\StoreVoucherRequest;
use App\Http\Resources\VoucherResource;
use App\Models\Voucher;
use Carbon\Carbon;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\DB;

class VoucherController extends Controller
{
    public function index(Request $request)
    {
        $type = $request->input('type', default: 'daily');
        $date = $request->has('date') ? $request->date : now()->format('Y-m-d');

        DB::beginTransaction();

        try {
            switch ($type) {
                case 'monthly':
                    $startDate = Carbon::parse($date)->startOfMonth();
                    $endDate = Carbon::parse($date)->endOfMonth();
                    $thisMonth = Carbon::parse($date)->format("F Y");
                    break;

                case 'yearly':
                    $startDate = Carbon::parse($date)->startOfYear();
                    $endDate = Carbon::parse($date)->endOfYear();
                    $thisYear = Carbon::parse($date)->format("Y");

                    break;

                default: // Daily
                    $startDate = $endDate = Carbon::parse($date);
                    break;
            }

            $vouchers = Voucher::whereDate('created_at', '>=', $startDate)
                ->whereDate('created_at', '<=', $endDate)
                ->latest('id')
                ->searchQuery()
                ->sortingQuery()
                ->paginationQuery();

            $totalVoucher = $vouchers->count();
            $totalAmount = $vouchers->sum('total');
            $totalItems = $vouchers->sum('total_items');

            $data = VoucherResource::collection($vouchers);

            $voucherInfo = [
                "type" => $type,
                "start_date" => $startDate->format('Y-m-d'),
                "end_date" => $endDate->format('Y-m-d'),
                "total_voucher" => $totalVoucher,
                "total_item" => $totalItems,
                "total_amount" => $totalAmount,
            ];

            if ($type === 'monthly') {
                $voucherInfo['this_month'] = $thisMonth;
            }
            if ($type === 'yearly') {
                $voucherInfo['this_year'] = $thisYear;
            }

            return response()->json([
                "Voucher Info" => $voucherInfo,
                "data" => $data->resource,
            ], 200);
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
}
