<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ProvinceRequest;
use App\Models\Province;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class ProvinceController extends Controller
{
    public function index(): View
    {
        return view('admin.provinces.index', [
            'provinces' => Province::query()->ordered()->get(),
        ]);
    }

    public function create(): View
    {
        return view('admin.provinces.create');
    }

    public function store(ProvinceRequest $request): RedirectResponse
    {
        Province::query()->create($request->validated());

        return redirect()->route('admin.provinces.index')->with('success', 'Province added.');
    }

    public function edit(Province $province): View
    {
        return view('admin.provinces.edit', ['province' => $province]);
    }

    public function update(ProvinceRequest $request, Province $province): RedirectResponse
    {
        $province->update($request->validated());

        return redirect()->route('admin.provinces.index')->with('success', 'Province updated.');
    }

    public function destroy(Province $province): RedirectResponse
    {
        $province->delete();

        return redirect()->route('admin.provinces.index')->with('success', 'Province removed.');
    }
}
