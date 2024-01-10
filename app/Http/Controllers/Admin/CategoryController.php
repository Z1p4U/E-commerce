<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\StoreCategoryRequest;
use App\Http\Requests\UpdateCategoryRequest;
use App\Models\Category;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\DB;

class CategoryController extends Controller
{
    public function index()
    {
        $category = Category::searchQuery()
            ->sortingQuery()
            ->paginationQuery();

        DB::beginTransaction();

        try {
            DB::commit();
            return $this->success("Category List", $category);
        } catch (Exception $e) {
            DB::rollback();

            // throw $e;
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function store(StoreCategoryRequest $request)
    {
        $payload = collect($request->validated());

        DB::beginTransaction();
        try {

            $category = Category::create($payload->toArray());
            DB::commit();

            return $this->success('Category created successfully', $category);
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
            $category = Category::findOrFail($id);
            DB::commit();

            return $this->success('Category Detail', $category);
        } catch (ModelNotFoundException $e) {
            DB::rollback();
            $errorMessage = 'Category not found';

            return response()->json(['error' => $errorMessage], 404);
        } catch (Exception $e) {
            DB::rollback();

            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function update(UpdateCategoryRequest $request, String $id)
    {
        $payload = collect($request->validated());

        DB::beginTransaction();
        try {

            $category = Category::findOrFail($id);
            $category->update($payload->toArray());
            DB::commit();

            return $this->success('Category updated successfully', $category);
        } catch (ModelNotFoundException $e) {
            DB::rollback();
            $errorMessage = 'Category not found';

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

            $category = Category::findOrFail($id);

            $category->delete($id);
            DB::commit();

            return $this->success('Category deleted successfully', $category);
        } catch (ModelNotFoundException $e) {
            DB::rollback();
            $errorMessage = 'Category not found';

            return response()->json(['error' => $errorMessage], 404);
        } catch (Exception $e) {
            DB::rollback();

            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
