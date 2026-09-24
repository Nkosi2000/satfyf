<?php

namespace App\Services\Chat;

use App\Models\Article;
use App\Models\EventItem;
use App\Models\FaqItem;
use App\Models\Partner;
use App\Models\Program;
use App\Models\Resource;
use App\Models\SiteSetting;
use Illuminate\Support\Str;

/**
 * Builds a compact, plain-text snapshot of the site's published content in
 * the current app locale — resolved fresh from the database on every call
 * (no caching) so SatfyfBot always answers from up-to-date content.
 */
class SiteKnowledgeBuilder
{
    public function build(): string
    {
        $sections = [
            $this->about(),
            $this->programs(),
            $this->faqs(),
            $this->upcomingEvents(),
            $this->recentArticles(),
            $this->resources(),
            $this->partners(),
        ];

        return collect($sections)->filter()->implode("\n\n");
    }

    private function about(): ?string
    {
        $overview = SiteSetting::group('overview');
        $contact = SiteSetting::group('contact');

        $lines = array_filter([
            $overview['overview'] ?? null,
            isset($contact['contact_email']) ? 'Contact email: '.$contact['contact_email'] : null,
            isset($contact['contact_phone_office']) ? 'Contact phone: '.$contact['contact_phone_office'] : null,
            isset($contact['contact_address']) ? 'Address: '.$contact['contact_address'] : null,
        ]);

        return $lines === [] ? null : "ABOUT SATFYF\n".implode("\n", $lines);
    }

    private function programs(): ?string
    {
        $programs = Program::query()->published()->ordered()->get();

        if ($programs->isEmpty()) {
            return null;
        }

        $lines = $programs->map(fn (Program $program) => '- '.$program->title.': '.Str::limit((string) $program->description, 160));

        return "PROGRAMS\n".$lines->implode("\n");
    }

    private function faqs(): ?string
    {
        $faqs = FaqItem::query()->published()->ordered()->get();

        if ($faqs->isEmpty()) {
            return null;
        }

        $lines = $faqs->map(fn (FaqItem $faq) => 'Q: '.$faq->question."\nA: ".$faq->answer);

        return "FREQUENTLY ASKED QUESTIONS\n".$lines->implode("\n\n");
    }

    private function upcomingEvents(): ?string
    {
        $events = EventItem::query()->published()->upcoming()->limit(10)->get();

        if ($events->isEmpty()) {
            return null;
        }

        $lines = $events->map(function (EventItem $event) {
            $when = $event->starts_at->translatedFormat('j F Y, H:i');
            $location = $event->location ? ' at '.$event->location : '';

            return "- {$event->title} ({$when}{$location}): ".Str::limit((string) $event->description, 120).' Link: '.route('events.show', $event);
        });

        return "UPCOMING EVENTS\n".$lines->implode("\n");
    }

    private function recentArticles(): ?string
    {
        $articles = Article::query()->published()->latest('published_at')->limit(15)->get();

        if ($articles->isEmpty()) {
            return null;
        }

        $lines = $articles->map(fn (Article $article) => '- '.$article->title.': '.Str::limit((string) $article->excerpt, 160).' Link: '.route('articles.show', $article));

        return "RECENT ARTICLES\n".$lines->implode("\n");
    }

    private function resources(): ?string
    {
        $resources = Resource::query()->published()->get();

        if ($resources->isEmpty()) {
            return null;
        }

        $lines = $resources->map(fn (Resource $resource) => "- {$resource->title} ({$resource->category}): ".Str::limit((string) $resource->description, 120).' Download: '.route('resources.download', $resource));

        return "DOWNLOADABLE RESOURCES\n".$lines->implode("\n");
    }

    private function partners(): ?string
    {
        $partners = Partner::query()->published()->ordered()->get();

        if ($partners->isEmpty()) {
            return null;
        }

        $lines = $partners->map(fn (Partner $partner) => '- '.$partner->name.' ('.$partner->type->value.')');

        return "PARTNERS\n".$lines->implode("\n");
    }
}
