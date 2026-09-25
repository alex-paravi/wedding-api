<?php

namespace Tests\Feature;

use App\Models\Guest;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Str;
use Tests\TestCase;

class RsvpTest extends TestCase
{
    use RefreshDatabase;

    public function test_guest_can_confirm_rsvp_via_token(): void
    {
        $guest = Guest::factory()->create([
            'invitation_token' => Str::random(32),
            'status' => 'pending',
        ]);

        $response = $this->postJson("/api/invitations/{$guest->invitation_token}/rsvp", [
            'status' => 'confirmed',
            'dietary_preferences' => 'Без орехов',
        ]);

        $response->assertStatus(200);

        $this->assertDatabaseHas('guests', [
            'id' => $guest->id,
            'status' => 'confirmed',
            'dietary_preferences' => 'Без орехов',
        ]);
    }

    public function test_rsvp_with_invalid_token_returns_404(): void
    {
        $response = $this->postJson('/api/invitations/несуществующий-токен/rsvp', [
            'status' => 'confirmed',
        ]);

        $response->assertStatus(404);
    }
}
