<?php

// Link lists shared by the site header (x-nav) and footer (x-footer), so a
// page added here shows up in both. Labels are translation keys — views
// pass them through __(). `danger` renders the link in the brand red.
return [
    'secondary' => [
        ['label' => 'Quit Support', 'route' => 'quit-support'],
        ['label' => 'Media & Press', 'route' => 'media'],
        ['label' => 'Reports & Publications', 'route' => 'reports'],
        ['label' => 'Volunteer', 'route' => 'volunteer'],
        ['label' => 'Donate', 'route' => 'donate', 'danger' => true],
    ],
];
