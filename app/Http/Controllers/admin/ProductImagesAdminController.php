<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\admin\StoreImageAdminRequest;
use App\Models\Image;
use App\Models\Product;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductImagesAdminController extends Controller
{
    /**
     * Get all images of the product.
     *
     * @return JsonResponse
     */

    public function index(): JsonResponse
    {
        $product = Product::find(request('productId'));

        return response()->json([
            "images" => $product->images,
        ], 200);
    }


    public function store(StoreImageAdminRequest $request): JsonResponse
    {
        $product = Product::find($request->product_id);

        if ($request->hasFile('image')) {
            $imagePath = $request->image->store('images/products');
            $img = new Image(["filename" =>  "/storage/" . $imagePath]);
            $product->images()->save($img);
        }


        return response()->json([
            "image" => $img,
        ], 201);
    }

    /**
     * Get all images of the product.
     * 
     * @param Image $image
     * @return JsonResponse
     */
    public function destroy(int $id): JsonResponse
    {
        $image = Image::find($id);
        Storage::delete($image->filename);
        $image->delete();

        return response()->json([
            "image" => $image,
        ], 200);
    }
}
