<?php

use App\Models\User;
use App\Notifications\AdminResetPassword;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Password;

describe('forgot password', function () {
    it('renders the forgot-password form for guests', function () {
        $this->get(route('admin.password.request'))->assertOk();
    });

    it('sends a reset link notification for a real admin email', function () {
        Notification::fake();
        $user = User::factory()->admin()->create();

        $this->post(route('admin.password.email'), ['email' => $user->email])
            ->assertSessionHas('status');

        Notification::assertSentTo($user, AdminResetPassword::class);
    });

    it('shows the same generic response for an unknown email, without sending anything', function () {
        Notification::fake();

        $this->post(route('admin.password.email'), ['email' => 'nobody@example.com'])
            ->assertSessionHas('status');

        Notification::assertNothingSent();
    });
});

describe('reset password', function () {
    it('renders the reset form for a token', function () {
        $this->get(route('admin.password.reset', ['token' => 'some-token']))->assertOk();
    });

    it('resets the password with a valid token and redirects to login', function () {
        $user = User::factory()->admin()->create(['password' => 'old-password']);
        $token = Password::createToken($user);

        $response = $this->post(route('admin.password.update'), [
            'token' => $token,
            'email' => $user->email,
            'password' => 'brand-new-password',
            'password_confirmation' => 'brand-new-password',
        ]);

        $response->assertRedirect(route('admin.login'));

        $this->post(route('admin.login.store'), [
            'email' => $user->email,
            'password' => 'brand-new-password',
        ])->assertRedirect(route('admin.dashboard'));
    });

    it('rejects an invalid token', function () {
        $user = User::factory()->admin()->create(['password' => 'old-password']);

        $response = $this->post(route('admin.password.update'), [
            'token' => 'not-the-real-token',
            'email' => $user->email,
            'password' => 'brand-new-password',
            'password_confirmation' => 'brand-new-password',
        ]);

        $response->assertSessionHasErrors('email');

        $this->post(route('admin.login.store'), [
            'email' => $user->email,
            'password' => 'old-password',
        ])->assertRedirect(route('admin.dashboard'));
    });
});
