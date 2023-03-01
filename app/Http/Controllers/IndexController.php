<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class IndexController extends Controller
{
    public function getStrage()
    {
        // $products = Product::all();
        $files = Storage::allFiles("/images/imagesToSeed");

        // foreach ($products as $product) {

        //     for ($i = 0; $i < rand(1, 16); $i++) {
        //         $img = new Image(["filename" =>  "/storage/" . $files[rand(0, count($files) - 1)]]);
        //         $product->images()->save($img);
        //     }
        // }
        return ["sdasd" => $files[rand(0, count($files) - 1)]];
    }
}
