Feature:
    Test 1

    Scenario: It receives a response from application URL
        When I request "/users/1" using HTTP GET
        Then print response
        Then the response body contains JSON:
        """
        {
          "message": "@variableType(string)"
        }
        """
