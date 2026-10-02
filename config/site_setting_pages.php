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
            'who_we_are_goals_heading', 'who_we_are_goals_intro',
            'who_we_are_goal_1', 'who_we_are_goal_2', 'who_we_are_goal_3', 'who_we_are_goal_4',
            'who_we_are_vision_eyebrow', 'who_we_are_vision_heading',
            'who_we_are_team_eyebrow', 'who_we_are_team_heading', 'who_we_are_team_body',
            'youth_chapters_eyebrow', 'youth_chapters_heading', 'youth_chapters_intro',
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
    'quit-support' => [
        'label' => 'Quit Support',
        'section' => 'pages',
        'groups' => ['quit_support'],
        'fields' => [
            'quit_support_hero_eyebrow', 'quit_support_hero_heading', 'quit_support_hero_subtext',
            'quit_support_steps_eyebrow', 'quit_support_steps_heading',
            'quit_support_step_1_title', 'quit_support_step_1_body',
            'quit_support_step_2_title', 'quit_support_step_2_body',
            'quit_support_step_3_title', 'quit_support_step_3_body',
            'quit_support_help_eyebrow', 'quit_support_help_heading', 'quit_support_help_body',
            'quit_support_helpline_1_name', 'quit_support_helpline_1_contact',
            'quit_support_helpline_2_name', 'quit_support_helpline_2_contact',
            'quit_support_helpline_3_name', 'quit_support_helpline_3_contact',
        ],
    ],
    'media' => [
        'label' => 'Media & Press',
        'section' => 'pages',
        'groups' => ['media'],
        'fields' => [
            'media_hero_eyebrow', 'media_hero_heading', 'media_hero_subtext',
            'media_contact_eyebrow', 'media_contact_heading', 'media_contact_body',
            'media_contact_name', 'media_contact_email', 'media_contact_phone',
            'media_news_eyebrow', 'media_news_heading',
            'media_brand_eyebrow', 'media_brand_heading', 'media_brand_body',
        ],
    ],
    'reports' => [
        'label' => 'Reports & Publications',
        'section' => 'pages',
        'groups' => ['reports'],
        'fields' => [
            'reports_hero_eyebrow', 'reports_hero_heading', 'reports_hero_subtext',
            'reports_list_eyebrow', 'reports_list_heading',
            'reports_item_1_title', 'reports_item_1_body', 'reports_item_1_url',
            'reports_item_2_title', 'reports_item_2_body', 'reports_item_2_url',
            'reports_item_3_title', 'reports_item_3_body', 'reports_item_3_url',
            'reports_item_4_title', 'reports_item_4_body', 'reports_item_4_url',
            'reports_item_5_title', 'reports_item_5_body', 'reports_item_5_url',
            'reports_item_6_title', 'reports_item_6_body', 'reports_item_6_url',
        ],
    ],
    'volunteer' => [
        'label' => 'Volunteer',
        'section' => 'pages',
        'groups' => ['volunteer'],
        'fields' => [
            'volunteer_hero_eyebrow', 'volunteer_hero_heading', 'volunteer_hero_subtext',
            'volunteer_roles_eyebrow', 'volunteer_roles_heading',
            'volunteer_role_1_title', 'volunteer_role_1_body',
            'volunteer_role_2_title', 'volunteer_role_2_body',
            'volunteer_role_3_title', 'volunteer_role_3_body',
            'volunteer_form_eyebrow', 'volunteer_form_heading',
        ],
    ],
    'donate' => [
        'label' => 'Donate',
        'section' => 'pages',
        'groups' => ['donate'],
        'fields' => [
            'donate_hero_eyebrow', 'donate_hero_heading', 'donate_hero_subtext',
            'donate_impact_eyebrow', 'donate_impact_heading',
            'donate_impact_1_title', 'donate_impact_1_body',
            'donate_impact_2_title', 'donate_impact_2_body',
            'donate_impact_3_title', 'donate_impact_3_body',
            'donate_bank_eyebrow', 'donate_bank_heading',
            'donate_bank_account_name', 'donate_bank_name', 'donate_bank_account_number', 'donate_bank_branch_code', 'donate_bank_reference',
            'donate_form_eyebrow', 'donate_form_heading',
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
