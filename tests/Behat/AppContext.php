<?php

declare(strict_types=1);

namespace App\Tests\Behat;

use Behat\Behat\Context\Context;
use Imbo\BehatApiExtension\Context\ApiContext;

final class AppContext extends ApiContext implements Context
{
    private string $token = 'token';

    private string $postID;

    /**
     * @Then print response
     */
    public function printResponse()
    {
        echo($this->response->getBody());
    }

    /**
     * @Given I log in with correct credentials
     */
    public function iLoginWithCorrectCredentials()
    {
        $this->setRequestHeader('Content-Type', 'application/json');
        $this->setRequestBody('{
            "username": "dosinabox@gmail.com",
            "password": "123"
        }');
        $this->requestPath('/api/login_check', 'POST');
        $this->token = json_decode((string)$this->response->getBody())->token;
    }

    /**
     * @Given I log in with incorrect credentials
     */
    public function iLoginWithIncorrectCredentials()
    {
        $this->setRequestHeader('Content-Type', 'application/json');
        $this->setRequestBody('{
            "username": "dosinabox@gmail.com",
            "password": "incorrect password"
        }');
        $this->requestPath('/api/login_check', 'POST');
    }

    /**
     * @Given the next request contains received token
     */
    public function theNextRequestContainsReceivedToken()
    {
        $this->request = $this->request->withHeader('Authorization','Bearer ' . $this->token);
    }

    /**
     * @Then I receive test postID
     */
    public function iReceiveTestPostID()
    {
        $this->postID = json_decode((string)$this->response->getBody())->postID;
    }

    /**
     * @Given I update test post
     */
    public function iUpdateTestPost()
    {
        $this->requestPath('/blogposts/' . $this->postID, 'POST');
    }

    /**
     * @Given I delete test post
     */
    public function iDeleteTestPost()
    {
        $this->requestPath('/blogposts/' . $this->postID, 'DELETE');
    }
}
