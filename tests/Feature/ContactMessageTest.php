<?php

namespace Tests\Feature;

use App\Models\ContactMessage;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ContactMessageTest extends TestCase
{
    use RefreshDatabase;

    public function test_invalid_contact_data_is_rejected_without_persistence(): void
    {
        $response = $this->post('/contact', [
            'name' => '',
            'email' => 'not-an-email',
            'message' => '',
        ]);

        $response->assertSessionHasErrors(['name', 'email', 'message']);
        $this->assertDatabaseCount('contact_messages', 0);
    }

    public function test_valid_contact_data_is_persisted_as_new(): void
    {
        $response = $this->post('/contact', [
            'name' => 'Avery Pilot',
            'email' => 'avery@example.com',
            'message' => 'Open a channel.',
        ]);

        $response->assertRedirect('/');
        $response->assertSessionHas('status');
        $this->assertDatabaseHas('contact_messages', [
            'email' => 'avery@example.com',
            'status' => 'new',
        ]);
    }

    public function test_contact_submissions_are_throttled(): void
    {
        $payload = [
            'name' => 'Avery Pilot',
            'email' => 'avery@example.com',
            'message' => 'Open a channel.',
        ];

        for ($attempt = 0; $attempt < 5; $attempt++) {
            $this->post('/contact', $payload);
        }

        $response = $this->post('/contact', $payload);

        $response->assertStatus(429);
        $this->assertSame(5, ContactMessage::count());
    }
}
