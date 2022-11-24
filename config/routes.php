<?php

declare(strict_types=1);

//use Kollex\UserInterface\Http\Controller\Merchant\MerchantCenter\GetMerchantOrdersController;
use App\Controller\GetNameController;
use Symfony\Component\Routing\Loader\Configurator\RoutingConfigurator;

return static function (RoutingConfigurator $routes) {
    $routes->add('index', '/{name}')
        ->controller(GetNameController::class)
        ->methods(['GET']);
};
