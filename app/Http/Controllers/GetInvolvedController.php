<?php

namespace App\Http\Controllers;

use App\Models\FaqItem;
use Illuminate\View\View;

class GetInvolvedController extends Controller
{
    public function show(): View
    {
        return view('pages.get-involved', [
            'faqs' => FaqItem::query()->published()->ordered()->get(),
        ]);
    }
}
