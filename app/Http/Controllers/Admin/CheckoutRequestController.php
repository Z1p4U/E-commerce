<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\Admin\CheckoutRequest;
use App\Http\Resources\CheckoutResource;
use App\Models\Checkout;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CheckoutRequestController extends Controller
{
    public function index()
    {
        $checkoutRequest = Checkout::searchQuery()
            ->sortingQuery()
            ->paginationQuery();

        try {
            $checkoutRequestResource = CheckoutResource::collection($checkoutRequest);

            return $this->success("Checkout Request List", $checkoutRequest);
        } catch (Exception $e) {
            DB::rollback();
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function show(string $id)
    {
        DB::beginTransaction();

        try {
            $checkoutRequest = Checkout::findOrFail($id);

            $checkoutRequestResource = new CheckoutResource($checkoutRequest);

            DB::commit();

            return $this->success('Checkout Request Detail', $checkoutRequestResource);
        } catch (ModelNotFoundException $e) {
            DB::rollback();
            $errorMessage = 'Checkout Request not found';

            return response()->json(['error' => $errorMessage], 404);
        } catch (Exception $e) {
            DB::rollback();

            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function interact(CheckoutRequest $request, $id)
    {
        $payload = collect($request->validated());

        DB::beginTransaction();
        try {
            $checkoutRequest = Checkout::findOrFail($id);

            if ($checkoutRequest->status != "Pending") {
                return $this->unauthorized('This request has already approved or denied.');
            }

            $checkoutRequest->update($payload->toArray());

            DB::commit();
            return $this->success($checkoutRequest->status . " Successfully!", $checkoutRequest);
        } catch (ModelNotFoundException $e) {
            DB::rollback();
            $errorMessage = 'Request not found';

            return response()->json(['error' => $errorMessage], 404);
        } catch (Exception $e) {
            DB::rollback();

            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
