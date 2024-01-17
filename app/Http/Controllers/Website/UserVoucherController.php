<?php

namespace App\Http\Controllers;

use App\Http\Requests\Website\StoreVoucherRequest;
use App\Models\Voucher;
use Exception;
use Illuminate\Support\Facades\DB;

class UserVoucherController extends Controller
{
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
}
