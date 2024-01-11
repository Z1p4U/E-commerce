<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\Admin\StoreItemRequest;
use App\Http\Requests\Admin\UpdateItemRequest;
use App\Http\Resources\ItemResource;
use App\Models\Item;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\DB;

class ItemController extends Controller
{
    public function index()
    {
        $item = Item::searchQuery()
            ->sortingQuery()
            ->paginationQuery();

        DB::beginTransaction();
        try {

            $itemResource = ItemResource::collection($item);
            DB::commit();

            return $this->success("Item List", $item);
        } catch (Exception $e) {
            DB::rollback();
            // throw $e;
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function store(StoreItemRequest $request)
    {
        $payload = collect($request->validated());

        DB::beginTransaction();
        try {
            if ($payload['sale'] === null) {
                $payload['sale'] = 0;
            };

            $item = Item::create($payload->toArray());

            DB::commit();

            return $this->success('Item created successfully', $item);
        } catch (Exception $e) {
            DB::rollback();

            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function show(String $id)
    {
        DB::beginTransaction();

        try {
            $item = Item::findOrFail($id);

            $itemResource = new ItemResource($item);

            DB::commit();

            return $this->success('Item Detail', $itemResource);
        } catch (ModelNotFoundException $e) {
            DB::rollback();
            $errorMessage = 'Item not found';

            return response()->json(['error' => $errorMessage], 404);
        } catch (Exception $e) {
            DB::rollback();

            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function update(UpdateItemRequest $request, String $id)
    {
        $payload = collect($request->validated());
        DB::beginTransaction();
        try {
            $item = Item::findOrFail($id);

            if ($payload['sale'] === null) {
                $payload['sale'] = 0;
            };

            $item->update($payload->toArray());
            DB::commit();

            return $this->success('Item updated successfully', $item);
        } catch (ModelNotFoundException $e) {
            DB::rollback();
            $errorMessage = 'Item not found';

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
            $item = Item::findOrFail($id);

            $item->delete($id);
            DB::commit();

            return $this->success('Item deleted successfully', $item);
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
