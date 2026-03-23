<?php

require_once __DIR__ . '/../vendor/autoload.php';

use App\Core\Router;
use App\Controllers\FilmController;

header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type');

// OPTIONS request afhandelen (voor browsers)
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit();
}

$router = new Router();
$controller = new FilmController();

$router->get('/films',        [$controller, 'index']);
$router->get('/films/filter', [$controller, 'filter']);
$router->get('/films/{id}',   [$controller, 'show']);
$router->post('/films',       [$controller, 'store']);
$router->put('/films/{id}',   [$controller, 'update']);
$router->delete('/films/{id}',[$controller, 'destroy']);

$router->dispatch();