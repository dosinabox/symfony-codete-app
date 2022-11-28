<?php

declare(strict_types=1);

use App\Controller\GetUserController;
use App\Controller\CreateUserController;
use App\Controller\ListUsersController;
use Symfony\Component\Routing\Loader\Configurator\RoutingConfigurator;

return static function (RoutingConfigurator $routes) {
    $routes->add('getUser', '/users/{id}')
        ->controller(GetUserController::class)
        ->methods(['GET']);

    $routes->add('listUsers', '/users')
        ->controller(ListUsersController::class)
        ->methods(['GET']);

    $routes->add('addUser', '/users')
        ->controller(CreateUserController::class)
        ->methods(['POST']);
};
