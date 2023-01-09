Feature:
    In order to read the blog post
    As an anonymous user
    I want to see post title, content and tags

    Scenario: Blog post exist (find by UUID)
        When I request "/blogposts/80a41112-947f-4f40-afa3-8d77baac448b" using HTTP GET
        Then the response code is 200
        Then the response body contains JSON:
        """
        {
            "id": 3,
            "uuid": "80a41112-947f-4f40-afa3-8d77baac448b",
            "title": "@variableType(string)",
            "content": "@variableType(string)",
            "author": "@variableType(string)",
            "tags": "@variableType(array)"
        }
        """

    Scenario: Blog post does not exist (find by UUID)
        When I request "/blogposts/80a41112-947f-4f40-afa3-8d77baac4481"
        Then the response code is 404
