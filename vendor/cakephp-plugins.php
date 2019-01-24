<?php
$baseDir = dirname(dirname(__FILE__));
return [
    'plugins' => [
        '.svn' => $baseDir . '/plugins/.svn/',
        'Admin' => $baseDir . '/plugins/Admin/',
        'Bake' => $baseDir . '/vendor/cakephp/bake/',
        'DebugKit' => $baseDir . '/vendor/cakephp/debug_kit/',
        'Migrations' => $baseDir . '/vendor/cakephp/migrations/',
        'Website' => $baseDir . '/plugins/Website/'
    ]
];