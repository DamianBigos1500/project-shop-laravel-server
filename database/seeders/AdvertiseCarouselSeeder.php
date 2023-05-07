<?php

namespace Database\Seeders;

use App\Models\AdvertiseCarousel;
use App\Models\Image;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;

class AdvertiseCarouselSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        AdvertiseCarousel::create([
            'name' => 'Advertisement 1',
            'product_id' => 25,
        ]);

        AdvertiseCarousel::create([
            'name' => 'Advertisement 2',
            'product_id' => 58,
        ]);

        $allAdvertisements = AdvertiseCarousel::all();
        $files = Storage::allFiles("/images/advertiseCarousel");

        foreach ($allAdvertisements as $key => $advertise) {
            $img = new Image(["filename" =>  "/storage/" . $files[$key]]);
            $advertise->images()->save($img);
        }
    }
}
