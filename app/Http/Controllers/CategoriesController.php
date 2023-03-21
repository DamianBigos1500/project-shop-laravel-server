<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use  \Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;

class CategoriesController extends Controller
{
    /**
     * Display a listing of the resource.
     * 
     * @return JsonResponse
     */
    public function index()
    {
        $categories = Category::where("parent_id", 0)->with("children")->get();
        // $categories = DB::table("categories")->join("")->where("parent_id", 0)->get(["id", "title", "category_slug"]);

        return response()->json([
            'categories' => $categories
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
     * @param  string  $slug
     * @return JsonResponse
     */
    public function getCategoryBySlug(string $slug)
    {
        return response()->json([
            "category" => Category::where("category_slug", $slug)->with("children.categoryImage")->first()
        ]);
    }

}
