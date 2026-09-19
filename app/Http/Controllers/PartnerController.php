<?php

namespace App\Http\Controllers;

use App\Enums\PartnerType;
use App\Models\Partner;
use Illuminate\View\View;

class PartnerController extends Controller
{
    public function index(): View
    {
        $partners = Partner::publishedOrdered();

        return view('pages.partners', [
            'partners' => $partners->groupBy(fn (Partner $partner) => $partner->type->value),
            'types' => PartnerType::cases(),
        ]);
    }
}
