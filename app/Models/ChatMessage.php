<?php

namespace App\Models;

use App\Enums\ChatMessageRole;
use Database\Factories\ChatMessageFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable(['chat_conversation_id', 'role', 'content'])]
class ChatMessage extends Model
{
    /** @use HasFactory<ChatMessageFactory> */
    use HasFactory, HasUuids;

    protected function casts(): array
    {
        return [
            'role' => ChatMessageRole::class,
        ];
    }

    /**
     * @return BelongsTo<ChatConversation, $this>
     */
    public function chatConversation(): BelongsTo
    {
        return $this->belongsTo(ChatConversation::class);
    }
}
