<?php

namespace App\Http\Controllers;

use App\Enums\ChatMessageRole;
use App\Http\Requests\StoreChatMessageRequest;
use App\Models\ChatConversation;
use App\Services\Chat\ClaudeChatService;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Date;

class ChatController extends Controller
{
    public function store(StoreChatMessageRequest $request, ClaudeChatService $claude): JsonResponse
    {
        $conversation = $request->validated('conversation_id')
            ? ChatConversation::query()->findOrFail($request->validated('conversation_id'))
            : ChatConversation::query()->create(['locale' => app()->getLocale()]);

        $conversation->messages()->create([
            'role' => ChatMessageRole::User,
            'content' => $request->validated('message'),
        ]);

        $reply = $this->dailyCapReached()
            ? ClaudeChatService::FALLBACK_MESSAGE
            : $claude->respond($conversation);

        $conversation->messages()->create([
            'role' => ChatMessageRole::Assistant,
            'content' => $reply,
        ]);

        $conversation->update(['last_message_at' => now()]);

        return response()->json([
            'conversation_id' => $conversation->id,
            'reply' => $reply,
        ]);
    }

    public function show(ChatConversation $conversation): JsonResponse
    {
        return response()->json([
            'conversation_id' => $conversation->id,
            'messages' => $conversation->messages->map(fn ($message) => [
                'role' => $message->role->value,
                'content' => $message->content,
            ]),
        ]);
    }

    /**
     * A soft, no-infrastructure circuit breaker: once the site-wide message
     * count for today crosses the configured cap, further turns skip the API
     * entirely and get the same graceful fallback — protecting a nonprofit's
     * limited API budget from an unexpected traffic spike or scripted abuse.
     */
    private function dailyCapReached(): bool
    {
        $key = 'chat:daily-count:'.Date::today()->toDateString();
        $count = Cache::add($key, 1, now()->endOfDay()) ? 1 : Cache::increment($key);

        return $count > (int) config('services.anthropic.daily_message_cap');
    }
}
