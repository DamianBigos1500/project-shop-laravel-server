<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class IndexController extends Controller
{
    public function index()
    {
        $products = Product::where("featured", 1)->with("images")->get()->random(8);

        return response()->json(['products' => $products]);
    }
}
