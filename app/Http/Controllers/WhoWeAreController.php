<?php

namespace App\Http\Controllers;

use App\Models\GoalImage;
use App\Models\SiteSetting;
use App\Models\TeamMember;
use Illuminate\View\View;

class WhoWeAreController extends Controller
{
    public function show(): View
    {
        return view('pages.who-we-are', [
            'mission' => SiteSetting::group('mission'),
            'content' => SiteSetting::group('who_we_are'),
            'goalImages' => GoalImage::allOrdered(),
            'team' => TeamMember::publishedOrdered(),
            'championsNetwork' => SiteSetting::group('champions_network'),
            'youthChapters' => SiteSetting::group('youth_chapters'),
        ]);
    }
}
