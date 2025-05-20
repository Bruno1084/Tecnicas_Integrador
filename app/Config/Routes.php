<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
// Auth Routes
$routes->get('/', 'Auth::login');
$routes->get('/log_in', 'Auth::login');
$routes->post('/log_in', 'Auth::loginPost');
$routes->get('/sign_up', 'Auth::signUp');
$routes->post('/sign_up', 'Auth::signUpPost');
$routes->get('/log_out', 'Auth::logout');


// User Routes
$routes->get('/users/(:num)', 'UsersController::getOne/$1');
// User Edit
$routes->get('/users/(:num)', 'UserController::getUpdate/$1');


// Task Routes
$routes->get('/tasks', 'TaskController::getAll');
$routes->get('/tasks/(:num)', 'TaskController::getOne/$1');
// Task Create
$routes->get('/tasks/create', 'TaskController::getCreate');
$routes->post('/tasks/create', 'TaskController::postCreate');
// Task Edit
$routes->get('/tasks/update/(:num)', 'TaskController::getUpdate/$1');
$routes->post('tasks/update/(:num)', 'TaskController::postUpdate/$1');
// Task Delete
$routes->get('/tasks/delete/(:num)', 'TaskController::getDelete/$1');


// Subtask Routes
$routes->get('/subtasks/(:num)', 'SubTaskController::getOne/$1');
// Subtask Create
$routes->get('/subtasks/create/(:num)', 'SubTaskController::getCreate/$1');
$routes->post('/subtasks/create', 'SubTaskController::postCreate');
// Subtask Edit
$routes->get('/subtasks/update/(:num)', 'SubTaskController::getUpdate/$1');
$routes->post('/subtasks/update/(:num)', 'SubTaskController::postUpdate/$1');
// Subtask Delete
$routes->get('/subtasks/delete/(:num)', 'SubTaskController::getDelete/$1');
