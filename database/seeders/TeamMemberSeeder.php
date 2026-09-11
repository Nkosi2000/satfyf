<?php

namespace Database\Seeders;

use App\Models\TeamMember;
use Illuminate\Database\Seeder;

class TeamMemberSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $members = [
            ['name' => 'Thandeka Mokoena', 'role' => 'National Coordinator', 'bio' => 'Leads SATFYF\'s national strategy and represents the forum in policy engagements across South Africa.'],
            ['name' => 'Lwazi Dlamini', 'role' => 'Youth Advocacy Lead', 'bio' => 'Trains and mobilises youth ambassadors to run tobacco-free campaigns in their own communities.'],
            ['name' => 'Naledi Khumalo', 'role' => 'Communications Officer', 'bio' => 'Runs SATFYF\'s media advocacy, social campaigns and public messaging.'],
            ['name' => 'Sipho Nkosi', 'role' => 'Research & Policy Officer', 'bio' => 'Tracks tobacco control policy and translates evidence into plain-language resources.'],
            ['name' => 'Amahle Zulu', 'role' => 'Community Liaison', 'bio' => 'Coordinates Community Imbizos and grassroots outreach with schools and youth groups.'],
            ['name' => 'Kagiso Molefe', 'role' => 'Volunteer Manager', 'bio' => 'Recruits and supports the volunteers who power SATFYF\'s events and demonstrations.'],
        ];

        foreach ($members as $order => $member) {
            TeamMember::query()->updateOrCreate(
                ['name' => $member['name']],
                [...$member, 'order' => $order, 'published' => true],
            );
        }
    }
}
