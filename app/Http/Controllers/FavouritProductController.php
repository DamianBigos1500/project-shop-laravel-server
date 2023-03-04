<?php

namespace App\Http\Controllers;

use App\Models\FavouritCollection;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class FavouritProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return JsonResponse
     */
    public function store(Request $request): JsonResponse
    {
        $favouritCollection = FavouritCollection::where("id", $request->collection_id)->first();
        $product = Product::where("id", $request->product_id)->first();

        if ($favouritCollection->products->contains($product->id))
            return response()->json(["message" => "Product already in collection"], 200);

        $favouritCollection->products()->attach($product->id);

        return response()->json(["favouritCollection" => $favouritCollection, "product" => $product]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return JsonResponse
     */
    public function destroy(FavouritCollection $favouritCollection, Product $product)
    {
        if (!$favouritCollection->products->contains($product->id))
            return response()->json(["message" => "Collection don't contain product"], 200);

        $favouritCollection->products()->detach($product->id);

        return response()->json(["favouritCollection" => $favouritCollection, "product" => $product]);
    }
}
