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

describe('session hijacking protection', function () {
    it('signs a real login session out when the request fingerprint changes', function () {
        $user = User::factory()->admin()->create(['password' => 'correct-password']);

        $this->withServerVariables(['HTTP_USER_AGENT' => 'Original Browser'])
            ->post(route('admin.login.store'), ['email' => $user->email, 'password' => 'correct-password'])
            ->assertRedirect(route('admin.dashboard'));

        $this->assertAuthenticatedAs($user);

        // Same session cookie, a different User-Agent — the signature of a
        // stolen session cookie being replayed from another browser/device.
        $response = $this->withServerVariables(['HTTP_USER_AGENT' => 'Different Browser'])
            ->get(route('admin.dashboard'));

        $response->assertRedirect(route('admin.login'));
        $this->assertGuest();
    });

    it('keeps a real login session when only the IP address changes', function () {
        $user = User::factory()->admin()->create(['password' => 'correct-password']);

        $this->withServerVariables(['REMOTE_ADDR' => '10.0.0.1', 'HTTP_USER_AGENT' => 'Same Browser'])
            ->post(route('admin.login.store'), ['email' => $user->email, 'password' => 'correct-password']);

        $this->withServerVariables(['REMOTE_ADDR' => '10.0.0.2', 'HTTP_USER_AGENT' => 'Same Browser'])
            ->get(route('admin.dashboard'))
            ->assertOk();

        $this->assertAuthenticatedAs($user);
    });

    it('does not affect a session established via actingAs (no fingerprint set)', function () {
        // actingAs() bypasses the real login flow, so no auth_fingerprint
        // is ever stored — the middleware must not treat "no fingerprint
        // yet" the same as "fingerprint mismatch".
        $user = User::factory()->admin()->create();

        $this->actingAs($user)->get(route('admin.dashboard'))->assertOk();
    });
});

describe('idle timeout', function () {
    it('signs an admin out after more than five minutes without a request', function () {
        $user = User::factory()->admin()->create();

        $this->actingAs($user)->get(route('admin.dashboard'))->assertOk();

        $this->travel(6)->minutes();

        $this->get(route('admin.dashboard'))
            ->assertRedirect(route('admin.login'))
            ->assertSessionHasErrors('email');

        $this->assertGuest();
    });

    it('keeps an admin signed in while they stay active', function () {
        $user = User::factory()->admin()->create();

        $this->actingAs($user)->get(route('admin.dashboard'))->assertOk();

        $this->travel(4)->minutes();
        $this->get(route('admin.dashboard'))->assertOk();

        $this->travel(4)->minutes();
        $this->get(route('admin.dashboard'))->assertOk();

        $this->assertAuthenticatedAs($user);
    });
});
