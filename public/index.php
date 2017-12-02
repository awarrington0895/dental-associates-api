<?php
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

require '../vendor/autoload.php';
require '../src/config/db.php';

$app = new \Slim\App;

$app->options('/{routes:.+}', function ($request, $response, $args) {
    return $response;
});

$app->add(function ($req, $res, $next) {
    $response = $next($req, $res);
    return $response
                ->withHeader('Access-Control-Allow-Origin', '*')
                ->withHeader('Access-Control-Allow-Headers', 'X-Requested-With,
                              Content-Type, Accept, Origin, Authorization')
                ->withHeader('Access-Control-Allow-Methods', 
                             'GET, POST, PUT, DELETE, OPTIONS')
                ->withHeader('Content-type', 'application/json');
});

//Customer Routes
require '../src/routes/patient.php';
require '../src/routes/employee.php';
require '../src/routes/treatment.php';
require '../src/routes/appointment.php';
$app->run();