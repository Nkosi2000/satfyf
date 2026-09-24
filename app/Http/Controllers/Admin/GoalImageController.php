<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\GoalImageRequest;
use App\Models\GoalImage;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class GoalImageController extends Controller
{
    public function index(): View
    {
        return view('admin.goal-images.index', [
            'images' => GoalImage::query()->ordered()->get(),
        ]);
    }

    public function create(): View
    {
        return view('admin.goal-images.create');
    }

    public function store(GoalImageRequest $request): RedirectResponse
    {
        $data = $request->safe()->except('image');
        $data['image_path'] = $request->file('image')->store('goals', 'public');

        GoalImage::query()->create($data);

        return redirect()->route('admin.goal-images.index')->with('success', 'Image added.');
    }

    public function edit(GoalImage $goalImage): View
    {
        return view('admin.goal-images.edit', ['image' => $goalImage]);
    }

    public function update(GoalImageRequest $request, GoalImage $goalImage): RedirectResponse
    {
        $data = $request->safe()->except('image');

        if ($request->hasFile('image')) {
            if (! str_starts_with($goalImage->image_path, 'http')) {
                Storage::disk('public')->delete($goalImage->image_path);
            }

            $data['image_path'] = $request->file('image')->store('goals', 'public');
        }

        $goalImage->update($data);

        return redirect()->route('admin.goal-images.index')->with('success', 'Image updated.');
    }

    public function destroy(GoalImage $goalImage): RedirectResponse
    {
        if (! str_starts_with($goalImage->image_path, 'http')) {
            Storage::disk('public')->delete($goalImage->image_path);
        }

        $goalImage->delete();

        return redirect()->route('admin.goal-images.index')->with('success', 'Image removed.');
    }
}
