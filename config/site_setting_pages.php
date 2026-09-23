<?php

// Maps an admin settings screen (URL slug) to the SiteSetting groups it
// edits and where to send the admin after saving. Standalone pages (no
// existing CRUD screen) redirect back to themselves; pages that already
// have a CRUD admin screen (Articles, Events, Gallery, Partners,
// Resources) get their page-hero settings embedded there instead and
// redirect back to that screen.
return [
    'home' => [
        'label' => 'Home',
        'groups' => ['hero', 'why_it_matters', 'trusted_by', 'closing_cta'],
        'redirect' => 'admin.settings.edit',
    ],
    'who-we-are' => [
        'label' => 'Who We Are',
        'groups' => ['who_we_are', 'youth_chapters', 'champions_network'],
        'redirect' => 'admin.settings.edit',
    ],
    'why-we-exist' => [
        'label' => 'Why We Exist',
        'groups' => ['why_we_exist'],
        'redirect' => 'admin.settings.edit',
    ],
    'what-we-do' => [
        'label' => 'What We Do',
        'groups' => ['what_we_do'],
        'redirect' => 'admin.settings.edit',
    ],
    'get-involved' => [
        'label' => 'Get Involved',
        'groups' => ['get_involved'],
        'redirect' => 'admin.settings.edit',
    ],
    'contact' => [
        'label' => 'Contact',
        'groups' => ['contact'],
        'redirect' => 'admin.settings.edit',
    ],
    'privacy' => [
        'label' => 'Privacy & Cookies',
        'groups' => ['privacy'],
        'redirect' => 'admin.settings.edit',
    ],
    'mission' => [
        'label' => 'Mission & Vision',
        'groups' => ['mission'],
        'redirect' => 'admin.settings.edit',
    ],
    'social' => [
        'label' => 'Social Media',
        'groups' => ['social'],
        'redirect' => 'admin.settings.edit',
    ],
    'footer' => [
        'label' => 'Footer',
        'groups' => ['footer'],
        'redirect' => 'admin.settings.edit',
    ],
    'articles-page' => [
        'label' => 'Articles',
        'groups' => ['articles_page'],
        'redirect' => 'admin.articles.index',
    ],
    'events-page' => [
        'label' => 'Events',
        'groups' => ['events_page'],
        'redirect' => 'admin.events.index',
    ],
    'gallery-page' => [
        'label' => 'Gallery',
        'groups' => ['gallery_page'],
        'redirect' => 'admin.gallery-images.index',
    ],
    'partners-page' => [
        'label' => 'Partners',
        'groups' => ['partners'],
        'redirect' => 'admin.partners.index',
    ],
    'resources-page' => [
        'label' => 'Resources',
        'groups' => ['resources_page'],
        'redirect' => 'admin.resources.index',
    ],
];
