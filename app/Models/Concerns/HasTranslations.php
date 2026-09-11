<?php

namespace App\Models\Concerns;

use App\Casts\Translatable;

/**
 * Casts every column named in the model's $translatable array through the
 * Translatable cast, so `$model->title` transparently resolves to the
 * current locale (falling back to config('app.fallback_locale')) while
 * `$model->title = ['en' => ..., 'zu' => ...]` stores the full locale set.
 *
 * @property array<int, string> $translatable
 */
trait HasTranslations
{
    public function initializeHasTranslations(): void
    {
        $this->mergeCasts(array_fill_keys($this->translatable, Translatable::class));
    }

    /**
     * The raw, un-resolved per-locale values for a translatable field —
     * used by admin forms to prefill every locale's input at once.
     *
     * @return array<string, string>
     */
    public function translations(string $field): array
    {
        $raw = $this->getAttributes()[$field] ?? null;

        if ($raw === null) {
            return [];
        }

        $decoded = json_decode($raw, true);

        return is_array($decoded) ? $decoded : [];
    }
}
