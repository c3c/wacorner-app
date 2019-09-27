<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Title
    |--------------------------------------------------------------------------
    |
    | The default title of your admin panel, this goes into the title tag
    | of your page. You can override it per page with the title section.
    | You can optionally also specify a title prefix and/or postfix.
    |
    */

    'title' => 'WAcorner',

    'title_prefix' => '',

    'title_postfix' => ' - Estatisticas direto ao ponto!',

    /*
    |--------------------------------------------------------------------------
    | Logo
    |--------------------------------------------------------------------------
    |
    | This logo is displayed at the upper left corner of your admin panel.
    | You can use basic HTML here if you want. The logo has also a mini
    | variant, used for the mini side bar. Make it 3 letters or so
    |
    */

    'logo' => ' <b><i class="fa fa-line-chart"></i> WA</b>corner',

    'logo_mini' => '<b>WA</b>c',

    /*
    |--------------------------------------------------------------------------
    | Skin Color
    |--------------------------------------------------------------------------
    |
    | Choose a skin color for your admin panel. The available skin colors:
    | blue, black, purple, yellow, red, and green. Each skin also has a
    | ligth variant: blue-light, purple-light, purple-light, etc.
    |
    */

    'skin' => 'green',

    /*
    |--------------------------------------------------------------------------
    | Layout
    |--------------------------------------------------------------------------
    |
    | Choose a layout for your admin panel. The available layout options:
    | null, 'boxed', 'fixed', 'top-nav'. null is the default, top-nav
    | removes the sidebar and places your menu in the top navbar
    |
    */

    'layout' => null,

    /*
    |--------------------------------------------------------------------------
    | Collapse Sidebar
    |--------------------------------------------------------------------------
    |
    | Here we choose and option to be able to start with a collapsed side
    | bar. To adjust your sidebar layout simply set this  either true
    | this is compatible with layouts except top-nav layout option
    |
    */

    'collapse_sidebar' => false,

    /*
    |--------------------------------------------------------------------------
    | URLs
    |--------------------------------------------------------------------------
    |
    | Register here your dashboard, logout, login and register URLs. The
    | logout URL automatically sends a POST request in Laravel 5.3 or higher.
    | You can set the request to a GET or POST with logout_method.
    | Set register_url to null if you don't want a register link.
    |
    */

    'dashboard_url' => 'admin/gestao',

    'logout_url' => 'logout',

    'logout_method' => null,

    'login_url' => 'login',

    'register_url' => 'register',

    /*
    |--------------------------------------------------------------------------
    | Menu Items
    |--------------------------------------------------------------------------
    |
    | Specify your menu items to display in the left sidebar. Each menu item
    | should have a text and and a URL. You can also specify an icon from
    | Font Awesome. A string instead of an array represents a header in sidebar
    | layout. The 'can' is a filter on Laravel's built in Gate functionality.
    |
    */

    'menu' => [
        [
            'text' => 'Voltar',
            'url'  => '/',
            'icon' => 'mail-reply-all',
        ],
        [
            'text' => 'Ao vivo',
            'url'  => 'admin/live',
            'icon' => 'heartbeat',

        ],
        [
            'text' => 'Jogos de Hoje',
            'url'  => 'admin',
            'icon' => 'calendar-o',
        ],
        [
            'text' => 'Jogos de Amanhã',
            'url'  => 'admin/amanha',
            'icon' => 'calendar-plus-o',
        ],
        'MENU PRINCIPAL',
        [
            'text' => 'Minha Gestão',
            'url'  => 'admin/gestao',
            'icon' => 'usd',
        ],
        [
            'text' => 'Meus Robôs',
            'url'  => 'admin/robos',
            'icon' => 'android',
        ],
        [
            'text' => 'Estatísticas',
            'icon' => 'bar-chart',
            'submenu' =>[
                [
                    'text' => '10 min HT',
                    'url'  => 'admin/jogos/index/ht10/hoje/',
                    'icon' => 'list',
                    
                ],
                [
                    'text' => '10 a 20 min HT',
                    'url'  => 'admin/jogos/index/ht1020/hoje/',
                    'icon' => 'list',
                    
                ],
                [
                    'text' => '35 min HT',
                    'url'  => 'admin/jogos/index/ht35/hoje/',
                    'icon' => 'list',
                    
                ],
                [
                    'text' => '38 min HT',
                    'url'  => 'admin/jogos/index/ht38/hoje/',
                    'icon' => 'list',
                    
                ],
                [
                    'text' => '75 min FT',
                    'url'  => 'admin/jogos/index/ft75/hoje/',
                    'icon' => 'list',
                    
                ],
                [
                    'text' => '82 min FT',
                    'url'  => 'admin/jogos/index/ft82/hoje/',
                    'icon' => 'list',
                    
                ],
                [
                    'text' => '88 min FT',
                    'url'  => 'admin/jogos/index/ft88/hoje/',
                    'icon' => 'list',
                    
                ],
                [
                    'text' => '1º Tempo',
                    'url'  => 'admin/jogos-estatistica/index/ht1/hoje/',
                    'icon' => 'list',
                    
                ],
                [
                    'text' => '2º Tempo',
                    'url'  => 'admin/jogos-estatistica/index/ht2/hoje/',
                    'icon' => 'list',
                    
                ],
                [
                    'text' => 'Total',
                    'url'  => 'admin/jogos-estatistica/index/ft/hoje/',
                    'icon' => 'list',
                    
                ],
            ],
        ],
        // [
        //     'text' => 'Ranking',
        //     'icon' => 'star',
        //     'submenu' =>[
        //         [
        //             'text' => 'Over Ligas',
        //             'url'  => 'admin/over/ligas',
        //             'icon' => 'list',
        //         ],
        //         [
        //             'text' => 'Over Times',
        //             'url'  => 'admin/over/times',
        //             'icon' => 'list',
        //         ],
        //     ],
        // ],
        'PLANO',
        [
            
            'text' => 'Novo plano',
            'icon' => 'diamond',
            'submenu' =>[
                [
                    'text' => 'Pagar com PagSeguro',
                    'url'  => 'admin/venda',
                    'icon' => 'credit-card',
                    
                ],
                [
                    'text' => 'Pagar com PayPal',
                    'url'  => 'admin/venda/paypal',
                    'icon' => 'paypal',
                    
                ],
                [
                    'text' => 'Pagar com PicPay',
                    'url'  => 'admin/venda/picpay',
                    'icon' => 'qrcode',
                    
                ],
                [
                    'text' => 'Pagar com Tranferência',
                    'url'  => 'admin/venda/transferencia',
                    'icon' => 'exchange',
                    
                ],
                [
                    'text' => 'Cupom Promocional',
                    'url'  => 'admin/venda/cupom/promocional',
                    'icon' => 'smile-o',
                    
                ],
            
            ],
        ],
        [
            
            'text' => 'Histórico de planos',
            'url'  => 'admin/venda/show',
            'icon' => 'history',
            
        ],
        'EXTRA',
        [
            'text' => 'Estratégias',
            'url'  => 'admin/estrategias',
            'icon' => 'heart',
        ]
        
    ],

    /*
    |--------------------------------------------------------------------------
    | Menu Filters
    |--------------------------------------------------------------------------
    |
    | Choose what filters you want to include for rendering the menu.
    | You can add your own filters to this array after you've created them.
    | You can comment out the GateFilter if you don't want to use Laravel's
    | built in Gate functionality
    |
    */

    'filters' => [
        JeroenNoten\LaravelAdminLte\Menu\Filters\HrefFilter::class,
        JeroenNoten\LaravelAdminLte\Menu\Filters\ActiveFilter::class,
        JeroenNoten\LaravelAdminLte\Menu\Filters\SubmenuFilter::class,
        JeroenNoten\LaravelAdminLte\Menu\Filters\ClassesFilter::class,
        JeroenNoten\LaravelAdminLte\Menu\Filters\GateFilter::class,
    ],

    /*
    |--------------------------------------------------------------------------
    | Plugins Initialization
    |--------------------------------------------------------------------------
    |
    | Choose which JavaScript plugins should be included. At this moment,
    | only DataTables is supported as a plugin. Set the value to true
    | to include the JavaScript file from a CDN via a script tag.
    |
    */

    'plugins' => [
        'datatables' => true,
        'select2'    => true,
        'chartjs'    => true,
    ],
];
