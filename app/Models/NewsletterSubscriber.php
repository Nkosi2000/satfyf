<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

#[Fillable(['email', 'subscribed_at'])]
class NewsletterSubscriber extends Model
{
    /** @use HasFactory<\Database\Factories\NewsletterSubscriberFactory> */
    use HasFactory, HasUuids;

    protected function casts(): array
    {
        return [
            'subscribed_at' => 'datetime',
        ];
    }
}
