<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\Admin\StoreStockRequest;
use App\Http\Resources\StockResource;
use App\Models\Item;
use App\Models\Stock;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class StockController extends Controller
{
    public function index()
    {
        $stocks = Stock::whereIn('item_id', Item::pluck('id'))
            ->sortingQuery()
            ->paginationQuery();

        if ($stocks->count()  === 0) {
            return $this->notFound("There's no item yet");
        }

        return StockResource::collection($stocks);
    }

    public function store(StoreStockRequest $request)
    {

        $payload = collect($request->validated());
        $payload['admin_id'] = auth('admin')->id();

        DB::beginTransaction();
        try {
            $stock = new Stock();

            $stock = Stock::create($payload->toArray());

            $item = Item::findOrFail($request->item_id);
            $item->total_stock = $item->total_stock + $request->quantity;
            $item->update();

            $stock->save();
            $stockResource = new StockResource($stock);

            DB::commit();

            return $this->success('Your item is ready to sell', $stockResource);
        } catch (ModelNotFoundException $e) {
            DB::rollback();
            $errorMessage = 'There is no item yet';

            return response()->json(['error' => $errorMessage], 404);
        } catch (Exception $e) {
            DB::rollback();

            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
