<?php

use App\Models\ContactSubmission;

it('stores a valid contact submission and redirects back with a success message', function () {
    $response = $this->from('/contact')->post('/contact', [
        'name' => 'Jane Learner',
        'email' => 'jane@example.com',
        'phone' => '0821234567',
        'subject' => 'Volunteering',
        'message' => 'I would like to help run a Think Session at my school.',
    ]);

    $response->assertRedirect('/contact');
    $response->assertSessionHas('contact_success');

    expect(ContactSubmission::query()->where('email', 'jane@example.com')->exists())->toBeTrue();
});

it('rejects a submission with an empty payload', function () {
    $response = $this->from('/contact')->post('/contact', []);

    $response->assertRedirect('/contact');
    $response->assertSessionHasErrors(['name', 'email', 'message']);
    expect(ContactSubmission::query()->count())->toBe(0);
});

it('rejects a submission with an invalid email', function () {
    $response = $this->from('/contact')->post('/contact', [
        'name' => 'Jane Learner',
        'email' => 'not-an-email',
        'message' => 'Hello there.',
    ]);

    $response->assertSessionHasErrors('email');
});
