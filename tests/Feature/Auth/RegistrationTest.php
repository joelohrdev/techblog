<?php

declare(strict_types=1);

test('registration screen can be rendered', function () {
    $response = $this->get(route('register'));

    $response->assertStatus(200);
});

test('new users can register', function () {
    $response = $this->post(route('register.store'), [
        'name' => 'John Doe',
        'email' => 'test@example.com',
        'password' => 'password',
        'password_confirmation' => 'password',
    ]);

    $response->assertSessionHasNoErrors()
        ->assertRedirect(route('dashboard', absolute: false));

    $this->assertAuthenticated();
});

test('registration screen cannot be rendered after first user is created', function () {
    App\Models\User::factory()->create();

    $response = $this->get(route('register'));

    $response->assertForbidden();
});

test('registration is disabled after first user is created', function () {
    App\Models\User::factory()->create();

    $response = $this->post(route('register.store'), [
        'name' => 'John Doe',
        'email' => 'newuser@example.com',
        'password' => 'password',
        'password_confirmation' => 'password',
    ]);

    $response->assertForbidden();

    expect(App\Models\User::query()->where('email', 'newuser@example.com')->exists())->toBeFalse();
});
