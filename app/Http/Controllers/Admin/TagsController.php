<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\StoreTagsRequest;
use App\Http\Requests\UpdateTagsRequest;
use App\Models\Tags;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\DB;

class TagsController extends Controller
{
    public function index()
    {
        $tags = Tags::searchQuery()
            ->sortingQuery()
            ->paginationQuery();

        DB::beginTransaction();

        try {
            DB::commit();
            return $this->success("Tags List", $tags);
        } catch (Exception $e) {
            DB::rollback();
            // throw $e;
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function store(StoreTagsRequest $request)
    {
        $payload = collect($request->validated());

        DB::beginTransaction();
        try {

            $tags = Tags::create($payload->toArray());
            DB::commit();

            return $this->success('Tags created successfully', $tags);
        } catch (Exception $e) {
            DB::rollback();
            // throw $e;
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function show(String $id)
    {
        DB::beginTransaction();

        try {
            $tags = Tags::findOrFail($id);
            DB::commit();

            return $this->success('Tags Detail', $tags);
        } catch (ModelNotFoundException $e) {
            DB::rollback();
            $errorMessage = 'Tags not found';

            return response()->json(['error' => $errorMessage], 404);
        } catch (Exception $e) {
            DB::rollback();

            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function update(UpdateTagsRequest $request, String $id)
    {
        $payload = collect($request->validated());
        DB::beginTransaction();
        try {

            $tags = Tags::findOrFail($id);
            $tags->update($payload->toArray());
            DB::commit();

            return $this->success('Tags updated successfully', $tags);
        } catch (ModelNotFoundException $e) {
            DB::rollback();
            $errorMessage = 'Tags not found';

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

            $tags = Tags::findOrFail($id);

            $tags->delete($id);
            DB::commit();

            return $this->success('Tags deleted successfully', $tags);
        } catch (ModelNotFoundException $e) {
            DB::rollback();
            $errorMessage = 'Tags not found';

            return response()->json(['error' => $errorMessage], 404);
        } catch (Exception $e) {
            DB::rollback();
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
