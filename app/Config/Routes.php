<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

$routes->setDefaultNamespace('App\Controllers');
$routes->setDefaultController('Dashboard');
$routes->setDefaultMethod('index');
$routes->setTranslateURIDashes(false);
$routes->set404Override();
$routes->setAutoRoute(true);

// Dashboard Routes
$routes->get('/', 'Dashboard::index');
$routes->get('/dashboard', 'Dashboard::index');

// Statistik Kriminalitas Routes - DIPERBAIKI
// Statistik routes
$routes->group('statistik', function($routes) {
    $routes->get('/', 'StatistikController::index');           // /statistik
    $routes->get('chart', 'StatistikController::chart');       // /statistik/chart
    $routes->get('tabel', 'StatistikController::tabel');       // /statistik/tabel
    
    // API endpoints
    $routes->get('getData', 'StatistikController::getData');           // /statistik/getData
    $routes->get('getChartData', 'StatistikController::getChartData'); // /statistik/getChartData
    $routes->get('getSummary', 'StatistikController::getSummary');     // /statistik/getSummary
});

// Peta Routes
$routes->group('peta', function($routes) {
    $routes->get('/', 'PetaController::index');
    $routes->get('data', 'PetaController::getMapData');
    $routes->post('update', 'PetaController::updateData');
});

// API Routes
$routes->group('api', function($routes) {
    $routes->get('geojson', 'ApiController::getGeoJson');
    $routes->get('markers', 'ApiController::getMarkers');
    $routes->post('incident', 'ApiController::addIncident');
});
