<?php

use App\Models\NewsletterSubscriber;

it('subscribes a new email and redirects back with a success message', function () {
    $response = $this->from('/')->post('/newsletter', ['email' => 'reader@example.com']);

    $response->assertRedirect('/');
    $response->assertSessionHas('newsletter_success');

    expect(NewsletterSubscriber::query()->where('email', 'reader@example.com')->exists())->toBeTrue();
});

it('rejects a duplicate email', function () {
    NewsletterSubscriber::factory()->create(['email' => 'reader@example.com']);

    $response = $this->from('/')->post('/newsletter', ['email' => 'reader@example.com']);

    $response->assertSessionHasErrors('email');
    expect(NewsletterSubscriber::query()->where('email', 'reader@example.com')->count())->toBe(1);
});

it('rejects an invalid email', function () {
    $response = $this->from('/')->post('/newsletter', ['email' => 'not-an-email']);

    $response->assertSessionHasErrors('email');
});

it('rejects a disposable email domain', function () {
    $response = $this->from('/')->post('/newsletter', ['email' => 'reader@mailinator.com']);

    $response->assertSessionHasErrors('email');
    expect(NewsletterSubscriber::query()->where('email', 'reader@mailinator.com')->exists())->toBeFalse();
});
