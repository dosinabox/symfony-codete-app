<?php

declare(strict_types=1);

namespace App\Tests\Behat;

use Behat\Behat\Context\Context;
use Imbo\BehatApiExtension\Context\ApiContext;

final class AppContext extends ApiContext implements Context
{
    /**
     * @Then print response
     */
    public function printResponse()
    {
        echo($this->response->getBody());
    }
}
