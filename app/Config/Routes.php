<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index', ['as' => 'home']);
$routes->match(['get','post'],'/login', 'Autenticacao::login', ['as' => 'login']);
$routes->match(['get', 'post'],'/contacto', 'Contacto::index', ['as' => 'contacto']);
$routes->get('/listar/medicos', 'Listar::medicos', ['as' =>'listarMedicos']);
$routes->get('/listar/utentes', 'Listar::utentes', ['as' =>'listarUtentes']);
$routes->get('/listar/consultas', 'Listar::consultas', ['as' =>'listarConsultas']);
$routes->get('/consulta/(:num)', 'Consulta::index/$1', ['as' => 'consulta']);
$routes->match(['get','post'],'/admin/create/(:any)', 'Crud::create/$1', ['as' => 'adminCreate']);
$routes->match(['get','post'],'/admin/edit/(:any)/(:num)', 'Crud::edit/$1/$2', ['as' => 'adminEdit']);
$routes->get('/admin/delete/(:any)/(:num)', 'Crud::delete/$1/$2', ['as' => 'adminDelete']);
$routes->get('/admin/medico', 'Admin::medico', ['as' => 'adminMedicos']);
$routes->get('/admin/enfermeiro', 'Admin::enfermeiro', ['as' => 'adminEnfermeiros']);
$routes->get('/admin/consulta', 'Admin::consulta', ['as' => 'adminConsultas']);
$routes->get('/admin/utente', 'Admin::utente', ['as' => 'adminUtentes']);
$routes->get('/admin/morada', 'Admin::morada', ['as' => 'adminMorada']);
$routes->get('/admin/contacto', 'Admin::contacto', ['as' => 'adminContacto']);
$routes->get('/admin/produto', 'Admin::produto', ['as' => 'adminProduto']);
$routes->get('/admin/receita', 'Admin::receita', ['as' => 'adminReceita']);