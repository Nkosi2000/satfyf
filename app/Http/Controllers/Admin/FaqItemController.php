<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\FaqItemRequest;
use App\Models\FaqItem;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class FaqItemController extends Controller
{
    public function index(): View
    {
        return view('admin.faqs.index', [
            'faqs' => FaqItem::query()->ordered()->paginate(20),
        ]);
    }

    public function create(): View
    {
        return view('admin.faqs.create');
    }

    public function store(FaqItemRequest $request): RedirectResponse
    {
        FaqItem::query()->create($request->validated());

        return redirect()->route('admin.faqs.index')->with('success', 'FAQ added.');
    }

    public function edit(FaqItem $faq): View
    {
        return view('admin.faqs.edit', ['faq' => $faq]);
    }

    public function update(FaqItemRequest $request, FaqItem $faq): RedirectResponse
    {
        $faq->update($request->validated());

        return redirect()->route('admin.faqs.index')->with('success', 'FAQ updated.');
    }

    public function destroy(FaqItem $faq): RedirectResponse
    {
        $faq->delete();

        return redirect()->route('admin.faqs.index')->with('success', 'FAQ removed.');
    }
}
