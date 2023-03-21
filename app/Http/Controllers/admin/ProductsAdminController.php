<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\admin\StoreImageAdminRequest;
use App\Http\Requests\admin\StoreProductAdminRequest;
use App\Http\Requests\admin\UpdateProductAdminRequest;
use App\Http\Requests\UpsertProductRequest;
use App\Models\Image;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Storage;
use Exception;
use Illuminate\Support\Str;

class ProductsAdminController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        $products = Product::with(['images', 'category'])->get();

        return response()->json([
            "products" => $products,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  StoreProductAdminRequest  $request
     * @return JsonResponse
     */
    public function store(StoreProductAdminRequest $request): JsonResponse
    {
        $validated = $request->validated();

        $product = Product::create([
            "name" => $validated['name'],
            "category_id" => $validated['category_id'],
            "slug" => Str::slug($validated['name']),
            "product_code" => $validated['product_code'],
            "short_description" => $validated['short_description'],
            "long_description" => $validated['long_description'],
            "regular_price" => $validated['regular_price'],
            "discount_price" => $validated['discount_price'],
            "is_available" => 1,
            "quantity" => $validated['quantity'],
        ]);

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $imagePath = $image->store('images/products');
                $img = new Image(["filename" =>  "/storage/" . $imagePath]);
                $product->images()->save($img);
            }
        }


        return response()->json([
            "product" => $product,
            "category" => $request->category_id
        ], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return JsonResponse
     */
    public function show(int $id)
    {
        $product = Product::where('id', $id)->with(['images', 'category'])->first();

        return response()->json([
            "product" => $product,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  UpdateProductAdminRequest  $request
     * @param  Product  $id
     * @return JsonResponse
     */
    public function update(UpdateProductAdminRequest $request, Product $product): JsonResponse
    {
        $validated = $request->validated();

        $product->update([
            "name" => $validated['name'],
            "category_id" => $validated['category_id'],
            "slug" => Str::slug($validated['name']),
            "product_code" => $validated['product_code'],
            "short_description" => $validated['short_description'],
            "long_description" => $validated['long_description'],
            "regular_price" => $validated['regular_price'],
            "discount_price" => $validated['discount_price'],
            "is_available" => 1,
            "quantity" => $validated['quantity'],
        ]);


        return response()->json([
            "product" => $product,
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Product  $product
     * @return JsonResponse
     */

    public function destroy(Product $product): JsonResponse
    {
        try {
            $images = $product->images;

            foreach ($images as $image) {
                Storage::delete($image->filename);
            }
            $product->delete();

            return response()->json([
                'product' => $product
            ], 202);
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Cannot remove product!',
            ], 500);
        }
    }

    /**
     * Get all images of the product.
     *
     * @return JsonResponse
     */

}
