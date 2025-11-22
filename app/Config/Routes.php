<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Auth::login'); // page par défaut

// Authentification
$routes->get('/login', 'Auth::login');
$routes->post('/login', 'Auth::verify');
$routes->get('/logout', 'Auth::logout');

$routes->get('/register', 'Auth::register');
$routes->post('/register', 'Auth::save');

$routes->get('/users/edit/(:num)', 'Auth::edit/$1');    // Page modification utilisateur
$routes->post('/users/update/(:num)', 'Auth::update/$1'); // Enregistrement modifications

// Dashboard
$routes->get('/dashboard', 'Dashboard::index');

// Pages principales
$routes->get('/produits', 'Produits::index');
$routes->get('/produits/create', 'Produits::create');
$routes->post('produits/update/(:num)', 'Produits::update/$1');
$routes->post('produits/delete/(:num)', 'Produits::delete/$1');
$routes->post('/produits/store', 'Produits::store');

// Formulaire nouvelle vente (racine Produits pour compatibilité)
$routes->get('ventes', 'Produits::ventes');

$routes->post('ventes/store', 'Ventes::storeVente');

// Liste des ventes enregistrées
$routes->get('listevente', 'Ventes::index');

// Récapitulatif / reçu d'une vente
// $routes->get('ventes/recap/(:segment)', 'Produits::recap/$1');
// $routes->get('produits/recap/(:segment)', 'Produits::recap/$1'); // compatibilité ancienne URL
// Récapitulatif / reçu d'une vente 
$routes->get('ventes/recap/(:any)', 'Produits::recap/$1');
$routes->get('produits/recap/(:segment)', 'Produits::recap/$1');

$routes->get('cashpoint/new','CashPoint::create');
$routes->post('cashpoint/store','CashPoint::store');
$routes->get('cashpoint/liste','CashPoint::index');
$routes->post('cashpoint/delete/(:num)','CashPoint::delete/$1');

// AccèsCash
$routes->get('accescash/new', 'AccesCash::create');      // Formulaire nouvelle opération
$routes->post('accescash/store', 'AccesCash::store');    // Enregistrer opération
$routes->get('accescash/liste', 'AccesCash::index');     // Historique
$routes->post('accescash/delete/(:num)', 'AccesCash::delete/$1'); // Supprimer

// Clients Kits Solaires
$routes->group('clients-solaire', function($routes) {

    $routes->get('/', 'ClientSolaire::index');            // Liste clients
    $routes->get('new', 'ClientSolaire::create');         // Formulaire ajout
    $routes->post('store', 'ClientSolaire::store');       // Enregistrer
    $routes->get('(:num)', 'ClientSolaire::show/$1');     // Détail client

});


// Paiements Solaire
$routes->get('paiements-solaire', 'PaiementSolaire::index');
$routes->get('paiements-solaire/new', 'PaiementSolaire::create');
$routes->post('paiements-solaire/store', 'PaiementSolaire::store');
$routes->get('paiements-solaire/delete/(:num)', 'PaiementSolaire::delete/$1');


$routes->group('', ['namespace' => 'App\Controllers'], function($routes) {
    // Caisse
    $routes->get('caisse', 'Caisse::index');
    $routes->get('caisse/new', 'Caisse::create');
    $routes->post('caisse/store', 'Caisse::store');
});


// ==========================
// 📌 JOURNAL DE CAISSE
// ==========================
$routes->get('journal-caisse', 'JournalCaisse::index');






