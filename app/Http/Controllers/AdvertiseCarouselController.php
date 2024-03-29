<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Models\AdvertiseCarousel;

class AdvertiseCarouselController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index()
    {
        $advertiseCarousel = AdvertiseCarousel::with('images')->get();

        return response()->json([
            "advertisment" => $advertiseCarousel,
        ]);
    }
}
