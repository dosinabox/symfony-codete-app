<?php

declare(strict_types=1);

use App\Controller\GetUserController;
use App\Controller\CreateUserController;
use App\Controller\ListUsersController;
use App\Controller\UpdateUserController;
use App\Controller\DeleteUserController;
use Symfony\Component\Routing\Loader\Configurator\RoutingConfigurator;

return static function (RoutingConfigurator $routes) {
    $routes->add('getUser', '/users/{id}')
        ->controller(GetUserController::class)
        ->methods(['GET']);

    $routes->add('updateUser', '/users/{id}')
        ->controller(UpdateUserController::class)
        ->methods(['POST']);

    $routes->add('deleteUser', '/users/{id}')
        ->controller(DeleteUserController::class)
        ->methods(['DELETE']);

    $routes->add('listUsers', '/users')
        ->controller(ListUsersController::class)
        ->methods(['GET']);

    $routes->add('addUser', '/users')
        ->controller(CreateUserController::class)
        ->methods(['POST']);

    $routes->add('api_login', '/api/login')
        ->methods(['POST']);

    $routes->add('apiListUsers', '/api/users')
        ->controller(ListUsersController::class)
        ->methods(['GET']);
};
