Feature:
    In order to login with username and password
    As user
    I want to receive token

    Scenario: User is not valid (password is incorrect)
        Given I log in with incorrect credentials
        Then the response code is 401
        Then the response body contains JSON:
        """
        {
            "code": 401,
            "message": "Invalid credentials."
        }
        """

    Scenario: User is valid (password is correct)
        Given I log in with correct credentials
        Then the response code is 200
        Then the response body contains JSON:
        """
        {
            "token": "@variableType(string)"
        }
        """

    Scenario: Method not allowed
        When I request "/api/login_check" using HTTP GET
        Then the response code is 405
