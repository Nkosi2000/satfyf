<?php

namespace App\Http\Controllers;

use App\Models\SiteSetting;
use Illuminate\View\View;

class WhyWeExistController extends Controller
{
    public function show(): View
    {
        return view('pages.why-we-exist', [
            'mission' => SiteSetting::group('mission'),
        ]);
    }
}
