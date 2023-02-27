<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use  \Illuminate\Http\JsonResponse;

class CategoriesController extends Controller
{
    /**
     * Display a listing of the resource.
     * 
     * @return JsonResponse
     */
    public function index()
    {
        return response()->json([
            'categories' => Category::where("parent_id", 0)->with("children")->get()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return JsonResponse
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'title' => 'required',
        ]);

        $input = $request->all();
        $input['parent_id'] = empty($input['parent_id']) ? 0 : $input['parent_id'];

        Category::create($input);

        return response()->json(['success', 'New Category added successfully.']);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return JsonResponse
     */
    public function show($id)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  string  $slug
     * @return JsonResponse
     */
    public function getCategoryBySlug(string $slug)
    {
        return response()->json([
            "category" => Category::where("category_slug", $slug)->with("children.categoryImage")->first()
        ]);
    }

    /**
     * Get products by category id
     *
     * @param  string $slug
     * @return JsonResponse
     */
    public function getProductsByCategory(string $slug)
    {
        $category = Category::where('category_slug', $slug)->with("parent")->firstOrFail();
        $products = Product::where("category_id", $category->id)->with("images")->paginate(18);

        return response()->json([
            "products" =>  $products,
            "category" =>  $category
        ]);
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
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
