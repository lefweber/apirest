<?php

/**
 * API REST Nível 2 (no modelo de maturidade Richardson)
 * Arquitetura utilizada: Clean Architecture
 * Endereço configurado para a API http://localhost/api
 * Utiliza um Recurso, uma Variável e um Payload JSON
 * Sem autenticação
 * 
 * Recursos: Usuários, CRUD apenas (ainda por finalizar)
 * 
 * Dev: Felipe Weber
 */

if($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    header('Access-Control-Allow-Origin: *');
    header('Access-Control-Allow-Methods: PUT, POST, DELETE, GET, OPTIONS');
    header('Access-Control-Allow-Headers: Accept, Authorization, Content-Type');
    http_response_code(200);
    exit;
}

require __DIR__.'/vendor/autoload.php';

use \Api\Infra\UserRepoPdo;

use \Api\Adapters\Http\Router;
use \Api\Adapters\Http\Response;

use \Api\UseCases\User\UserManager;

try 
{
    $router = new Router();

    $userRepo = new UserRepoPdo();
    $variable = $router->getVariable();
    $json = $router->request->getData();

    $userManager = new UserManager($userRepo, $variable, $json);

    if($router->request->getHttpMethod() == 'POST')
        $userManager->create();
    else if($router->request->getHttpMethod() == 'GET')
        $userManager->read();
    else if($router->request->getHttpMethod() == 'PATCH')
        $userManager->update();
    else if($router->request->getHttpMethod() == 'DELETE')
        $userManager->delete();
    
    if(!$userManager->getResult())
        throw new Exception("Erro inesperado", 500);

    new Response($userManager->getData());
} 
catch (\Throwable $th) 
{
    new Response(array('Error'=>$th->getMessage()), $th->getCode());
}
