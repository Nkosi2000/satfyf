<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class MarkdownPreviewController extends Controller
{
    public function store(Request $request): string
    {
        return Str::markdown((string) $request->string('body'));
    }
}
