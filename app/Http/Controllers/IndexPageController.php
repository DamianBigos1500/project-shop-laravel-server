<?php

namespace App\Http\Controllers;

use App\Models\Product;

class IndexPageController extends Controller
{
    public function index()
    {
        $products = Product::where("featured", 1)->with("images")->get()->random(8);

        return response()->json(['products' => $products]);
    }
}
