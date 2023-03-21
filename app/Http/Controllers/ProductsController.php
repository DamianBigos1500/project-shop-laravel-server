<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\JsonResponse;

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
            'products' => Product::with(["images", "ratings"])->paginate(20),
        ], 200);
    }

    // /**
    //  * Display a listing of paths.
    //  *
    //  * @return JsonResponse
    //  */
    // public function getProductPaths(): JsonResponse
    // {
    //     return response()->json([
    //         'productsPaths' => Product::select("id")->get()->map(fn ($prod) => ["params" => ["id" => strval($prod->id)]]),
    //     ], 200);
    // }

    /**
     * Display the specified resource.
     *
     * @param  Product $product
     * @return JsonResponse
     */
    public function show(Product $product): JsonResponse
    {
        return response()->json([
            'product' => Product::with(["images", "category" => ['parent']])->find($product->id)
        ], 200);
    }

    /**
     * Custom Routes functions
     * 
     */

    /**
     * Get products by category id
     * @param  string $slug
     * @return JsonResponse
     */
    public function getProductsByCategory(string $slug)
    {
        $category = Category::where('category_slug', $slug)->with("parent")->firstOrFail();
        $products = Product::where("category_id", $category->id)->with(["images", "ratings"])->paginate(18);

        return response()->json([
            "products" =>  $products,
            "category" =>  $category
        ]);
    }

    /**
     * Get products by category id
     * @return JsonResponse
     */
    public function getSearchedProducts()
    {
        $products = Product::query()->with(["images"])->when(request('search'), function ($query) {
            $query->where('name', "LIKE", '%' . request('search') . '%')
                ->orWhere('slug', "LIKE", '%' . request('search') . '%')
                ->orWhere('short_description', "LIKE", '%' . request('search') . '%')
                ->orWhere('long_description', "LIKE", '%' . request('search') . '%');
        })->orWhereHas('category', function ($query) {
            $query
                ->where('title', "LIKE", '%' . request('search') . '%')
                ->orWhere('category_slug', "LIKE", '%' . request('search') . '%');
        })->orWhereHas('category.parent', function ($query) {
            $query->where('title', "LIKE", '%' . request('search') . '%')
                ->orWhere('category_slug', "LIKE", '%' . request('search') . '%');
        })->take(20)->get([
            "id", "category_id", "name", "slug", "product_code", "short_description",
            "long_description", "regular_price", "discount_price", "is_available", "quantity", "featured"
        ]);

        return response()->json([
            "products" => $products,
            "productsCount" => $products->count(),
        ]);
    }
}
