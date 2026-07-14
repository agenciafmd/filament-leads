<?php

declare(strict_types=1);

return [
    'name' => 'Leads',
    'navigation_group' => null,
    'navigation_sort' => 4,
    'fields' => [
        'name' => [
            'name',
            'nome',
        ],
        'email' => [
            'e-mail',
            'email',
        ],
        'phone' => [
            'telefone',
            'phone',
            'celular',
            'mobile',
        ],
    ],
    'sources' => [
        'newsletter' => 'Newsletter',
    ],
];
