<?php

namespace App\Http\Controllers;

use App\Models\SiteSetting;
use Illuminate\View\View;

class PrivacyController extends Controller
{
    public function show(): View
    {
        return view('pages.privacy', [
            'content' => SiteSetting::group('privacy'),
        ]);
    }
}
