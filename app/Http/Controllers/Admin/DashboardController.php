<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\ContactSubmission;
use App\Models\EventItem;
use App\Models\GalleryImage;
use App\Models\NewsletterSubscriber;
use App\Models\Partner;
use App\Models\Program;
use App\Models\Resource;
use App\Models\TeamMember;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        return view('admin.dashboard', [
            'counts' => [
                'Articles' => Article::query()->count(),
                'Events' => EventItem::query()->count(),
                'Programs' => Program::query()->count(),
                'Team members' => TeamMember::query()->count(),
                'Resources' => Resource::query()->count(),
                'Gallery images' => GalleryImage::query()->count(),
                'Partners' => Partner::query()->count(),
            ],
            'recentSubmissions' => ContactSubmission::query()->latest()->take(5)->get(),
            'recentSubscribers' => NewsletterSubscriber::query()->latest('subscribed_at')->take(5)->get(),
            'unreadCount' => ContactSubmission::query()->where('is_read', false)->count(),
        ]);
    }
}
