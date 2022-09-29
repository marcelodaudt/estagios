<?php

$estagios =  [
    [
        'text' => 'Listar',
        'url'  => config('app.url') . '/estagios',
        'can'  => 'admin_ou_empresa'
    ],
    [
        'text' => 'Cadastrar',
        'url'  => config('app.url') . '/estagios/create',
        'can'  => 'empresa'
    ],
];

$vagas =  [
    [
        'text' => 'Listar',
        'url'  => config('app.url') . '/vagas',
        'can'  => 'logado',
    ],
    
    [
        'text' => 'Cadastrar',
        'url'  => config('app.url') . '/vagas/create',
        'can'  => 'logado',
    ],
];

$empresas =  [
    [
        'text' => 'Listar',
        'url'  => config('app.url') . '/empresas',
    ],
    [
        'text' => 'Cadastrar',
        'url'  => config('app.url') . '/empresas/create',
    ],
];

$avisos =  [
    [
        'text' => 'Listar',
        'url'  => config('app.url') . '/avisos',
    ],
    [
        'text' => 'Cadastrar',
        'url'  => config('app.url') . '/avisos/create',
        'can'     => 'admin',
    ],
];

$pareceristas =  [
    [
        'text' => 'Listar',
        'url'  => config('app.url') . '/pareceristas',
        'can'     => 'admin',
    ],
    [
        'text' => 'Cadastrar',
        'url'  => config('app.url') . '/pareceristas/create',
        'can'     => 'admin',
    ],
];

$menudoparecerista =  [
    [
        'text' => 'Todos os meus Pareceres',
        'url'  => config('app.url') . '/meus_pareceres',
        'can'     => 'parecerista',
    ],
    [
        'text' => 'Estágios para Parecer de Mérito e Análises de Aditivo',
        'url'  => config('app.url') . '/parecer_merito',
        'can'     => 'parecerista',
    ],
    [
        'text' => 'Estágios Rescindidos',
        'url'  => config('app.url') . '/estagios_rescindidos',
        'can'     => 'parecerista',
    ],
];

$right_menu = [
    [
        'text'   => '<i class="fas fa-cog"></i>',
        'title'  => 'logs',
        'target' => '_blank',
        'url'    => config('app.url') . '/logs',
        'align'  => 'right',
        'can'    => 'admin',
    ],
];


return [
    'title' => config('app.name'),
    #'dashboard_url' => '/estagios',
    'skin' => env('USP_THEME_SKIN', 'uspdev'),
    'app_url' => config('app.url'),
    'logout_method' => 'POST',
    'logout_url' => config('app.url') . '/logout',
    'login_url' => config('app.url') . '/login/usp',
    'right_menu' => $right_menu,
    'menu' => [
        [
            'text'    => 'Mural de Vagas',
            'submenu' => $vagas,
            'can'     => 'logado',
        ],
        [
            'text'    => 'Estágios',
            'submenu' => $estagios,
            'can'     => 'admin_ou_empresa',
        ],
        [
            'text'    => 'Empresas',
            'submenu' => $empresas,
            'can'     => 'admin',
        ],
        [
            'text'    => 'Avisos',
            'submenu' => $avisos,
            'can'     => 'admin',
        ],
        [
            'text'    => 'Pareceristas',
            'submenu' => $pareceristas,
            'can'     => 'admin',
        ],
        [
            'text'    => 'Atualização do Cadastro  da Empresa',
            'url'     => config('app.url') . '/empresa_update',
            'can'     => 'empresa',
        ],

        [
            'text'    => 'Acessar Pareceres',
            'submenu' => $menudoparecerista,
            'can'     => 'parecerista',
        ],

        [
            'text'    => 'Estatísticas do Sistema',
            'url'     => config('app.url') . '/estatisticas',
            'can'     => 'logado',
        ],
    ]
];