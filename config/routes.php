<?php

declare(strict_types=1);

//use Kollex\UserInterface\Http\Controller\Merchant\MerchantCenter\GetMerchantOrdersController;
use App\Controller\GetUserController;
use Symfony\Component\Routing\Loader\Configurator\RoutingConfigurator;

return static function (RoutingConfigurator $routes) {
    $routes->add('getUser', '/users/{id}')
        ->controller(GetUserController::class)
        ->methods(['GET']);
};
