<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');

$routes->get('accueil', 'Visiteur::accueil');

$routes->match(['get', 'post'],'compte', 'Visiteur::creerCompte');

//$routes->match(['get', 'post'],'connexion', 'Visiteur::seConnecter');

$routes->get('liaison', 'Visiteur::liaison');