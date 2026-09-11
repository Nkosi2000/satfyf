<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ProgramRequest;
use App\Models\Program;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class ProgramController extends Controller
{
    public function index(): View
    {
        return view('admin.programs.index', [
            'programs' => Program::query()->ordered()->paginate(20),
        ]);
    }

    public function create(): View
    {
        return view('admin.programs.create');
    }

    public function store(ProgramRequest $request): RedirectResponse
    {
        Program::query()->create($request->validated());

        return redirect()->route('admin.programs.index')->with('success', 'Programme added.');
    }

    public function edit(Program $program): View
    {
        return view('admin.programs.edit', ['program' => $program]);
    }

    public function update(ProgramRequest $request, Program $program): RedirectResponse
    {
        $program->update($request->validated());

        return redirect()->route('admin.programs.index')->with('success', 'Programme updated.');
    }

    public function destroy(Program $program): RedirectResponse
    {
        $program->delete();

        return redirect()->route('admin.programs.index')->with('success', 'Programme removed.');
    }
}
