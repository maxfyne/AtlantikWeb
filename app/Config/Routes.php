<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');

$routes->get('accueil', 'Visiteur::accueil');

$routes->match(['get', 'post'],'compte', 'Visiteur::creerCompte');

$routes->match(['get', 'post'],'connexion', 'Visiteur::seConnecter');

$routes->get('liaison', 'Visiteur::voirCommandesProduits', ["filter"=> "filtreclient"]);

$routes->get('tarifs', 'Visiteur::voirTarifLiaison', ["filter"=> "filtreclient"]);

$routes->get('horaires/(:alphanum)', 'Visiteur::voirhorairesSecteurs/$1', ["filter"=> "filtreclient"]);

$routes->get('horaires', 'Visiteur::voirhorairesSecteurs', ["filter"=> "filtreclient"]);

$routes->match(['get', 'post'], 'modifier', 'Client::modifierCompte', ["filter"=> "filtreclient"]);