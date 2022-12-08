Feature:
    In order to authenticate in API without cookie
    As an API user
    I want to authenticate myself only by using token gained from login endpoint

    Scenario: JWT token is missing
        When I request "/api/users" using HTTP GET
        Then the response code is 401
        Then the response body contains JSON:
        """
        {
            "code": 401,
            "message": "JWT Token not found"
        }
        """

    Scenario: JWT token is expired
        Given the "Authorization" request header contains "Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9.eyJpYXQiOjE2NzA1MDE1NzgsImV4cCI6MTY3MDUwNTE3OCwicm9sZXMiOlsiUk9MRV9VU0VSIl0sInVzZXJuYW1lIjoiZG9zaW5hYm94QGdtYWlsLmNvbSJ9.ls8Zzy8bK0_R-f89tE2JgvIEXHLWv3ypdzhtK3N01fTIbnDxP8MKUFfJg62BG5agLhA4-T4aVivvUGc_dv3u98g-ZzqMf7Mbd2Wm-P_KFOVHIyURFfoorYinyC7oK36bYJjG8tScegINxl2y2KyzzH6V7rq067Ok0yc7YWh8wBnUfkd4R6D4H55nMlHTxxVMLtyxGI2it9LoAudUQr_-HM_zN8Id-VJHTxQ3rK5pGLm1AZpQWaz7k3hVnYiE0jOuGn89sUYySolDSEP1td20raoZxRwc1rJ1dXk1GQ6yPsIbTZjNBfaCZQZOhUsWnb1qXYggOHtZ4Eo3LOkfNo17Ag"
        When I request "/api/users" using HTTP GET
        Then the response code is 401
        Then the response body contains JSON:
        """
        {
            "code": 401,
            "message": "Expired JWT Token"
        }
        """

    Scenario: JWT token is invalid
        Given the "Authorization" request header contains "Bearer invalid.token"
        When I request "/api/users" using HTTP GET
        Then the response code is 401
        Then the response body contains JSON:
        """
        {
            "code": 401,
            "message": "Invalid JWT Token"
        }
        """

        #TODO Scenario: JWT token is valid
