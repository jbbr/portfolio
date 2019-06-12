<?php

$url = env('HELP_URL');

return [
    // redirects can be set, to overwrite pages with external links
    'imprint_redirect' => env('IMPRINT_URL', false),
    'privacy_redirect' => env('PRIVACY_URL', false),

    'dashboard' => $url . '/dashboard/hilfe_dashboard.html',
    'profile' => [
        'personal' => $url . '/profil/hilfe_profil_persoenlich.html',
        'locations' => $url . '/profil/hilfe_profil_lernorte.html',
        'portfolios' => $url . '/profil/hilfe_profil_aufgabenbereiche.html',
    ],
    'entry' => [
        'create' => $url . '/portfolio_eintrag/hilfe_eintrag_erstellen.html',
        'show' => $url . '/portfolio_eintrag/hilfe_eintrag_uebersicht.html',
        'list' => $url . '/aufgabenbereich/hilfe_aufgabenbereich_uebersicht.html',
    ],
    'tags' => $url . '/schlagwoerter/hilfe_schlagwoerter.html',
    'media' => $url . '/mediathek/hilfe_mediathek.html',
    'export' => $url . '/ausgabe/hilfe_ausgabe.html',
    'support' => $url . '/',
];
