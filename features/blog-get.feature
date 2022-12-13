Feature:
    In order to read the blog post
    As an anonymous user
    I want to see post title, content and tags

    Scenario: Blog post exist
        When I request "/blogposts/1" using HTTP GET
        Then the response code is 200
        Then the response body contains JSON:
        """
        {
            "id": 1,
            "title": "@variableType(string)",
            "content": "@variableType(string)",
            "author": "@variableType(string)",
            "tags": "@variableType(array)"
        }
        """

    Scenario: Blog post does not exist
        When I request "/blogposts/0"
        Then the response code is 404
