<?php

namespace App\Http\Controllers;

use App\Models\Rating;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class RatingsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        return response()->json(["ratings" => []]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return  JsonResponse
     */
    public function store(Request $request): JsonResponse
    {
        $newRating = Rating::create([
            "product_id" => $request->product_id,
            "user_id" =>  Auth::user()->id,
            "review" =>   $request->review,
            "rating" =>  $request->rating,
            "status" => 0
        ]);

        return response()->json(["rating" => $newRating]);
    }





    /**
     * Display the specified ratings depends on ProductId.
     *
     * @param  int  $id
     * @return JsonResponse
     */
    public function show(Request $request, int $id): JsonResponse
    {

        $sort = $request->query("sort") ?? 0;
        $rating = $request->query("rating") ?? 0;
        $confirmed = $request->query("confirmed") ?? 0;

        $ratings = Rating::query()->where("product_id", $id);

        if ($rating) {
            $ratings->where([["rating", ">=", $rating * 2], ["rating", "<=", $rating * 2 + 1]]);
        }

        if ($confirmed) {
            if (+$confirmed == 1)
                $ratings = $ratings->where("status", "=", 1);
        }

        if ($sort == 0) {
            $ratings = $ratings->orderBy('created_at', 'desc');
        }
        if ($sort == 1)
            $ratings = $ratings->orderBy('rating', 'desc');
        else
            $ratings = $ratings->orderBy('created_at', 'asc');

        $ratings = $ratings->with("user")->get();

        return response()->json([
            "ratings" => $ratings,
            "sort" => $sort,
            "rating" => $rating,
            "confirmed" => $confirmed
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return JsonResponse
     */
    public function update(Request $request, $id): JsonResponse
    {
        return response()->json(["ratings" => []]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return JsonResponse
     */
    public function destroy($id): JsonResponse
    {
        return response()->json(["ratings" => []]);
    }
}
