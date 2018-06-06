<?php

return [
    /**
     * opções de driver (sqlite, mySql)
     */
    'driver' => 'sqlite',
    
    'sqlite' => [
        'host' => 'database.db'
    ],
    
    'mysql' => [
        'host' => 'localhost',
        'database' => 'curso_microframework',
        'user' => 'root',
        'pass' => '',
        'charset' => 'utf8',
        'collation' => 'utf8_unicode_ci'
    ]
];
