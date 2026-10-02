<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\SiteSetting;
use Illuminate\Support\Collection;
use Illuminate\View\View;

/**
 * The pages linked from the secondary nav bar (Quit Support, Media & Press,
 * Reports, Volunteer, Donate). Each is driven by its own SiteSetting group
 * so admins edit it under Admin → Pages.
 */
class SupportPageController extends Controller
{
    public function quitSupport(): View
    {
        $content = SiteSetting::group('quit_support');

        return view('pages.quit-support', [
            'content' => $content,
            'steps' => $this->numberedItems($content, 'quit_support_step', 3),
            'helplines' => $this->numberedItems($content, 'quit_support_helpline', 3, ['name', 'contact']),
        ]);
    }

    public function media(): View
    {
        return view('pages.media', [
            'content' => SiteSetting::group('media'),
            'articles' => Article::cachedRecent(),
        ]);
    }

    public function reports(): View
    {
        $content = SiteSetting::group('reports');

        return view('pages.reports', [
            'content' => $content,
            'reports' => $this->numberedItems($content, 'reports_item', 6, ['title', 'body', 'url']),
        ]);
    }

    public function volunteer(): View
    {
        $content = SiteSetting::group('volunteer');

        return view('pages.volunteer', [
            'content' => $content,
            'roles' => $this->numberedItems($content, 'volunteer_role', 3),
        ]);
    }

    public function donate(): View
    {
        $content = SiteSetting::group('donate');

        return view('pages.donate', [
            'content' => $content,
            'impacts' => $this->numberedItems($content, 'donate_impact', 3),
        ]);
    }

    /**
     * Collects numbered settings (e.g. volunteer_role_1_title, _1_body, ...)
     * into a list of items, skipping any whose first field is empty so
     * admins can hide an item by clearing it.
     *
     * @param  array<string, string|null>  $content
     * @param  array<int, string>  $fields
     * @return Collection<int, array<string, string>>
     */
    protected function numberedItems(array $content, string $prefix, int $count, array $fields = ['title', 'body']): Collection
    {
        return collect(range(1, $count))
            ->map(fn (int $i): array => collect($fields)
                ->mapWithKeys(fn (string $field): array => [$field => (string) ($content["{$prefix}_{$i}_{$field}"] ?? '')])
                ->all())
            ->filter(fn (array $item): bool => $item[$fields[0]] !== '')
            ->values();
    }
}
