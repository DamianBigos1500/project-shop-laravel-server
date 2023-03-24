<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;

class ProductsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */

    public function index(): JsonResponse
    {
        $max_price = Product::max('regular_price');

        $productsQuery = Product::searchQuery()->when(request('sub_category'), function ($query) {
            $query->where('category_id', request('sub_category'));
        })->when(request('category'), function ($query) {
            $query->whereHas('category', function ($query) {
                $query->where('parent_id', request('category'));
            });
        })->when(request('price_from') || request('price_to'), function ($query) use ($max_price) {
            $query->whereBetween('regular_price', [request('price_from') ?? 0, request('price_to') ?? $max_price])
                ->orWhereBetween('discount_price', [request('price_from') ?? 0, request('price_to') ?? $max_price]);
        })->when(request('order_by'), function ($query) {
            if (in_array(request('order_by'), DB::getSchemaBuilder()->getColumnListing('products')))
                $query->orderBy(request('order_by'), request('order_method') ?? 'asc');
        });


        return response()->json([
            'productsCount' => $productsQuery->count(),
            'products' => $productsQuery->with(["images", "ratings"])->paginate(18),
        ], 200);
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
            'productName' => $product->getName(),
            'product' => Product::with(["images", "category" => ['parent']])->find($product->id),
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
        $products = Product::searchQuery()->with(["images"])->take(20)->get([
            "id", "category_id", "name", "slug", "product_code", "short_description",
            "long_description", "regular_price", "discount_price", "is_available", "quantity", "featured"
        ]);

        return response()->json([
            "products" => $products,
            "productsCount" => $products->count(),
        ]);
    }
}
