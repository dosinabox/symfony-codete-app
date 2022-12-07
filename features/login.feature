Feature:
    In order to login with username and password
    As user
    I want to receive token

    Scenario: User is not valid (password is incorrect, Content-Type is correct)
        Given the request body is:
        """
        {
            "username": "dosinabox@gmail.com",
            "password": "incorrect password"
        }
        """
        Given the "Content-Type" request header contains "application/json"
        When I request "/api/login" using HTTP POST
        Then the response code is 401
        Then the response body contains JSON:
        """
        {
            "error": "Invalid credentials."
        }
        """

    Scenario: Content-Type is incorrect
        Given the request body is:
        """
        {
            "username": "dosinabox@gmail.com",
            "password": "123"
        }
        """
        When I request "/api/login" using HTTP POST
        Then the response code is 401
        Then the response body contains JSON:
        """
        {
            "message": "missing credentials"
        }
        """

    Scenario: User is valid (password is correct, Content-Type is correct)
        Given the request body is:
        """
        {
            "username": "dosinabox@gmail.com",
            "password": "123"
        }
        """
        Given the "Content-Type" request header contains "application/json"
        When I request "/api/login" using HTTP POST
        Then the response code is 200
        Then the response body contains JSON:
        """
        {
            "user": "dosinabox@gmail.com",
            "token": "@variableType(string)"
        }
        """
