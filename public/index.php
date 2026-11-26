<?php
// Front controller: todos os pedidos entram aqui
session_start();

require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../app/Core/helpers.php';

spl_autoload_register(function (string $classe) {
    foreach (['Core', 'Models', 'Controllers'] as $pasta) {
        $ficheiro = __DIR__ . "/../app/$pasta/$classe.php";
        if (is_file($ficheiro)) {
            require_once $ficheiro;
            return;
        }
    }
});

$router = new Router();

// Páginas
$router->get('/',             'PaginaController@home');
$router->get('/privacidade',  'PaginaController@privacidade');

// Autenticação
$router->get('/login',    'AuthController@formLogin');
$router->post('/login',   'AuthController@login');
$router->get('/registo',  'AuthController@formRegisto');
$router->post('/registo', 'AuthController@registo');
$router->get('/logout',   'AuthController@logout');

// Receitas (/receitas/nova tem de vir antes de /receitas/{id})
$router->get('/receitas',                'ReceitaController@index');
$router->get('/receitas/nova',           'ReceitaController@criar');
$router->post('/receitas/nova',          'ReceitaController@guardar');
$router->get('/receitas/{id}',           'ReceitaController@ver');
$router->get('/receitas/{id}/editar',    'ReceitaController@editar');
$router->post('/receitas/{id}/editar',   'ReceitaController@atualizar');
$router->post('/receitas/{id}/apagar',   'ReceitaController@apagar');

// Categorias
$router->get('/categorias',               'CategoriaController@index');
$router->get('/categorias/nova',          'CategoriaController@criar');
$router->post('/categorias/nova',         'CategoriaController@guardar');
$router->get('/categorias/{id}/editar',   'CategoriaController@editar');
$router->post('/categorias/{id}/editar',  'CategoriaController@atualizar');
$router->post('/categorias/{id}/apagar',  'CategoriaController@apagar');

// Conta (RGPD)
$router->get('/conta',          'ContaController@index');
$router->post('/conta/apagar',  'ContaController@apagar');

$router->dispatch($_SERVER['REQUEST_METHOD'], $_SERVER['REQUEST_URI']);
