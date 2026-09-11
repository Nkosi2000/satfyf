<?php

namespace App\Casts;

use Illuminate\Contracts\Database\Eloquent\CastsAttributes;
use Illuminate\Database\Eloquent\Model;

/**
 * @implements CastsAttributes<?string, array<string, string>|string>
 */
class Translatable implements CastsAttributes
{
    /**
     * @param  Model  $model
     * @param  array<string, mixed>  $attributes
     */
    public function get($model, string $key, $value, array $attributes): ?string
    {
        if ($value === null) {
            return null;
        }

        $decoded = json_decode($value, true);

        if (! is_array($decoded)) {
            return $value;
        }

        $locale = app()->getLocale();
        $fallback = config('app.fallback_locale');

        return $decoded[$locale] ?? $decoded[$fallback] ?? null;
    }

    /**
     * @param  Model  $model
     * @param  array<string, mixed>  $value
     * @param  array<string, mixed>  $attributes
     * @return array<string, ?string>
     */
    public function set($model, string $key, $value, array $attributes): array
    {
        $locales = is_array($value) ? $value : ['en' => $value];

        $locales = array_filter(
            $locales,
            fn ($localeValue) => $localeValue !== null && $localeValue !== '',
        );

        return [$key => $locales === [] ? null : json_encode($locales)];
    }
}
