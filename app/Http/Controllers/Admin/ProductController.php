<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Http\Resources\ProductResource;
use App\Models\Product;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
    public function index()
    {
        $product = Product::searchQuery()
            ->sortingQuery()
            ->paginationQuery();

        DB::beginTransaction();
        try {
            $productResource = ProductResource::collection($product);

            DB::commit();

            return $this->success("Product List", $product);
        } catch (Exception $e) {
            DB::rollback();
            // throw $e;
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function store(StoreProductRequest $request)
    {
        $payload = collect($request->validated());

        DB::beginTransaction();
        try {
            $product = Product::create($payload->toArray());

            $product->categories()->attach($request->input('category_ids'));
            $product->tags()->attach($request->input('tags_ids'));

            DB::commit();

            return $this->success('Product created successfully', $product);
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
            $product = Product::findOrFail($id);

            $productResource = new ProductResource($product);

            DB::commit();

            return $this->success('Product Detail', $productResource);
        } catch (ModelNotFoundException $e) {
            DB::rollback();
            $errorMessage = 'Product not found';

            return response()->json(['error' => $errorMessage], 404);
        } catch (Exception $e) {
            DB::rollback();

            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function update(UpdateProductRequest $request, String $id)
    {
        $payload = collect($request->validated());
        DB::beginTransaction();
        try {
            $product = Product::findOrFail($id);

            $product->update($payload->toArray());
            $product->categories()->sync($request->input('category_ids'));
            $product->tags()->sync($request->input('tags_ids'));

            DB::commit();

            return $this->success('Product updated successfully', $product);
        } catch (ModelNotFoundException $e) {
            DB::rollback();
            $errorMessage = 'Product not found';

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

            $product = Product::findOrFail($id);

            $product->delete($id);
            DB::commit();

            return $this->success('Product deleted successfully', $product);
        } catch (ModelNotFoundException $e) {
            DB::rollback();
            $errorMessage = 'Product not found';

            return response()->json(['error' => $errorMessage], 404);
        } catch (Exception $e) {
            DB::rollback();

            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
