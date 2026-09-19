<?php

it('shows the cookie banner when no consent cookie is set', function () {
    $this->get('/')->assertSee(__('Got it'));
});

it('hides the cookie banner once the consent cookie is set', function () {
    $this->withCookie('cookie_consent', 'accepted')
        ->get('/')
        ->assertDontSee(__('Got it'));
});

it('sets the consent cookie and redirects back', function () {
    $response = $this->from('/who-we-are')->post('/cookie-consent');

    $response->assertRedirect('/who-we-are');
    $response->assertCookie('cookie_consent', 'accepted');
});
