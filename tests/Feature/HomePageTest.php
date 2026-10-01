<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class HomePageTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed();
    }

    public function test_the_homepage_renders_the_northstar_inertia_page(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
        $response->assertInertia(fn ($page) => $page
            ->component('Home')
            ->where('siteSettings.site_name', 'Northstar')
            ->where('siteSettings.hero_title', 'Beyond the horizon.'));
    }

    public function test_the_homepage_exposes_contact_success_status(): void
    {
        $response = $this->withSession(['status' => 'Message received.'])->get('/');

        $response->assertInertia(fn ($page) => $page->where('status', 'Message received.'));
    }
}
