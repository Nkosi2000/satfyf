<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SiteSetting;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\View\View;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class SiteSettingController extends Controller
{
    public function edit(string $page, string $section): View
    {
        $config = $this->pageConfig($page, $section);

        return view('admin.settings.edit', [
            'page' => $page,
            'section' => $section,
            'pageTitle' => $config['label'],
            'settings' => $this->inPageOrder(
                SiteSetting::query()->whereIn('group', $config['groups'])->orderBy('key')->get(),
                $config,
            )->groupBy('group'),
        ]);
    }

    /**
     * Sorts settings into the order they appear on the public page: by the
     * config's `groups` order, then its `fields` order. Keys missing from
     * `fields` keep their alphabetical order after the listed ones.
     *
     * @param  Collection<int, SiteSetting>  $settings
     * @param  array{groups: array<int, string>, fields?: array<int, string>}  $config
     * @return Collection<int, SiteSetting>
     */
    protected function inPageOrder(Collection $settings, array $config): Collection
    {
        $groupPositions = array_flip($config['groups']);
        $fieldPositions = array_flip($config['fields'] ?? []);

        return $settings
            ->sortBy([
                fn (SiteSetting $a, SiteSetting $b): int => $groupPositions[$a->group] <=> $groupPositions[$b->group],
                fn (SiteSetting $a, SiteSetting $b): int => ($fieldPositions[$a->key] ?? PHP_INT_MAX) <=> ($fieldPositions[$b->key] ?? PHP_INT_MAX),
                fn (SiteSetting $a, SiteSetting $b): int => strcmp($a->key, $b->key),
            ])
            ->values();
    }

    public function update(Request $request, string $page, string $section): RedirectResponse
    {
        $config = $this->pageConfig($page, $section);

        $values = $request->validate([
            'settings' => ['required', 'array'],
            'settings.*' => ['nullable', 'array'],
            'settings.*.*' => ['nullable', 'string', 'max:5000'],
        ])['settings'];

        // Defense in depth: only ever write keys that actually belong to
        // one of this screen's configured groups, even if the request was
        // tampered with to include others.
        $allowedKeys = SiteSetting::query()->whereIn('group', $config['groups'])->pluck('key');

        foreach ($values as $key => $locales) {
            if (! $allowedKeys->contains($key)) {
                continue;
            }

            $locales = array_filter($locales, fn ($value) => $value !== null && $value !== '');

            SiteSetting::query()->where('key', $key)->update([
                'value' => $locales === [] ? null : json_encode($locales),
            ]);
        }

        SiteSetting::forgetCache();

        $redirect = match ($section) {
            'pages' => redirect()->route('admin.pages.edit', ['page' => $page]),
            'organisation' => redirect()->route('admin.organisation.edit', ['page' => $page]),
            default => redirect()->route($config['redirect']),
        };

        return $redirect->with('success', 'Settings saved.');
    }

    /**
     * @return array{label: string, section: string, groups: array<int, string>, fields?: array<int, string>, redirect?: string}
     */
    protected function pageConfig(string $page, string $section): array
    {
        $config = config("site_setting_pages.{$page}");

        if ($config === null || $config['section'] !== $section) {
            throw new NotFoundHttpException;
        }

        return $config;
    }
}
