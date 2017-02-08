<?php

$EM_CONF[$_EXTKEY] = [
    'title' => 'Koning: Phinx Integration',
    'description' => 'Phinx.org integration for Database Migrations',
    'category' => 'services',
    'version' => '1.0.0',
    'state' => 'stable',
    'clearCacheOnLoad' => true,
    'author' => 'Benjamin Serfhos',
    'author_email' => 'benjamin@serfhos.com',
    'author_company' => 'Koninklijke Collective',
    'constraints' => [
        'depends' => [
            'typo3' => '7.6.0-',
        ],
        'conflicts' => [],
        'suggests' => [],
    ],
    'autoload' => [
        'psr-4' => [
            'KoninklijkeCollective\\KoningPhinx\\' => 'Classes'
        ]
    ],
];
