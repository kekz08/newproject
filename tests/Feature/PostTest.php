<?php

namespace Tests\Feature;

use App\Models\Post;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class PostTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_create_post_with_text()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->postJson(route('posts.store'), [
            'text' => 'Hello world!',
            'audience' => 'public',
        ]);

        $response->assertStatus(200);
        $this->assertDatabaseHas('posts', [
            'user_id' => $user->id,
            'text' => 'Hello world!',
        ]);
    }

    public function test_user_can_create_post_with_base64_image()
    {
        Storage::fake('local');
        $user = User::factory()->create();

        // Base64 encoded 1x1 white pixel PNG
        $base64Image = 'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAYAAAAfFcSJAAAADUlEQVR42mP8/5+hHgAHggJ/PchI7wAAAABJRU5ErkJggg==';

        $response = $this->actingAs($user)->postJson(route('posts.store'), [
            'text' => 'Post with image',
            'image' => $base64Image,
            'audience' => 'public',
        ]);

        $response->assertStatus(200);
        $post = Post::first();
        $this->assertNotNull($post->image);
        Storage::disk('local')->assertExists("uploads/{$user->id}/post/{$post->image}");
    }

    public function test_guest_cannot_create_post()
    {
        $response = $this->postJson(route('posts.store'), [
            'text' => 'Should fail',
            'audience' => 'public',
        ]);

        $response->assertStatus(401);
    }

    public function test_can_fetch_public_posts()
    {
        $user = User::factory()->create();
        Post::factory()->count(5)->create([
            'user_id' => $user->id,
            'audience' => 'public',
        ]);

        $response = $this->actingAs($user)->getJson(route('posts.index'));

        $response->assertStatus(200);
        $response->assertJsonCount(5, 'data');
        $response->assertJsonStructure([
            'data' => [
                '*' => [
                    'likes_count',
                    'comments_count',
                    'liked_by_user',
                ]
            ]
        ]);
    }

    public function test_user_can_toggle_like()
    {
        $user = User::factory()->create();
        $post = Post::factory()->create(['user_id' => $user->id]);

        // Like
        $response = $this->actingAs($user)->postJson(route('posts.like', $post));
        $response->assertStatus(200);
        $response->assertJson(['liked' => true, 'likes_count' => 1]);
        $this->assertDatabaseHas('post_likes', ['user_id' => $user->id, 'post_id' => $post->id]);

        // Unlike
        $response = $this->actingAs($user)->postJson(route('posts.like', $post));
        $response->assertStatus(200);
        $response->assertJson(['liked' => false, 'likes_count' => 0]);
        $this->assertDatabaseMissing('post_likes', ['user_id' => $user->id, 'post_id' => $post->id]);
    }

    public function test_user_can_comment_on_post()
    {
        $user = User::factory()->create();
        $post = Post::factory()->create(['user_id' => $user->id]);

        $response = $this->actingAs($user)->postJson(route('comments.store', $post), [
            'comment' => 'This is a test comment',
        ]);

        $response->assertStatus(200);
        $this->assertDatabaseHas('post_comments', [
            'user_id' => $user->id,
            'post_id' => $post->id,
            'comment' => 'This is a test comment',
        ]);
    }

    public function test_can_fetch_comments()
    {
        $user = User::factory()->create();
        $post = Post::factory()->create(['user_id' => $user->id]);
        \App\Models\PostComment::create([
            'user_id' => $user->id,
            'post_id' => $post->id,
            'comment' => 'Test comment',
        ]);

        $response = $this->actingAs($user)->getJson(route('comments.index', $post));

        $response->assertStatus(200);
        $response->assertJsonCount(1);
    }
}
