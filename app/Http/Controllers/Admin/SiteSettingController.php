<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SiteSetting;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class SiteSettingController extends Controller
{
    public function edit(): View
    {
        return view('admin.settings.edit', [
            'settings' => SiteSetting::query()->orderBy('group')->get()->groupBy('group'),
        ]);
    }

    public function update(Request $request): RedirectResponse
    {
        $values = $request->validate([
            'settings' => ['required', 'array'],
            'settings.*' => ['nullable', 'array'],
            'settings.*.*' => ['nullable', 'string', 'max:5000'],
        ])['settings'];

        foreach ($values as $key => $locales) {
            $locales = array_filter($locales, fn ($value) => $value !== null && $value !== '');

            SiteSetting::query()->where('key', $key)->update([
                'value' => $locales === [] ? null : json_encode($locales),
            ]);
        }

        SiteSetting::forgetCache();

        return redirect()->route('admin.settings.edit')->with('success', 'Settings saved.');
    }
}
