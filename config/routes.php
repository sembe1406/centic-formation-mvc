<?php
// Définition des routes de l'application
$router = new \App\Core\Router();

// Routes pour l'authentification
$router->get('/login', 'AuthController@loginView');
$router->post('/login', 'AuthController@login');
$router->get('/register', 'AuthController@registerView');
$router->post('/register', 'AuthController@register');
$router->get('/logout', 'AuthController@logout');

// Routes pour la page d'accueil
$router->get('/', 'HomeController@index');
$router->get('/dashboard', 'HomeController@dashboard');

// Routes pour les formations
$router->get('/formations', 'FormationController@index');
$router->get('/formations/create', 'FormationController@create');
$router->post('/formations', 'FormationController@store');
$router->get('/formations/{id}', 'FormationController@show');
$router->get('/formations/{id}/edit', 'FormationController@edit');
$router->post('/formations/{id}', 'FormationController@update');
$router->post('/formations/{id}/delete', 'FormationController@delete');

// Routes pour les formateurs
$router->get('/formateurs', 'FormateurController@index');
$router->get('/formateurs/create', 'FormateurController@create');
$router->post('/formateurs', 'FormateurController@store');
$router->get('/formateurs/{id}', 'FormateurController@show');
$router->get('/formateurs/{id}/edit', 'FormateurController@edit');
$router->post('/formateurs/{id}', 'FormateurController@update');
$router->post('/formateurs/{id}/delete', 'FormateurController@delete');

// Routes pour les participants
$router->get('/participants', 'ParticipantController@index');
$router->get('/participants/create', 'ParticipantController@create');
$router->post('/participants', 'ParticipantController@store');
$router->get('/participants/{id}', 'ParticipantController@show');
$router->get('/participants/{id}/edit', 'ParticipantController@edit');
$router->post('/participants/{id}', 'ParticipantController@update');
$router->post('/participants/{id}/delete', 'ParticipantController@delete');

// Routes pour les inscriptions
$router->get('/inscriptions', 'InscriptionController@index');
$router->get('/inscriptions/create', 'InscriptionController@create');
$router->post('/inscriptions', 'InscriptionController@store');
$router->get('/inscriptions/{id}', 'InscriptionController@show');
$router->get('/inscriptions/{id}/edit', 'InscriptionController@edit');
$router->post('/inscriptions/{id}', 'InscriptionController@update');
$router->post('/inscriptions/{id}/delete', 'InscriptionController@delete');

// Routes pour les séances
$router->get('/seances', 'SeanceController@index');
$router->get('/seances/create', 'SeanceController@create');
$router->post('/seances', 'SeanceController@store');
$router->get('/seances/{id}', 'SeanceController@show');
$router->get('/seances/{id}/edit', 'SeanceController@edit');
$router->post('/seances/{id}', 'SeanceController@update');
$router->post('/seances/{id}/delete', 'SeanceController@delete');

// Routes pour les présences
$router->get('/presences/formation/{id}', 'PresenceController@formation');
$router->get('/presences/seance/{id}', 'PresenceController@seance');
$router->post('/presences/marquer', 'PresenceController@marquer');

// Routes pour les paiements
$router->get('/paiements', 'PaiementController@index');
$router->get('/paiements/create', 'PaiementController@create');
$router->post('/paiements', 'PaiementController@store');
$router->get('/paiements/{id}', 'PaiementController@show');
$router->get('/paiements/{id}/edit', 'PaiementController@edit');
$router->post('/paiements/{id}', 'PaiementController@update');
$router->post('/paiements/{id}/delete', 'PaiementController@delete');

// Routes pour les rapports
$router->get('/rapports', 'RapportController@index');
$router->get('/rapports/formations', 'RapportController@formations');
$router->get('/rapports/participants', 'RapportController@participants');
$router->get('/rapports/presences', 'RapportController@presences');
$router->get('/rapports/paiements', 'RapportController@paiements');
$router->get('/rapports/generer', 'RapportController@generer');

// Route par défaut pour les pages non trouvées
$router->notFound(function() {
    http_response_code(404);
    echo "404 - Page non trouvée";
});