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

it('rejects a disposable email domain', function () {
    $response = $this->from('/contact')->post('/contact', [
        'name' => 'Jane Learner',
        'email' => 'jane@guerrillamail.com',
        'message' => 'Hello there.',
    ]);

    $response->assertSessionHasErrors('email');
    expect(ContactSubmission::query()->count())->toBe(0);
});

it('strips HTML tags out of the name, subject and message before storing', function () {
    $this->from('/contact')->post('/contact', [
        'name' => '<b>Jane</b> Learner',
        'email' => 'jane@example.com',
        'subject' => '<script>alert(1)</script>Volunteering',
        'message' => 'I would like to <i>help</i> run a Think Session.',
    ]);

    $submission = ContactSubmission::query()->where('email', 'jane@example.com')->first();

    expect($submission->name)->toBe('Jane Learner')
        ->and($submission->subject)->toBe('alert(1)Volunteering')
        ->and($submission->message)->toBe('I would like to help run a Think Session.');
});
