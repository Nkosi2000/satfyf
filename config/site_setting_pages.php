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
//
// `groups` and `fields` are both listed in the order they appear on the
// public page, and the admin screen renders them in that same order (see
// SiteSettingController::edit) instead of alphabetically. A setting whose
// key isn't in `fields` still shows, just after the listed ones.
return [
    'home' => [
        'label' => 'Home',
        'section' => 'pages',
        // "hero" is last: it holds the shared closing banner shown at the
        // bottom of the other pages (x-ui.closing-cta), not anything at
        // the top of the home page.
        'groups' => ['overview', 'why_it_matters', 'trusted_by', 'closing_cta', 'hero'],
        'fields' => [
            'overview',
            'why_it_matters_eyebrow', 'why_it_matters_heading',
            'why_it_matters_tab_1', 'why_it_matters_tab_1_body',
            'why_it_matters_tab_2', 'why_it_matters_tab_2_body',
            'why_it_matters_tab_3', 'why_it_matters_tab_3_body',
            'why_it_matters_tab_4', 'why_it_matters_tab_4_body',
            'trusted_by_heading',
            'closing_cta_heading', 'closing_cta_body',
            'hero_eyebrow', 'hero_heading', 'hero_heading_accent', 'hero_subtext', 'hero_closing_subtext',
        ],
    ],
    'who-we-are' => [
        'label' => 'Who We Are',
        'section' => 'pages',
        'groups' => ['who_we_are', 'youth_chapters', 'champions_network'],
        'fields' => [
            'who_we_are_hero_eyebrow', 'who_we_are_hero_heading', 'who_we_are_hero_subtext',
            'who_we_are_vision_eyebrow', 'who_we_are_vision_heading',
            'who_we_are_team_eyebrow', 'who_we_are_team_heading', 'who_we_are_team_body',
            'youth_chapters_eyebrow', 'youth_chapters_heading', 'youth_chapters_intro',
            'youth_chapters_province_1', 'youth_chapters_province_2', 'youth_chapters_province_3', 'youth_chapters_province_4',
            'champions_network_heading', 'champions_network_body', 'champions_network_cta_label', 'champions_network_cta_url',
        ],
    ],
    'why-we-exist' => [
        'label' => 'Why We Exist',
        'section' => 'pages',
        'groups' => ['why_we_exist'],
        'fields' => [
            'why_we_exist_hero_eyebrow', 'why_we_exist_hero_heading', 'why_we_exist_hero_subtext',
            'why_we_exist_stat_1_label', 'why_we_exist_stat_1_body',
            'why_we_exist_stat_2_label', 'why_we_exist_stat_2_body',
            'why_we_exist_stat_3_label', 'why_we_exist_stat_3_body',
            'why_we_exist_respond_eyebrow', 'why_we_exist_respond_heading', 'why_we_exist_respond_body',
        ],
    ],
    'what-we-do' => [
        'label' => 'What We Do',
        'section' => 'pages',
        'groups' => ['what_we_do'],
        'fields' => ['what_we_do_hero_eyebrow', 'what_we_do_hero_heading', 'what_we_do_hero_subtext'],
    ],
    'get-involved' => [
        'label' => 'Get Involved',
        'section' => 'pages',
        'groups' => ['get_involved'],
        'fields' => [
            'get_involved_hero_eyebrow', 'get_involved_hero_heading', 'get_involved_hero_subtext',
            'get_involved_statement', 'get_involved_join_form_url',
            'get_involved_ways_eyebrow', 'get_involved_ways_heading',
            'get_involved_way_1_title', 'get_involved_way_1_body',
            'get_involved_way_2_title', 'get_involved_way_2_body',
            'get_involved_way_3_title', 'get_involved_way_3_body',
            'get_involved_way_4_title', 'get_involved_way_4_body',
            'get_involved_reach_eyebrow', 'get_involved_reach_heading',
            'get_involved_questions_heading',
        ],
    ],
    'contact' => [
        'label' => 'Contact',
        'section' => 'pages',
        'groups' => ['contact'],
        'fields' => [
            'contact_hero_eyebrow', 'contact_hero_heading', 'contact_hero_subtext',
            'contact_intro_body',
            'contact_address', 'contact_phone_office', 'contact_phone_mobile', 'contact_email',
        ],
    ],
    'privacy' => [
        'label' => 'Privacy & Cookies',
        'section' => 'pages',
        'groups' => ['privacy'],
        'fields' => [
            'privacy_hero_eyebrow', 'privacy_hero_heading', 'privacy_hero_subtext',
            'privacy_cookies_eyebrow', 'privacy_cookies_heading',
            'privacy_cookie_1_name', 'privacy_cookie_1_body',
            'privacy_cookie_2_name', 'privacy_cookie_2_body',
            'privacy_cookie_3_name', 'privacy_cookie_3_body',
            'privacy_storage_eyebrow', 'privacy_storage_heading', 'privacy_storage_body',
            'privacy_notrack_eyebrow', 'privacy_notrack_heading', 'privacy_notrack_body',
        ],
    ],
    'mission' => [
        'label' => 'Mission & Vision',
        'section' => 'organisation',
        'groups' => ['mission'],
        'fields' => [
            'mission_tagline',
            'vision_2030_1', 'vision_2030_1_icon',
            'vision_2030_2', 'vision_2030_2_icon',
            'vision_2030_3', 'vision_2030_3_icon',
            'org_motto',
        ],
    ],
    'social' => [
        'label' => 'Social Media',
        'section' => 'organisation',
        'groups' => ['social'],
        'fields' => ['social_facebook', 'social_instagram', 'social_twitter', 'social_youtube'],
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
