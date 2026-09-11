<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\TeamMemberRequest;
use App\Models\TeamMember;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class TeamMemberController extends Controller
{
    public function index(): View
    {
        return view('admin.team-members.index', [
            'teamMembers' => TeamMember::query()->ordered()->paginate(20),
        ]);
    }

    public function create(): View
    {
        return view('admin.team-members.create');
    }

    public function store(TeamMemberRequest $request): RedirectResponse
    {
        $data = $request->safe()->except('photo');

        if ($request->hasFile('photo')) {
            $data['photo_path'] = $request->file('photo')->store('team', 'public');
        }

        TeamMember::query()->create($data);

        return redirect()->route('admin.team-members.index')->with('success', 'Team member added.');
    }

    public function edit(TeamMember $teamMember): View
    {
        return view('admin.team-members.edit', ['teamMember' => $teamMember]);
    }

    public function update(TeamMemberRequest $request, TeamMember $teamMember): RedirectResponse
    {
        $data = $request->safe()->except('photo');

        if ($request->hasFile('photo')) {
            if ($teamMember->photo_path) {
                Storage::disk('public')->delete($teamMember->photo_path);
            }

            $data['photo_path'] = $request->file('photo')->store('team', 'public');
        }

        $teamMember->update($data);

        return redirect()->route('admin.team-members.index')->with('success', 'Team member updated.');
    }

    public function destroy(TeamMember $teamMember): RedirectResponse
    {
        if ($teamMember->photo_path) {
            Storage::disk('public')->delete($teamMember->photo_path);
        }

        $teamMember->delete();

        return redirect()->route('admin.team-members.index')->with('success', 'Team member removed.');
    }
}
