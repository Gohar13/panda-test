<?php
namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class SubscribeToPriceChangeTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function user_can_subscribe_to_listing()
    {
        $data = [
            'email' => 'user@example.com',
            'url' => 'https://www.olx.ua/d/uk/obyavlenie/novinka-turetska-plitonoska-rozgruzka-sword-na-4-tochki-plitonoska-IDUqjf0.html',
        ];

        $response = $this->postJson('/api/subscribe-to-price-change', $data);

        $this->assertDatabaseHas('listing_subscriptions', [
            'email' => 'user@example.com',
            'url' => 'https://www.olx.ua/d/uk/obyavlenie/novinka-turetska-plitonoska-rozgruzka-sword-na-4-tochki-plitonoska-IDUqjf0.html',
        ]);

        $response->assertStatus(200)
            ->assertJson([
                'status' => true,
                'message' => 'Subscription successfully created',
            ]);
    }

    /** @test */
    public function invalid_data_to_subscribe()
    {
        $response = $this->postJson('/api/subscribe-to-price-change', [
            'email' => 'invalid-email',
            'url' => 'invalid-url',
        ]);

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['email', 'url']);
    }
}
