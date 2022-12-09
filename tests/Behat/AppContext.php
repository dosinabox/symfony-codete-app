<?php

declare(strict_types=1);

namespace App\Tests\Behat;

use Behat\Behat\Context\Context;
use Imbo\BehatApiExtension\Context\ApiContext;

final class AppContext extends ApiContext implements Context
{
    private string $token;
    /**
     * @Then print response
     */
    public function printResponse()
    {
        echo($this->response->getBody());
    }
    /**
     * @Then I receive token
     */
    public function iReceiveToken()
    {
        $this->token = json_decode((string)$this->response->getBody())->token;
    }

    /**
     * @Given the next request contains received token
     */
    public function theNextRequestContainsReceivedToken()
    {
        $this->request = $this->request->withHeader('Authorization','Bearer ' . $this->token);
    }
}
