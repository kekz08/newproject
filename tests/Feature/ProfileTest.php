<?php

use App\Models\User;

test('profile page is displayed', function () {
    $user = User::factory()->create();

    $response = $this
        ->actingAs($user)
        ->get("/{$user->username}");

    $response->assertOk();
});

test('profile information can be updated', function () {
    $user = User::factory()->create([
        'username' => 'testuser'
    ]);

    $response = $this
        ->actingAs($user)
        ->patch('/profile', [
            'username' => 'newusername',
            'gender' => 'male',
            'firstname' => 'John',
            'middlename' => 'Quincy',
            'lastname' => 'Doe',
            'address' => '123 Main St',
            'contact_number' => '1234567890',
            'email' => 'test@example.com',
        ]);

    $response
        ->assertSessionHasNoErrors()
        ->assertRedirect("/newusername");

    $user->refresh();

    $this->assertSame('newusername', $user->username);
    $this->assertSame('test@example.com', $user->email);
    $this->assertSame('John', $user->firstname);
    $this->assertSame('Doe', $user->lastname);
    $this->assertNull($user->email_verified_at);
});

test('email verification status is unchanged when the email address is unchanged', function () {
    $user = User::factory()->create([
        'username' => 'testuser'
    ]);

    $response = $this
        ->actingAs($user)
        ->patch('/profile', [
            'username' => $user->username,
            'gender' => $user->gender,
            'email' => $user->email,
        ]);

    $response
        ->assertSessionHasNoErrors()
        ->assertRedirect("/{$user->username}");

    $this->assertNotNull($user->refresh()->email_verified_at);
});

test('user can delete their account', function () {
    $user = User::factory()->create();

    $response = $this
        ->actingAs($user)
        ->delete('/profile', [
            'password' => 'password',
        ]);

    $response
        ->assertSessionHasNoErrors()
        ->assertRedirect('/');

    $this->assertGuest();
    $this->assertNull($user->fresh());
});

test('correct password must be provided to delete account', function () {
    $user = User::factory()->create();

    $response = $this
        ->actingAs($user)
        ->from("/{$user->username}")
        ->delete('/profile', [
            'password' => 'wrong-password',
        ]);

    $response
        ->assertSessionHasErrors('password')
        ->assertRedirect("/{$user->username}");

    $this->assertNotNull($user->fresh());
});
