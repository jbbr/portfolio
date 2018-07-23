<?php

return [
    'types' => [
        'school' => 'Berufsschule',
        'business' => 'Betrieb',
    ],
    'fields' => [
        'business' => [
            'area' => 'Gebietsbezeichnung',
            'trainer' => 'Ausbilder/in'
        ],
        'school' => [
            'class' => 'Klasse',
            'teacher' => 'Lehrer',
            'room' => 'Klassenraum',
        ],
        'general' => [
            'website' => 'Webseite',
        ],
    ],
    'pdf' => [
        'Berufsschule' => 'school.name',
        'Ausbildende/r' => 'business.trainer',
        'Gebietsbezeichnung' => 'business.area',
        'Anschrift Straße / Nr.' => 'business.street',
        'PLZ / Ort' => 'business.city',
        'Rufnummer' => 'business.phone',
    ]
];
