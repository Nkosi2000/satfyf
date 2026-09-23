<?php

// Maps an admin settings screen (URL slug) to the SiteSetting groups it
// edits, which sidebar section it lives under, and where to send the
// admin after saving.
//
// `section` drives both the URL prefix (see routes/admin.php — 'pages'
// screens live under /admin/pages/{page}, 'organisation' under
// /admin/organisation/{page}) and, for those two sections, where a save
// redirects back to (its own edit screen). Pages that already have a CRUD
// admin screen (Articles, Events, Gallery, Partners, Resources) use
// section 'embedded': their page-hero settings are shown inside that
// screen instead of a standalone one (see x-admin.page-header-panel),
// posting to the plain /admin/settings/{page} route and redirecting back
// to that CRUD screen via their own explicit `redirect` route name.
return [
    'home' => [
        'label' => 'Home',
        'section' => 'pages',
        'groups' => ['hero', 'why_it_matters', 'trusted_by', 'closing_cta'],
    ],
    'who-we-are' => [
        'label' => 'Who We Are',
        'section' => 'pages',
        'groups' => ['who_we_are', 'youth_chapters', 'champions_network'],
    ],
    'why-we-exist' => [
        'label' => 'Why We Exist',
        'section' => 'pages',
        'groups' => ['why_we_exist'],
    ],
    'what-we-do' => [
        'label' => 'What We Do',
        'section' => 'pages',
        'groups' => ['what_we_do'],
    ],
    'get-involved' => [
        'label' => 'Get Involved',
        'section' => 'pages',
        'groups' => ['get_involved'],
    ],
    'contact' => [
        'label' => 'Contact',
        'section' => 'pages',
        'groups' => ['contact'],
    ],
    'privacy' => [
        'label' => 'Privacy & Cookies',
        'section' => 'pages',
        'groups' => ['privacy'],
    ],
    'mission' => [
        'label' => 'Mission & Vision',
        'section' => 'organisation',
        'groups' => ['mission'],
    ],
    'social' => [
        'label' => 'Social Media',
        'section' => 'organisation',
        'groups' => ['social'],
    ],
    'footer' => [
        'label' => 'Footer',
        'section' => 'organisation',
        'groups' => ['footer'],
    ],
    'articles-page' => [
        'label' => 'Articles',
        'section' => 'embedded',
        'groups' => ['articles_page'],
        'redirect' => 'admin.articles.index',
    ],
    'events-page' => [
        'label' => 'Events',
        'section' => 'embedded',
        'groups' => ['events_page'],
        'redirect' => 'admin.events.index',
    ],
    'gallery-page' => [
        'label' => 'Gallery',
        'section' => 'embedded',
        'groups' => ['gallery_page'],
        'redirect' => 'admin.gallery-images.index',
    ],
    'partners-page' => [
        'label' => 'Partners',
        'section' => 'embedded',
        'groups' => ['partners'],
        'redirect' => 'admin.partners.index',
    ],
    'resources-page' => [
        'label' => 'Resources',
        'section' => 'embedded',
        'groups' => ['resources_page'],
        'redirect' => 'admin.resources.index',
    ],
];
