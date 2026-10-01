<?php

namespace Tests\Feature;

use App\Models\ContactMessage;
use App\Models\SiteSetting;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SiteContentTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed();
    }

    public function test_it_stores_the_seeded_homepage_settings(): void
    {
        $settings = SiteSetting::query()->first();

        $this->assertNotNull($settings);
        $this->assertSame('Northstar', $settings->site_name);
        $this->assertSame('Beyond the horizon.', $settings->hero_title);
    }

    public function test_it_stores_a_new_contact_message_with_the_new_status(): void
    {
        $message = ContactMessage::create([
            'name' => 'Avery Pilot',
            'email' => 'avery@example.com',
            'message' => 'Open a channel.',
        ]);

        $this->assertSame('new', $message->fresh()->status);
    }
}
