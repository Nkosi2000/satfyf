<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            AdminUserSeeder::class,
            SiteSettingSeeder::class,
            TeamMemberSeeder::class,
            ProgramSeeder::class,
            ArticleSeeder::class,
            EventItemSeeder::class,
            ResourceSeeder::class,
            GalleryImageSeeder::class,
            PartnerSeeder::class,
            FaqItemSeeder::class,
        ]);
    }
}
