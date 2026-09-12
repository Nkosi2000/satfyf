<?php

namespace Database\Factories;

use App\Enums\ChatMessageRole;
use App\Models\ChatConversation;
use App\Models\ChatMessage;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<ChatMessage>
 */
class ChatMessageFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'chat_conversation_id' => ChatConversation::factory(),
            'role' => ChatMessageRole::User,
            'content' => fake()->sentence(),
        ];
    }

    public function assistant(): static
    {
        return $this->state(fn (): array => ['role' => ChatMessageRole::Assistant]);
    }
}
