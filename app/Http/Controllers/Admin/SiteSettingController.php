<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SiteSetting;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class SiteSettingController extends Controller
{
    public function edit(string $page): View
    {
        $config = $this->pageConfig($page);

        return view('admin.settings.edit', [
            'page' => $page,
            'pageTitle' => $config['label'],
            'settings' => SiteSetting::query()
                ->whereIn('group', $config['groups'])
                ->orderBy('group')
                ->orderBy('key')
                ->get()
                ->groupBy('group'),
        ]);
    }

    public function update(Request $request, string $page): RedirectResponse
    {
        $config = $this->pageConfig($page);

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

        $redirect = $config['redirect'] === 'admin.settings.edit'
            ? redirect()->route('admin.settings.edit', ['page' => $page])
            : redirect()->route($config['redirect']);

        return $redirect->with('success', 'Settings saved.');
    }

    /**
     * @return array{label: string, groups: array<int, string>, redirect: string}
     */
    protected function pageConfig(string $page): array
    {
        $config = config("site_setting_pages.{$page}");

        if ($config === null) {
            throw new NotFoundHttpException;
        }

        return $config;
    }
}
