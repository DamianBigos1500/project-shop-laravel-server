<?php

use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;

use function Termwind\render;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('public-files/{name1?}/{name2?}/{name3?}/{name4?}', function ($name1, $name2, $name3, $name4) {
    $filename = $name1 . '/' . $name2 . '/' . $name3 . '/' . $name4;
    // dd($filename);
    $imageData = file_get_contents($filename);

    // Encode image data to base64
    // $base64 = base64_encode($imageData);

    // echo '<img src="data:{$image_mime_type};base64,{$base64_data}">';
    return view('welcome');
});

Route::get('/', function () {
    $environment = env('SANCTUM_STATEFUL_DOMAINS');
    $environment2 = env('SESSION_DOMAIN');
    $files = Storage::allFiles("/images/imagesToSeed");

    return [
        'Laravel' => app()->version(),
        'env' => $environment,
        'env2' => $environment2,
        'storage' => $files,
        'url' => asset('/data')
    ];
});



require __DIR__ . '/auth.php';
require __DIR__ . '/api.php';
