<?php

declare(strict_types=1);

use App\Controller\GetUserController;
use App\Controller\CreateUserController;
use App\Controller\ListUsersController;
use App\Controller\UpdateUserController;
use App\Controller\DeleteUserController;
use App\Controller\CreateBlogPostController;
use App\Controller\ListBlogPostController;
use App\Controller\GetBlogPostController;
use App\Controller\UpdateBlogPostController;
use App\Controller\DeleteBlogPostController;
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

    $routes->add('api_login', '/api/login_check')
        ->methods(['POST']);

    $routes->add('apiListUsers', '/api/users')
        ->controller(ListUsersController::class)
        ->methods(['GET']);

    $routes->add('addBlogPost', '/blogposts')
        ->controller(CreateBlogPostController::class)
        ->methods(['POST']);

    $routes->add('listBlogPosts', '/blogposts')
        ->controller(ListBlogPostController::class)
        ->methods(['GET']);

    $routes->add('getBlogPost', '/blogposts/{id}')
        ->controller(GetBlogPostController::class)
        ->methods(['GET']);

    $routes->add('updateBlogPost', '/blogposts/{id}')
        ->controller(UpdateBlogPostController::class)
        ->methods(['POST']);

    $routes->add('deleteBlogPost', '/blogposts/{id}')
        ->controller(DeleteBlogPostController::class)
        ->methods(['DELETE']);
};
