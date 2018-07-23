<?php

$url = 'https://fizban05.rz.tu-harburg.de/itbh/portfolio-hilfe';

return [
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
