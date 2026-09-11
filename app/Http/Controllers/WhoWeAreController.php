<?php

namespace App\Http\Controllers;

use App\Models\SiteSetting;
use App\Models\TeamMember;
use Illuminate\View\View;

class WhoWeAreController extends Controller
{
    public function show(): View
    {
        return view('pages.who-we-are', [
            'mission' => SiteSetting::group('mission'),
            'team' => TeamMember::query()->published()->ordered()->get(),
        ]);
    }
}
