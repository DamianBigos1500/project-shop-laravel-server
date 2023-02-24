<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpsertProductRequest;
use App\Models\Category;
use App\Models\Product;
use App\Models\Image;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */

    public function index(): JsonResponse
    {
        return response()->json([
            'products' => Product::with("images")->paginate(10),
        ], 200);
    }

    /**
     * Display a listing of paths.
     *
     * @return JsonResponse
     */
    public function getProductPaths(): JsonResponse
    {
        return response()->json([
            'productsPaths' => Product::select("id")->get()->map(fn ($prod) => ["params" => ["id" => strval($prod->id)]]),
        ], 200);
    }

    /**
     * Display a listing of paths.
     *
     * @return JsonResponse
     */
    public function create(): JsonResponse
    {


        return response()->json([
            'categories' => Category::all()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request  $request
     * @return JsonResponse
     */
    public function store(UpsertProductRequest $request): JsonResponse
    {
        $product = Product::create([
            "name" => $request->name,
            "details" => $request->details,
        ]);

        if ($request->hasFile('images')) {
            foreach ($request->images as $image) {
                $imagePath = $image->store('images/products');
                Image::create(["filename" => $imagePath, 'product_id' => $product->id]);
            }
        }

        return response()->json([
            "product" => $product,
        ], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  Product $product
     * @return JsonResponse
     */
    public function show(Product $product): JsonResponse
    {
        return response()->json([
            'product' => Product::with("images")->find($product->id)
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Request  $request
     * @param  Product  $product
     * @return JsonResponse
     */
    public function update(Request $request, Product  $product): JsonResponse
    {
        return response()->json([
            'product' => $product
        ], 200);
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
}
