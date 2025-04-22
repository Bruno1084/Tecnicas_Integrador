<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');

//User Routes
$routes->get('/users', 'UserController::getAll');
$routes->get('/users(:num)', 'UserController::getOne/$1');
$routes->post('/users', 'UserController::create');
$routes->put('/users/(:num)', 'UserController::update/$1');
$routes->delete('/users/(:num)', 'UserController::delete/$1');

//Task Routes
$routes->get('/tasks', 'TaskController::getAll');
$routes->get('/tasks(:num)', 'TaskController::getOne/$1');
$routes->post('/taks', 'TaskController::create');
$routes->put('/tasks(:num)', 'TaskController::update/$1');
$routes->delete('/delete(:num)', 'TaskController::delete/$1');

//Subtask Routes
$routes->get('/subtasks', 'SubTaskController::getAll');
$routes->get('/subtasks(:num)', 'SubTaskController::getOne/$1');
$routes->post('/subtasks', 'SubTaskController::create');
$routes->put('/subtasks(:num)', 'SubTaskController::update/$1');
$routes->delete('/subtasks(:num)', 'SubTaskController::delete/$1');