<?php

use App\Models\User;
use Illuminate\Support\Facades\Hash;

it('lets an admin change their own password', function () {
    $user = User::factory()->admin()->create(['password' => 'old-password']);

    $response = $this->actingAs($user)->put(route('admin.account.password.update'), [
        'current_password' => 'old-password',
        'password' => 'brand-new-password',
        'password_confirmation' => 'brand-new-password',
    ]);

    $response->assertRedirect(route('admin.account.edit'));
    expect(Hash::check('brand-new-password', $user->refresh()->password))->toBeTrue();
});

it('rejects the wrong current password', function () {
    $user = User::factory()->admin()->create(['password' => 'old-password']);

    $response = $this->actingAs($user)->put(route('admin.account.password.update'), [
        'current_password' => 'wrong-password',
        'password' => 'brand-new-password',
        'password_confirmation' => 'brand-new-password',
    ]);

    $response->assertSessionHasErrors('current_password');
    expect(Hash::check('old-password', $user->refresh()->password))->toBeTrue();
});

it('redirects guests away from the account page', function () {
    $this->get(route('admin.account.edit'))->assertRedirect(route('admin.login'));
});
