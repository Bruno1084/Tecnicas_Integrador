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
$routes->get('/log_out', 'Auth::logout');

//User Routes
$routes->get('/users/(:segment)', 'UserController::getOneByNickname/$1');
$routes->post('/users', 'UserController::update');

//Task Routes
$routes->get('/tasks', 'TaskController::getAll'); // Returns all not shared tasks
$routes->post('/tasks', 'TaskController::create');
$routes->post('/tasks/update/(:num)', 'TaskController::update/$1');
$routes->get('/new_task', 'TaskController::newTask');
$routes->get('/shared_tasks', 'TaskController::sharedTasks'); // Returns shared tasks

$routes->post('/tasks/share_task/(:num)', 'TaskController::addShareTask/$1');
$routes->get('/tasks/share_task/(:num)', 'TaskController::shareTask/$1');


//Subtask Routes
$routes->get('/tasks/(:num)/subtasks', 'SubTaskController::getAll/$1');
$routes->get('/tasks/(:num)/subtasks/(:num)', 'SubtaskController::getOne/$1');
$routes->get('/subtasks/new_subtask/(:num)', 'SubTaskController::newSubTask/$1');
$routes->post('/subtasks/create', 'SubTaskController::create');
$routes->post('/tasks/(:num)/subtasks/new_task', 'SubTaskController::update/$1');
$routes->get('/subtasks/(:num)', 'SubTaskController::getOne/$1');
$routes->delete('/subtasks/(:num)', 'SubTaskController::delete/$1');
