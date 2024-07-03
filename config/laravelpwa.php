<?php

return [
    'name' => 'Bexond',
    'manifest' => [
        'name' => 'Bexond',
        'short_name' => 'Bexond',
        'start_url' => '/',
        'background_color' => '#ffffff',
        'theme_color' => '#000000',
        'display' => 'standalone',
        'orientation' => 'any',
        'status_bar' => 'black',
        'icons' => [
            '512x512' => [
                'path' => '/images/icons/bexond/512.png',
                'purpose' => 'any'
            ],
        ],
        'splash' => [
            '640x1136' => '/images/icons/splash/iphone5_splash.png',
            '750x1334' => '/images/icons/splash/iphone6_splash.png',
            '828x1792' => '/images/icons/splash/iphone6_splash.png',
            '1536x2048' => '/images/icons/splash/ipad_splash.png',
            '1668x2224' => '/images/icons/splash/ipadpro1_splash.png',
            '1242x2208' => '/images/icons/splash/ipadpro1_splash.png',
            '1242x2688' => '/images/icons/splash/ipadpro1_splash.png',
            '1125x2436' => '/images/icons/splash/ipadpro1_splash.png',
            '2048x2732' => '/images/icons/splash/ipadpro2_splash.png',
            '1668x2388' => '/images/icons/splash/ipadpro2_splash.png',
        ],
        'shortcuts' => [
            [
                'name' => 'Shortcut Link 1',
                'description' => 'Shortcut Link 1 Description',
                'url' => '/shortcutlink1',
                'icons' => [
                    "src" => "/images/icons/icon-72x72.png",
                    "purpose" => "any"
                ]
            ],
            [
                'name' => 'Shortcut Link 2',
                'description' => 'Shortcut Link 2 Description',
                'url' => '/shortcutlink2'
            ]
        ],
        'custom' => []
    ]
];
