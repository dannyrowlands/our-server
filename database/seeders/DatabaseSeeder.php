<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\SiteSetting;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);

        SiteSetting::create([
            'site_name' => 'Northstar',
            'tagline' => 'Beyond the horizon',
            'hero_eyebrow' => 'Northstar flight operations',
            'hero_title' => 'Beyond the horizon.',
            'hero_copy' => 'A forward-looking space for bold ideas, long-range journeys, and the people building what comes next.',
            'altitude_label' => 'Altitude',
            'altitude_value' => '082,400 FT',
            'velocity_label' => 'Velocity',
            'velocity_value' => 'MACH 2.17',
            'heading_label' => 'Heading',
            'heading_value' => '047° N / 118° E',
            'primary_cta_label' => 'Begin sequence',
            'primary_cta_url' => '#mission',
            'secondary_cta_label' => 'View flight systems',
            'secondary_cta_anchor' => '#systems',
            'footer_text' => 'Northstar flight operations · Keep looking up.',
        ]);
    }
}
