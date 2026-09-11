<?php

namespace Database\Seeders;

use App\Models\GalleryImage;
use Illuminate\Database\Seeder;

class GalleryImageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        GalleryImage::factory(12)->sequence(
            fn ($sequence) => ['order' => $sequence->index],
        )->create();
    }
}
