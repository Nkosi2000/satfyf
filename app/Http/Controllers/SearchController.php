<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\EventItem;
use App\Models\FaqItem;
use App\Models\Program;
use App\Models\Resource;
use App\Models\TeamMember;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Illuminate\View\View;

class SearchController extends Controller
{
    public function index(Request $request): View
    {
        $query = trim((string) $request->string('q'));

        return view('pages.search', [
            'query' => $query,
            'results' => $query === '' ? collect() : $this->search($query),
        ]);
    }

    /**
     * Searches in memory against already-hydrated content rather than raw
     * SQL LIKE queries against the translatable JSON columns — those need
     * a driver-specific cast (Postgres' `::text`) that breaks the sqlite
     * connection the test suite runs against. Every field below already
     * resolves through the Translatable cast to the current locale, so a
     * plain substring match is locale-correct for free. Programs, resources,
     * FAQs and team members reuse the same cached collections the public
     * pages already query, so a search costs no extra database round trips
     * beyond the article and event lookups.
     *
     * @return Collection<int, array{type: string, title: string, excerpt: ?string, url: string}>
     */
    protected function search(string $query): Collection
    {
        $matches = fn (?string $haystack): bool => $haystack !== null && Str::contains($haystack, $query, ignoreCase: true);

        $articles = Article::query()->published()->latest('published_at')->get(['id', 'slug', 'title', 'excerpt'])
            ->filter(fn (Article $article) => $matches($article->title) || $matches($article->excerpt))
            ->map(fn (Article $article) => [
                'type' => __('Article'),
                'title' => $article->title,
                'excerpt' => $article->excerpt,
                'url' => route('articles.show', $article),
            ]);

        $events = EventItem::query()->published()->get()
            ->filter(fn (EventItem $event) => $matches($event->title) || $matches($event->description))
            ->map(fn (EventItem $event) => [
                'type' => __('Event'),
                'title' => $event->title,
                'excerpt' => $event->location,
                'url' => route('events.show', $event),
            ]);

        $programs = Program::publishedOrdered()
            ->filter(fn (Program $program) => $matches($program->title) || $matches($program->description))
            ->map(fn (Program $program) => [
                'type' => __('Programme'),
                'title' => $program->title,
                'excerpt' => $program->description,
                'url' => route('what-we-do'),
            ]);

        $resources = Resource::publishedLatest()
            ->filter(fn (Resource $resource) => $matches($resource->title) || $matches($resource->description))
            ->map(fn (Resource $resource) => [
                'type' => __('Resource'),
                'title' => $resource->title,
                'excerpt' => $resource->description,
                'url' => route('resources.index'),
            ]);

        $faqs = FaqItem::publishedOrdered()
            ->filter(fn (FaqItem $faq) => $matches($faq->question) || $matches($faq->answer))
            ->map(fn (FaqItem $faq) => [
                'type' => __('FAQ'),
                'title' => $faq->question,
                'excerpt' => $faq->answer,
                'url' => route('home'),
            ]);

        $team = TeamMember::publishedOrdered()
            ->filter(fn (TeamMember $member) => $matches($member->name) || $matches($member->role))
            ->map(fn (TeamMember $member) => [
                'type' => __('Team'),
                'title' => $member->name,
                'excerpt' => $member->role,
                'url' => route('who-we-are'),
            ]);

        return $articles->concat($events)->concat($programs)->concat($resources)->concat($faqs)->concat($team)->values();
    }
}
