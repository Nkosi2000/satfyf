<?php

use App\Models\ChatConversation;
use App\Models\ChatMessage;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

function fakeAnthropicReply(string $text = 'Here is a helpful reply.'): void
{
    Http::fake([
        'api.anthropic.com/*' => Http::response([
            'content' => [['type' => 'text', 'text' => $text]],
        ], 200),
    ]);
}

beforeEach(function () {
    config(['services.anthropic.api_key' => 'test-key']);
});

describe('store', function () {
    it('creates a conversation and both messages, returning the reply', function () {
        fakeAnthropicReply('Welcome to SATFYF!');

        $response = $this->postJson(route('chat.messages.store'), ['message' => 'What is SATFYF?']);

        $response->assertOk();
        $response->assertJsonStructure(['conversation_id', 'reply']);
        expect($response->json('reply'))->toBe('Welcome to SATFYF!');

        $conversation = ChatConversation::query()->findOrFail($response->json('conversation_id'));
        expect($conversation->messages)->toHaveCount(2);
        expect($conversation->messages->first()->content)->toBe('What is SATFYF?');
        expect($conversation->messages->last()->content)->toBe('Welcome to SATFYF!');
    });

    it('appends to an existing conversation instead of creating a new one', function () {
        fakeAnthropicReply();
        $conversation = ChatConversation::factory()->create();
        ChatMessage::factory()->for($conversation)->create();

        $response = $this->postJson(route('chat.messages.store'), [
            'message' => 'A follow-up question',
            'conversation_id' => $conversation->id,
        ]);

        $response->assertOk();
        expect($response->json('conversation_id'))->toBe($conversation->id);
        expect($conversation->messages()->count())->toBe(3);
    });

    it('rejects a blank message', function () {
        $response = $this->postJson(route('chat.messages.store'), ['message' => '']);

        $response->assertJsonValidationErrors('message');
    });

    it('rejects a message over the length limit', function () {
        $response = $this->postJson(route('chat.messages.store'), ['message' => str_repeat('a', 1001)]);

        $response->assertJsonValidationErrors('message');
    });

    it('returns a graceful fallback when the Anthropic API call fails', function () {
        Http::fake(['api.anthropic.com/*' => Http::response('Server error', 500)]);

        $response = $this->postJson(route('chat.messages.store'), ['message' => 'Hello']);

        $response->assertOk();
        expect($response->json('reply'))->toContain('having trouble');
    });

    it('skips the API entirely once the daily message cap is reached', function () {
        config(['services.anthropic.daily_message_cap' => 1]);
        fakeAnthropicReply();

        $this->postJson(route('chat.messages.store'), ['message' => 'First message']);
        Http::fake(); // reset the recorded requests before the second call
        fakeAnthropicReply();

        $response = $this->postJson(route('chat.messages.store'), ['message' => 'Second message']);

        $response->assertOk();
        expect($response->json('reply'))->toContain('having trouble');
        Http::assertNothingSent();
    });
});

describe('show', function () {
    it('returns a conversation\'s messages in order', function () {
        $conversation = ChatConversation::factory()->create();
        $second = ChatMessage::factory()->for($conversation)->create(['content' => 'Second']);
        $second->forceFill(['created_at' => now()->addMinute()])->save();
        $first = ChatMessage::factory()->for($conversation)->create(['content' => 'First']);
        $first->forceFill(['created_at' => now()->subMinute()])->save();

        $response = $this->getJson(route('chat.conversations.show', $conversation));

        $response->assertOk();
        $contents = collect($response->json('messages'))->pluck('content');
        expect($contents->first())->toBe('First');
        expect($contents->last())->toBe('Second');
    });

    it('returns 404 for an unknown conversation', function () {
        $response = $this->getJson(route('chat.conversations.show', ['conversation' => (string) Str::uuid()]));

        $response->assertNotFound();
    });
});
