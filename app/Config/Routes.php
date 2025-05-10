<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
//Auth Routes
$routes->get('/', 'Auth::login');
$routes->get('/log_in', 'Auth::login');
$routes->post('/log_in', 'Auth::loginPost');
$routes->get('/sign_up', 'Auth::signUp');
$routes->post('/sign_up', 'Auth::signUpPost');

//User Routes
$routes->get('/users', 'UserController::getAll');
$routes->get('/users/(:num)', 'UserController::getOne/$1');
$routes->post('/users', 'UserController::create');
$routes->put('/users/(:num)', 'UserController::update/$1');
$routes->delete('/users/(:num)', 'UserController::delete/$1');

//Task Routes
$routes->get('/tasks', 'TaskController::getAll'); // Lista
$routes->post('/tasks', 'TaskController::create');
$routes->get('/new_task', 'TaskController::newTask');
$routes->get('/tasks/(:num)/subtasks', 'SubTaskController::getAll/$1'); // Subtareas de una tarea

//Subtask Routes
$routes->get('/subtasks', 'SubTaskController::getAll');
$routes->get('/subtasks/(:num)', 'SubTaskController::getOne/$1');
$routes->post('/subtasks', 'SubTaskController::create');
$routes->put('/subtasks/(:num)', 'SubTaskController::update/$1');
$routes->delete('/subtasks/(:num)', 'SubTaskController::delete/$1');
