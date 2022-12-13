Feature:
    In order to see blog posts list
    As an anonymous user
    I want to get the list of posts ids and titles

    Scenario: Blog posts are
        When I request "/blogposts"
        Then the response code is 200
        Then the response body contains JSON:
        """
        [
            {
                "id": 1,
                "title": "@variableType(string)",
                "content": "@variableType(string)",
                "author": "@variableType(string)",
                "tags": "@variableType(array)"
            }
        ]
        """
