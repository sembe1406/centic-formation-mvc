<?php
// Configuration de la base de données
return [
    'database' => [
        'host' => 'localhost',
        'name' => 'centic_formation',
        'user' => 'root',
        'password' => '',
        'charset' => 'utf8',
    ],
    'app' => [
        'name' => 'Centic Formation',
        'url' => 'http://localhost/centic-formation-mvc',
        'debug' => true,
    ],
    'auth' => [
        'session_name' => 'centic_user',
        'token_lifetime' => 3600 // 1 heure
    ]
];