<?php

namespace App\Http\Controllers;

use App\Models\FaqItem;
use App\Models\SiteSetting;
use Illuminate\View\View;

class GetInvolvedController extends Controller
{
    public function show(): View
    {
        return view('pages.get-involved', [
            'faqs' => FaqItem::query()->published()->ordered()->get(),
            'getInvolved' => SiteSetting::group('get_involved'),
        ]);
    }
}
