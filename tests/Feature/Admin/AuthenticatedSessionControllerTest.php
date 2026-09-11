<?php

use App\Models\User;

describe('login', function () {
    it('renders the login form for guests', function () {
        $this->get(route('admin.login'))->assertOk();
    });

    it('logs in an admin user and redirects to the dashboard', function () {
        $user = User::factory()->admin()->create(['password' => 'correct-password']);

        $response = $this->post(route('admin.login.store'), [
            'email' => $user->email,
            'password' => 'correct-password',
        ]);

        $response->assertRedirect(route('admin.dashboard'));
        $this->assertAuthenticatedAs($user);
    });

    it('rejects an incorrect password', function () {
        $user = User::factory()->admin()->create(['password' => 'correct-password']);

        $response = $this->post(route('admin.login.store'), [
            'email' => $user->email,
            'password' => 'wrong-password',
        ]);

        $response->assertSessionHasErrors('email');
        $this->assertGuest();
    });

    it('rejects a non-admin user even with correct credentials', function () {
        $user = User::factory()->create(['password' => 'correct-password', 'is_admin' => false]);

        $response = $this->post(route('admin.login.store'), [
            'email' => $user->email,
            'password' => 'correct-password',
        ]);

        $response->assertSessionHasErrors('email');
        $this->assertGuest();
    });
});

describe('access control', function () {
    it('redirects guests away from the dashboard to the login page', function () {
        $this->get(route('admin.dashboard'))->assertRedirect(route('admin.login'));
    });

    it('forbids a signed-in non-admin user from the dashboard', function () {
        $user = User::factory()->create(['is_admin' => false]);

        $this->actingAs($user)->get(route('admin.dashboard'))->assertForbidden();
    });

    it('allows an admin user to view the dashboard', function () {
        $user = User::factory()->admin()->create();

        $this->actingAs($user)->get(route('admin.dashboard'))->assertOk();
    });
});

it('logs out an authenticated admin', function () {
    $user = User::factory()->admin()->create();

    $response = $this->actingAs($user)->post(route('admin.logout'));

    $response->assertRedirect(route('admin.login'));
    $this->assertGuest();
});
