<?php

return [

    /* MimeType => Path | null */
    'allowedMimeTypes' => [
        /* png */
        'image/png' => null,
        /* jpg */
        'image/jpeg' => null,
        /* gif */
        'image/gif' => null,
        /* pdf */
        'application/pdf' => null,

        /* doc */
        'application/msword' => '/images/filetype/doc.png',
        'application/vnd.ms-office' => '/images/filetype/doc.png',
        /* docx */
        'application/vnd.openxmlformats-officedocument.wordprocessingml.document' => '/images/filetype/docx.png',

        /* ppt */
        'application/mspowerpoint' => '/images/filetype/ppt.png',
        /* pptx */
        'application/vnd.openxmlformats-officedocument.presentationml.presentation' => '/images/filetype/pptx.png',

        /* xls */
        'application/vnd.ms-excel' => '/images/filetype/xls.png',
        /* xlsx */
        'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet' => '/images/filetype/xlsx.png',

        'video/mp4' => null,
        'audio/mpeg' => '/images/filetype/mp3.png',
        'audio/ogg' => '/images/filetype/mp3.png',
    ],

    'cropSizes' => [
        '285x180' => ['width' => 285, 'height' => 180], // PDF - Inline
        '330x100' => ['width' => 330, 'height' => 100], // Portfolio
        '150x145' => ['width' => 150, 'height' => 145], // Media, Profile, Dropdown, ...
        '328x164' => ['width' => 328, 'height' => 164], // Entry
        '1047x300' => ['width' => 1047, 'height' => 300], // Entry - Slider
        'original' => ['width' => 1000, 'height' => 1000], // PDF - Attachment
    ]
];
