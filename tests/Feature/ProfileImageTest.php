<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class ProfileImageTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_upload_base64_avatar()
    {
        Storage::fake('local');

        $user = User::factory()->create();

        // Base64 encoded 1x1 white pixel PNG
        $base64Image = 'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAYAAAAfFcSJAAAADUlEQVR42mP8/5+hHgAHggJ/PchI7wAAAABJRU5ErkJggg==';

        $response = $this->actingAs($user)->postJson(route('profile.image.store', ['type' => 'avatar']), [
            'image' => $base64Image,
        ]);

        $response->assertStatus(200);
        $user->refresh();
        $this->assertNotNull($user->active_avatar);
        Storage::disk('local')->assertExists("uploads/{$user->id}/avatar/{$user->active_avatar}");
    }

    public function test_user_can_keep_multiple_avatars()
    {
        Storage::fake('local');
        $user = User::factory()->create();

        $base64Image = 'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAYAAAAfFcSJAAAADUlEQVR42mP8/5+hHgAHggJ/PchI7wAAAABJRU5ErkJggg==';

        // Upload first avatar
        $this->actingAs($user)->postJson(route('profile.image.store', ['type' => 'avatar']), ['image' => $base64Image]);
        $user->refresh();
        $firstAvatar = $user->active_avatar;

        // Sleep to ensure different timestamp if used
        sleep(1);

        // Upload second avatar
        $this->actingAs($user)->postJson(route('profile.image.store', ['type' => 'avatar']), ['image' => $base64Image]);
        $user->refresh();
        $secondAvatar = $user->active_avatar;

        $this->assertNotEquals($firstAvatar, $secondAvatar);
        Storage::disk('local')->assertExists("uploads/{$user->id}/avatar/{$firstAvatar}");
        Storage::disk('local')->assertExists("uploads/{$user->id}/avatar/{$secondAvatar}");
    }

    public function test_user_can_retrieve_avatar()
    {
        Storage::fake('local');

        $user = User::factory()->create();
        $fileName = 'avatar_12345.png';
        $user->update(['active_avatar' => $fileName]);

        $directory = "uploads/{$user->id}/avatar";
        $path = "{$directory}/{$fileName}";
        Storage::disk('local')->makeDirectory($directory);
        Storage::disk('local')->put($path, 'dummy content');

        $response = $this->actingAs($user)->get(route('profile.image.show', ['type' => 'avatar', 'userId' => $user->id]));

        $response->assertStatus(200);
    }

    public function test_non_existent_avatar_returns_default()
    {
        Storage::fake('local');

        $user = User::factory()->create();

        $response = $this->actingAs($user)->get(route('profile.image.show', ['type' => 'avatar', 'userId' => $user->id]));

        $response->assertStatus(200);
    }

    public function test_non_existent_cover_returns_default()
    {
        Storage::fake('local');

        $user = User::factory()->create();

        $response = $this->actingAs($user)->get(route('profile.image.show', ['type' => 'cover', 'userId' => $user->id]));

        $response->assertStatus(200);
    }

    public function test_private_images_cannot_be_accessed_by_others()
    {
        Storage::fake('local');

        $user = User::factory()->create();
        $otherUser = User::factory()->create();

        $directory = "uploads/{$user->id}/cover";
        $path = "{$directory}/cover.png";
        Storage::disk('local')->makeDirectory($directory);
        Storage::disk('local')->put($path, 'dummy content');

        // Other user tries to access cover
        // Note: Currently I commented out the 403 in the controller to not break things,
        // but let's see if I should enable it.
        // The requirement says "cannot be accessed or viewed by other users".

        // I will enable the 403 in the controller and then test it here.
        $response = $this->actingAs($otherUser)->get(route('profile.image.show', ['type' => 'cover', 'userId' => $user->id]));
        $response->assertStatus(403);
    }
    public function test_user_can_upload_base64_cover()
    {
        Storage::fake('local');

        $user = User::factory()->create();

        // Base64 encoded 1x1 white pixel PNG
        $base64Image = 'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAYAAAAfFcSJAAAADUlEQVR42mP8/5+hHgAHggJ/PchI7wAAAABJRU5ErkJggg==';

        $response = $this->actingAs($user)->postJson(route('profile.image.store', ['type' => 'cover']), [
            'image' => $base64Image,
        ]);

        $response->assertStatus(200);
        $user->refresh();
        $this->assertNotNull($user->active_cover);
        Storage::disk('local')->assertExists("uploads/{$user->id}/cover/{$user->active_cover}");
    }

    public function test_user_can_retrieve_cover()
    {
        Storage::fake('local');

        $user = User::factory()->create();
        $directory = "uploads/{$user->id}/cover";
        $path = "{$directory}/cover.png";
        Storage::disk('local')->makeDirectory($directory);
        Storage::disk('local')->put($path, 'dummy content');

        $response = $this->actingAs($user)->get(route('profile.image.show', ['type' => 'cover', 'userId' => $user->id]));

        $response->assertStatus(200);
    }

    public function test_upload_invalid_base64_returns_422()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->postJson(route('profile.image.store', ['type' => 'cover']), [
            'image' => 'not-a-base64-image',
        ]);

        $response->assertStatus(422);
        $response->assertJsonFragment(['message' => 'Did not match data URI with image data.']);
    }

    public function test_upload_webp_returns_200()
    {
        $user = User::factory()->create();
        $base64Image = 'data:image/webp;base64,UklGRhoAAABXRUJQVlA4TAYAAAAvAAAAAAfQAA7AAAAAAfQAA7AAAAAA';

        $response = $this->actingAs($user)->postJson(route('profile.image.store', ['type' => 'cover']), [
            'image' => $base64Image,
        ]);

        $response->assertStatus(200);
    }
}
