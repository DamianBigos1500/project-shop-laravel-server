<?php

namespace App\Http\Controllers;

use App\Models\FavouritCollection;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class FavouritController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index()
    {
        $collection = FavouritCollection::where("user_id", Auth::user()->id)->with('products.images')->orderBy('created_at', 'desc')->get();
        return response()->json(["favourit" => $collection]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return JsonResponse
     */
    public function store(Request $request)
    {
        $collection = FavouritCollection::create(["name" => $request->name, "user_id" => Auth::user()->id]);

        return response()->json(["favourit" => $collection]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return JsonResponse
     */
    public function update(Request $request, int $id)
    {
        $favourit = FavouritCollection::findOrFail($id);

        if ($favourit && Auth::user()->id == $favourit->user_id) {
            $favourit->update(["name" => $request->name]);
            return response()->json(["favourit" => "success"]);
        }
        return response()->json(["favourit" => $id], 403);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  FavouritCollection  $favouritCollection
     * @return JsonResponse
     */
    public function destroy(int $id)
    {
        $favourit = FavouritCollection::findOrFail($id);
        if ($favourit && Auth::user()->id == $favourit->user_id) {
            $favourit->delete();
            return response()->json(["favourit" => "success"]);
        }
        return response()->json(["favourit" => $id], 403);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function getUser(Request $request)
    {
        return $request->user();
    }
}
