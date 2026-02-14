<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Illuminate\Support\Facades\Cache;

class OnlineUserTest extends TestCase
{
    use RefreshDatabase;

    public function test_online_users_endpoint_returns_success()
    {
        Cache::forget('online_users');

        User::factory()->create([
            'last_seen_at' => now(),
        ]);

        $response = $this->getJson(route('online.users'));

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'online_users',
            'total_online'
        ]);
        $this->assertCount(1, $response->json('online_users'));
    }

    public function test_online_users_are_cached()
    {
        Cache::forget('online_users');

        User::factory()->create([
            'last_seen_at' => now()
        ]);

        // First call should populate cache
        $this->getJson(route('online.users'));
        $this->assertTrue(Cache::has('online_users'));

        // Add another user
        User::factory()->create([
            'last_seen_at' => now()
        ]);

        // Second call should still return 1 user from cache
        $response = $this->getJson(route('online.users'));
        $this->assertCount(1, $response->json('online_users'));
    }

    public function test_global_response_cache_middleware()
    {
        $user = User::factory()->create();

        // First request - should be a MISS
        // Using dashboard as / is guest only
        $response1 = $this->actingAs($user)->get('/dashboard');
        $response1->assertStatus(200);
        $response1->assertHeaderMissing('X-Cache');

        // Second request - should be a HIT
        $response2 = $this->actingAs($user)->get('/dashboard');
        $response2->assertStatus(200);
        $response2->assertHeader('X-Cache', 'HIT');
    }
}
