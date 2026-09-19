<?php

namespace App\Http\Controllers;

use App\Enums\ProgramCategory;
use App\Models\Program;
use Illuminate\View\View;

class WhatWeDoController extends Controller
{
    public function index(): View
    {
        $programs = Program::publishedOrdered();

        return view('pages.what-we-do', [
            'grouped' => collect(ProgramCategory::cases())
                ->map(fn (ProgramCategory $category) => [
                    'category' => $category,
                    'programs' => $programs->where('category', $category),
                ])
                ->filter(fn (array $group) => $group['programs']->isNotEmpty()),
        ]);
    }
}
